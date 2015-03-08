

<?php
		$arrContextOptions=array(
		    "ssl"=>array(
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		    ),
		); 
			

	$stationCode = "2871";


	$clusterData = "data/clusters.json"; 
	$clusterDataJson = file_get_contents($clusterData,false, stream_context_create($arrContextOptions));
	$clusterDataArray = json_decode($clusterDataJson,true);
	
	$clusterNames = array();
	
	foreach ($clusterDataArray as $stationArray){
		foreach ($stationArray as $clusterKey){
			if(!in_array($clusterKey,$clusterNames)){
				$clusterNames[]=$clusterKey;	
			}
		}
	}	
	
//	var_dump($clusterNames);

	$outputArray = array();
	foreach ($clusterNames as $name){
		$clusterArray = array();
		foreach ($clusterDataArray as $stationName=>$stationArray){
			//echo $stationName;
			//var_dump($stationArray);
			//echo "<br><br>";
			if(in_array($name,$stationArray)){
				$clusterArray[] = $stationName;
			}	
		}
		$outputArray[$name] = $clusterArray;
	}	
				
	var_dump($outputArray);
	 
	file_put_contents("stationsCluster.txt", json_encode($outputArray));


/*
	//number of clusters associated with station
	$clusterCount = count($clusterDataArray[$stationCode]);
	
	
	//for each cluster open the fares file for the cluster
	for($i = 0 ; $i < $clusterCount ; $i++){
		$clusterFares = "data/fares/{$clusterDataArray[$stationCode][$i]}.json";	
		$faresClusterDataJson = file_get_contents($clusterFares,false, stream_context_create($arrContextOptions));
		$faresClusterDataArray = json_decode($faresClusterDataJson,true);
	
		echo "<h1> cluster code ";
		echo $clusterDataArray[$stationCode][$i];
		echo "</h1><br>";
		
	
		//var_dump($faresClusterDataArray);

		echo "entering cluster loop<br>";
		foreach ($faresClusterDataArray as $key =>$value){
			echo "Cluster key is ";
			echo $key;	

			// for each cluster listed find stations associated

			foreach ($clusterDataArray as $stationKey => $clusterKey){
				if ($clusterKey[$key] != NULL){
					echo "station is ";
					echo $stationKey;
					echo  " price is ";
					echo $value[0]["prices"]["CDR"][0];
					echo "<br>";
				}
			}		
		} 
	
	}

/*

	for ($z =0; $z < $types_count; $z++){
		$type[$z] = $resp["result"]["types"][$z];		
		echo "<td>";
		echo $type[$z];
		echo "</td>";
	}

	echo "<td>";
		// Insert data into database

		//end insert into database
	echo "</td>";
}

*/

?>



