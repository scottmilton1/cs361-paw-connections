<?php
include 'db.php';
//session_start();

//set variablesi
$firstName;
$email;
$lostZip;
$lostDistance;
$lostLastSent;
$timestamp;
$key = 'js-bqjXIp0ZfvQPDDly8hL0rQ0V3Dkho0FAqZx9py9F3ZuHDPfM71MySNuVrOcPPSpg';

//set array variables
$lostArray = array();
$keys= array('title', 'zipcode', 'lat', 'lng', 'text_body', 'email', 'species', 'timestamp');
$i=0;


//query table for information
//Lost and found listings
$lostStmt = "SELECT title, zipcode, lat, lng, text_body, email, species, timestamp FROM LOST_FOUND";
if($result = $mysqli->query($lostStmt)){
  while($row = $result->fetch_row()){
    $lostArray[$i] = array_combine($keys, $row);
    $i++;
  }
}

//users who've selected to received lost notifications
$stmt = $mysqli->prepare("SELECT firstName, email, lostZip, lostDistance, lostLastSent FROM individual_accounts WHERE newLost = 1");

if(!$stmt->execute()){
  echo "Execute failed: (" . $stmt->errno .") " . $stmt->error;
}
if(!$stmt->bind_result($firstName, $email, $lostZip, $lostDistance, $lostLastSent)){
  echo "bind failed: (" . $stmt->errno .") " . $stmt->error;
}
$i = 0;

//if successful, for each person
//calculate distance
$subject = 'Paw Connections - New Lost Pets!';
$headers = 'From: lost@pawconnections.net' . "\r\n" . 'Reply-To: lost@pawconnections.net' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
$message = "Here's a listing of new lost animals in your selected area" . "\r\n";

while($stmt->fetch()){
  $to = $email; 
  $website = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . $lostZip . '&sensor=false';
  $xml = file_get_contents($website);
  $obj = json_decode($xml);
  $latitude = $obj->results[0]->geometry->location->lat;
  $longitude = $obj->results[0]->geometry->location->lng;
  
  foreach($lostArray as $i){

    //compare timestamps
    if($lostLastSent < $i['timestamp']){
	  //calculate distance
	  $distance = haversine($latitude, $longitude, $i['lat'], $i['lng']);
	  if($distance < $lostDistance){
      	$message .= $i['title'] . "\r\n";
	  }
    }
  }
  echo $message;
  echo '<br>';
  echo '<br>';
  mail($to, $subject, $message, $headers);
  

  $message = "Here's a listing of new lost animals in your selected area" . "\r\n";
//    echo'<br>';
//  	echo "email: $email lostZip: $lostZip lostdistance: $lostDistance lostlastSent:$lostLastSent";
} 
$stmt->close();
$result->close();
if(!($updateStmt = $mysqli->prepare("UPDATE individual_accounts SET lostLastSent=CURRENT_TIMESTAMP"))){
  echo "Prepare failed: (" . $mysqli->errno .") " . $mysqli->error;
}

if(!$updateStmt->execute()){
  echo "Execute failed: (" . $updateStmt->errno .") " . $updateStmt->error;
}
$updateStmt->close();

function haversine($userLat, $userLng, $petLat, $petLng){
	$earthRadius = 6371;
	$usrLat = deg2rad($userLat);
	$usrLng = deg2rad($userLng);
	$ptLat = deg2rad($petLat);
	$ptLng = deg2rad($petLng);
	
	$latDelta = $ptLat - $usrLat;
	$lngDelta = $ptLng - $usrLng;
	
	$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
		cos($usrLat) * cos($ptLat) * pow(sin($lngDelta / 2), 2)));
	return $angle * $earthRadius * .621371;
}?>
