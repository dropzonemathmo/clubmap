//
//  ViewController.swift
//  hawtspot-swift
//
//  Created by john murray on 26/12/2014.
//  Copyright (c) 2014 john murray. All rights reserved.
//

import UIKit
import Foundation

class ViewController: UIViewController, GMSMapViewDelegate, CLLocationManagerDelegate {
    
    var markerTapped: Bool
    
    @IBOutlet weak var gmaps: GMSMapView!
    @IBOutlet weak var addressLabel: UILabel!
    
    let locationManager = CLLocationManager()
    
    var currentHawtspotCenter: CLLocationCoordinate2D
    var currentZoomLevel: Float
    var currentlyShowing = "bars"
    
    required init(coder aDecoder: NSCoder) {
        self.currentHawtspotCenter = CLLocationCoordinate2D(latitude: 0, longitude: 0)
        self.markerTapped = false
        self.currentZoomLevel = 0.0
        super.init(coder: aDecoder)
        locationManager.delegate = self
        locationManager.requestWhenInUseAuthorization()
    }
    
    var mapRadius: Double {
        get {
            let region = gmaps.projection.visibleRegion()
            
            let midPoint = GMSGeometryInterpolate(region.nearLeft, region.farRight, 0.5)
            
            println("\(midPoint.latitude) \(midPoint.longitude)")
            
            let verticalDistance = GMSGeometryDistance(region.farLeft, region.nearLeft)
            let horizontalDistance = GMSGeometryDistance(region.farLeft, region.farRight)
            return max(horizontalDistance, verticalDistance)*0.5
        }
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()
        locationManager.delegate = self
        locationManager.requestWhenInUseAuthorization()
        gmaps.delegate = self
        println(gmaps.settings.description)
    }
    
    @IBAction func locationTypePressed(sender: AnyObject) {
        let segmentedControl = sender as UISegmentedControl
        switch segmentedControl.selectedSegmentIndex {
        case 0:
            self.currentlyShowing = "bars"
        case 1:
            self.currentlyShowing = "clubs"
        case 2:
            self.currentlyShowing = "pubs"
        default:
            self.currentlyShowing = "bars"
        }
        self.updateHawtspotCenter()
        self.updateHawtspots()
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func mapView(mapView: GMSMapView!, markerInfoContents marker: GMSMarker!) -> UIView! {
        
        let placeMarker = marker as PlaceMarker
        println("\(placeMarker.name)")
        
        if let infoView = UIView.viewFromNibName("MarkerInfoView") as? MarkerInfoView {
            
            infoView.placeNameLabel.text = placeMarker.name
            
            let photo = UIImage(named: "club")
            infoView.placeTypeImage.image = photo
            
            let ratingString = "Google rating:\n\(placeMarker.rating)"
            infoView.placeRatingLabel.text = ratingString
            
            return infoView
            
        } else {
            return nil
        }
    }
    
    
    func mapView(mapView: GMSMapView!, didTapMarker marker: GMSMarker!) -> Bool {
        self.markerTapped = true
        return false
    }
    func mapView(mapView: GMSMapView!, didTapOverlay overlay: GMSOverlay!) {
        self.markerTapped = false
    }
    
    func mapView(mapView: GMSMapView!, willMove gesture: Bool) {
        addressLabel.lock()
    }
    
    func mapView(mapView: GMSMapView!, idleAtCameraPosition position: GMSCameraPosition!) {
        reverseGeocodeCoordinate(position.target)
        if(!isHawtspotCenterOnMap() || zoomLevelChanged()){
            updateHawtspots()
            updateHawtspotCenter()
            currentZoomLevel = gmaps.camera.zoom
        }
    }
    
    func locationManager(manager: CLLocationManager!, didChangeAuthorizationStatus status: CLAuthorizationStatus) {
        if status == .AuthorizedWhenInUse{
            locationManager.startUpdatingLocation()
            gmaps.myLocationEnabled = true
            gmaps.settings.myLocationButton = true
        }
    }
    
    func locationManager(manager: CLLocationManager!, didUpdateLocations locations: [AnyObject]!) {
        if let location = locations.first as? CLLocation{
            gmaps.camera = GMSCameraPosition(target: location.coordinate, zoom: 15, bearing: 0, viewingAngle: 0)
            locationManager.stopUpdatingLocation()
        }
    }
    
    func updateHawtspotCenter(){
        let region = gmaps.projection.visibleRegion()
        let nearLeft = region.nearLeft
        let farRight = region.farRight
        self.currentHawtspotCenter = GMSGeometryInterpolate(nearLeft, farRight, 0.5)
    }
    
    func reverseGeocodeCoordinate(coordinate: CLLocationCoordinate2D) {
        
        let geocoder = GMSGeocoder()
        
        geocoder.reverseGeocodeCoordinate(coordinate) { response , error in
            
            self.addressLabel.unlock()
            
            if let address = response?.firstResult() {
                
                let lines = address.lines as [String]
                self.addressLabel.text = join("\n", lines)
                
                let labelHeight = self.addressLabel.intrinsicContentSize().height
                self.gmaps.padding = UIEdgeInsets(top: self.topLayoutGuide.length, left: 0, bottom: labelHeight, right: 0)
                UIView.animateWithDuration(0.25) {
                    self.view.layoutIfNeeded()
                }
            }
        }
    }
    
    func zoomLevelChanged()->Bool{
        var previous = Int(currentZoomLevel)
        var current = Int(gmaps.camera.zoom)
        return previous != current
    }
    
    func isHawtspotCenterOnMap() -> Bool{
        let region = gmaps.projection.visibleRegion()
        let lat = self.currentHawtspotCenter.latitude
        let lng = self.currentHawtspotCenter.longitude
        if(lat > region.nearLeft.latitude && lat < region.farRight.latitude){
            if(lng > region.nearLeft.longitude && lng < region.farRight.longitude){
                return true
            }
        }
        return false
    }
    
    func updateHawtspots(){
        gmaps.clear()
        
        let data = dataProvider()
        
        let region = gmaps.projection.visibleRegion()
        
        //Gets the 5 json objects
        data.findPlacesInScreen(region.nearLeft, farRight: region.farRight){places in
            //loops through them
            for place:AnyObject in places {
                //Gets name
                if let name = place["name"] as? String{
                    //Gets lat
                    if let lat = place["lat"] as? Double{
                        if let lng = place["lng"] as? Double{
                            var center = CLLocationCoordinate2D(latitude: lat, longitude: lng)
                            //Calulcate the score
                            let rating = place["rating"] as? Double
                            let noRatings = place["user_ratings_total"] as? Double
                            var score = rating!*5*log(noRatings!)
                            
                            //creates marker
                            let marker = PlaceMarker(coordinate: center, name: name, rating: rating!)
                            marker.map = self.gmaps
                            
                            var circle = GMSCircle(position: center, radius: score)
                            circle.fillColor = UIColor(red: 1, green: 0, blue: 0, alpha: 0.3)
                            circle.strokeColor = UIColor.redColor()
                            circle.strokeWidth = 0.5
                            circle.map = self.gmaps
                        }
                    }
                }
            }
        }
    }

}


extension UIView{
    
    class func viewFromNibName(name: String) -> UIView? {
        let views = NSBundle.mainBundle().loadNibNamed(name, owner: nil, options: nil)
        return views.first as? UIView
    }
    
    func lock() {
        if let lockView = viewWithTag(10) {
            //View is already locked
        }
        else {
            let lockView = UIView(frame: bounds)
            lockView.backgroundColor = UIColor(white: 0.0, alpha: 0.75)
            lockView.tag = 10
            lockView.alpha = 0.0
            let activity = UIActivityIndicatorView(activityIndicatorStyle: .White)
            activity.hidesWhenStopped = true
            activity.center = lockView.center
            lockView.addSubview(activity)
            activity.startAnimating()
            addSubview(lockView)
            
            UIView.animateWithDuration(0.2) {
                lockView.alpha = 1.0
            }
        }
    }
    
    func unlock() {
        if let lockView = self.viewWithTag(10) {
            UIView.animateWithDuration(0.2, animations: {
                lockView.alpha = 0.0
                }) { finished in
                    lockView.removeFromSuperview()
            }
        }
    }
}
