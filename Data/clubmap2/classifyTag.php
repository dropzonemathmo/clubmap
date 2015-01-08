<?php include 'db_connect.php';?>

<?php

    $mysqlli = connectToDatabase();
    $tag = $_POST["Tag"];
    $classification = $_POST["Classification"];
 

$sql = "UPDATE  placeInfo
INNER JOIN
        queryStore
ON      placeInfo.place_id = queryStore.place_id
SET     placeInfo.classification = '$classification'
WHERE   queryStore.tag = '$tag'";

if ($mysqlli->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $mysqlli->error;
}

 

   disconnectFromDatabase($mysqlli);
?>
