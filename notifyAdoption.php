<?php
include 'db.php';
//session_start();

//set variablesi
$firstName;
$email;
$zip_code;
$adoptionDistance;
$adoptionSent;
$timestamp;
$key = 'js-bqjXIp0ZfvQPDDly8hL0rQ0V3Dkho0FAqZx9py9F3ZuHDPfM71MySNuVrOcPPSpg';

//set array variables
$adoptionArray = array();
$keys= array('title', 'zipcode', 'lat', 'lng', 'text_body', 'email', 'species', 'timestamp');
$i=0;


//query table for information
//Lost and found listings
$adoptStmt = "SELECT title, zipcode, lat, lng, text_body, email, species, timestamp FROM LOST_FOUND";
if($result = $mysqli->query($adoptStmt)){
  while($row = $result->fetch_row()){
    $adoptionArray[$i] = array_combine($keys, $row);
    $i++;
  }
}

//users who've selected to received lost notifications
$stmt = $mysqli->prepare("SELECT firstName, email, zipcode, adoptionDistance, adoptionSent FROM individual_accounts WHERE newAdoption = 1");

if(!$stmt->execute()){
  echo "Execute failed: (" . $stmt->errno .") " . $stmt->error;
}
if(!$stmt->bind_result($firstName, $email, $zip_code, $adoptionDistance, $adoptionSent)){
  echo "bind failed: (" . $stmt->errno .") " . $stmt->error;
}

$i = 0;

//if successful, for each person
//calculate distance
$subject = 'Paw Connections - New Adoptable Pets!';
$headers = 'From: adoption@pawconnections.net' . "\r\n" . 'Reply-To: adoption@pawconnections.net' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
$message = "Here's a listing of new adoptable animals in your selected area" . "\r\n";

while($stmt->fetch()){
  $to = $email; 
  $website = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . $zip_code . '&sensor=false';
  $xml = file_get_contents($website);
  $obj = json_decode($xml);
  $latitude = $obj->results[0]->geometry->location->lat;
  $longitude = $obj->results[0]->geometry->location->lng;
  
  foreach($adoptionArray as $i){

    //compare timestamps
    if($adoptionSent < $i['timestamp']){
	  //calculate distance
	  $distance = haversine($latitude, $longitude, $i['lat'], $i['lng']);
	  if($distance < $adoptionDistance){
      	$message .= $i['title'] . "\r\n";
	  }
    }
  }
  echo $message;
  echo '<br>';
  echo '<br>';
  mail($to, $subject, $message, $headers);
  $message = "Here's a listing of new adoptable animals in your selected area" . "\r\n";
//    echo'<br>';
//  	echo "email: $email zip_code: $zip_code lostdistance: $adoptionDistance lostlastSent:$adoptionSent";
} 

$result->close();
$stmt->close(); 
if(!($updateStmt = $mysqli->prepare("UPDATE individual_accounts SET adoptionSent=CURRENT_TIMESTAMP"))){
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