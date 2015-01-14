//
//  PlaceMarker.swift
//  hawtspot-swift
//
//  Created by john murray on 24/12/2014.
//  Copyright (c) 2014 Ron Kliffer. All rights reserved.
//

import UIKit


class PlaceMarker: GMSMarker {
    // 1
    let name: String
    let rating: Double
    // 2
    init(coordinate: CLLocationCoordinate2D, name: String, rating: Double) {
        self.name = name
        self.rating = rating
        super.init()
        
        position = coordinate
        icon = UIImage(named: "dot4")
        groundAnchor = CGPoint(x: 0.5, y: 0.5)
    }
}
