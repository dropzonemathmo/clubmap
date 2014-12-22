//
//  ViewController.m
//  hawtspot
//
//  Created by john murray on 22/12/2014.
//  Copyright (c) 2014 john murray. All rights reserved.
//

#import "ViewController.h"
#import <GoogleMaps/GoogleMaps.h>

@implementation ViewController {
    GMSMapView *mapView_;
}

- (void)viewDidLoad {
    // Create a GMSCameraPosition that tells the map to display the
    // coordinate -33.86,151.20 at zoom level 6.
    GMSCameraPosition *camera = [GMSCameraPosition cameraWithLatitude:51.5072
                                                            longitude:-0.1275
                                                                 zoom:13];
    mapView_ = [GMSMapView mapWithFrame:CGRectZero camera:camera];
    mapView_.myLocationEnabled = YES;
    self.view = mapView_;
    
    
    // Getting data from json array
    
    NSData *allCoursesData = [[NSData alloc] initWithContentsOfURL:
                              [NSURL URLWithString:@"http://hawtspot.3eeweb.com/data.json"]];
    
    NSError *error;
    NSMutableDictionary *allCourses = [NSJSONSerialization
                                       JSONObjectWithData:allCoursesData
                                       options:NSJSONReadingMutableContainers
                                       error:&error];
    
    
    if( error )
    {
        NSLog(@"%@", [error localizedDescription]);
    }
    else {
        NSArray *clubs = allCourses[@"result"];
        for ( NSDictionary *club in clubs )
        {
            NSLog(@"----");
            NSLog(@"Name: %@", club[@"name"] );
            NSLog(@"Rating: %@", club[@"rating"] );
            NSLog(@"Lat: %@", club[@"lat"] );
            NSLog(@"Lgn: %@", club[@"lng"] );
            NSLog(@"----");
            
            @try {
                CLLocationCoordinate2D circleCenter = CLLocationCoordinate2DMake([club[@"lat"] floatValue], [club[@"lng"] floatValue]);
                GMSCircle *circ = [GMSCircle circleWithPosition:circleCenter
                                                         radius:[club[@"rating"] floatValue]*5*log([club[@"user_ratings_total"] floatValue])];
                
                circ.fillColor = [UIColor colorWithRed:1 green:0 blue:0 alpha:0.30];
                circ.strokeColor = [UIColor redColor];
                circ.strokeWidth = 0.5;
                circ.title = club[@"name"];
                circ.map = mapView_;
            }
            @catch (NSException *exception) {
                
            }
            

            
        }
    }
    
    
    // Creates a marker in the center of the map.
    GMSMarker *marker = [[GMSMarker alloc] init];
    marker.position = CLLocationCoordinate2DMake(51.5072, -0.1275);
    marker.title = @"Sydney";
    marker.snippet = @"Australia";
    marker.map = mapView_;
    
    
    
}

@end