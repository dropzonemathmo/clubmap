//
//  dataProvider.swift
//  hawtspot-swift
//
//  Created by john murray on 26/12/2014.
//  Copyright (c) 2014 john murray. All rights reserved.
//

import Foundation

class dataProvider{
    
    
    func findPlacesInScreen( nearLeft: CLLocationCoordinate2D, farRight: CLLocationCoordinate2D, completion: (([AnyObject]) -> Void)) -> ()
    {
        //let region = gmaps.projection.visibleRegion()
        var result = Array<AnyObject>()
        
        let midPoint = GMSGeometryInterpolate(nearLeft, farRight, 0.5)
        
        // 1
        let urlAsString = "http://hawtspot.3eeweb.com/data.json"
        let url = NSURL(string: urlAsString)!
        let urlSession = NSURLSession.sharedSession()
        
        UIApplication.sharedApplication().networkActivityIndicatorVisible = true
        
        //2
        let jsonQuery = urlSession.dataTaskWithURL(url, completionHandler: { data, response, error -> Void in
            
            UIApplication.sharedApplication().networkActivityIndicatorVisible = false
            if (error != nil) {
                println(error.localizedDescription)
            }
            var err: NSError?
            
            
            // 3
            var jsonResult = NSJSONSerialization.JSONObjectWithData(data, options: NSJSONReadingOptions.MutableContainers, error: &err) as NSDictionary
            if (err != nil) {
                println("JSON Error \(err!.localizedDescription)")
            }
            
            if let results = jsonResult["result"] as? [AnyObject]{
                var noResults = results.count
                for(var i = 0; i < noResults; i++){
                    if let place = results[i] as? Dictionary<String, AnyObject>{
                        if let lat = place["lat"] as? Double{
                            if let lng = place["lng"] as? Double{
                                //println("Lat: \(lat), Lng: \(lng)")
                                if(lat > nearLeft.latitude && lat < farRight.latitude){
                                    if(lng > nearLeft.longitude && lng < farRight.longitude){
                                        if(result.count < 5){
                                            result.append(place)
                                        }
                                        else{
                                            if let newScore = place["rating"] as? Double{
                                                for(var j = 0; j < 5; j++){
                                                    if let oldScore = result[j]["rating"] as? Double{
                                                        if(newScore > oldScore){
                                                            result.removeAtIndex(j)
                                                            result.append(place)
                                                            break
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            
            dispatch_async(dispatch_get_main_queue(), {
                completion(result)
            })
        })
        // 5
        jsonQuery.resume()

    }
    
    //Failed try at function to split up larger function
    func findFiveBest(nearLeft: CLLocationCoordinate2D, farRight: CLLocationCoordinate2D) -> Array<AnyObject>{
        var result = [AnyObject]()
        
        findPlacesInScreen(nearLeft, farRight: farRight){places in
            for place in places{
                if(result.count < 5){
                    result.append(place)
                }
                else{
                    if let newScore = place["rating"] as? Double{
                        for(var i = 0; i < 5; i++){
                            if let oldScore = result[i]["rating"] as? Double{
                                if(newScore > oldScore){
                                    result.removeAtIndex(i)
                                    result.append(place)
                                    break
                                }
                            }
                        }
                    }
                }
            }
        }
        return result
    }
    
}