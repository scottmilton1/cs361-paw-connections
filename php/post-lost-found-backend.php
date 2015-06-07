<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

session_start();

$error_message = 'Unable to post listing to database.';

// connect to database
if ( !require_once('db.php') ) {
  echo $error_message;
  exit(0);
};

// DECLARE VARIABLES
$id = NULL; // auto increment

if ( !isset($_REQUEST['title'] )) {
  echo $error_message;
  exit(0);
} else {
  $title = $_REQUEST['title'];
}

if ( !isset($_REQUEST['zipcode'] )) {
  echo $error_message;
  exit(0);
} else {
  $zipcode = $_REQUEST['zipcode'];
}

if ( !isset($_REQUEST['species'] )) {
  echo $error_message;
  exit(0);
} else {
  $species = $_REQUEST['species'];
}

if ( !isset($_REQUEST['description'] )) {
  echo $error_message;
  exit(0);
} else {
  $text_body = $_REQUEST['description'];
}

$email = (isset($_REQUEST['email'])) ? $_REQUEST['email'] : '';
$tel = (isset($_REQUEST['tel'])) ? $_REQUEST['tel'] : '';
$picture_url = (isset($_REQUEST['picture_url'])) ? $_REQUEST['picture_url'] : '';
$lostfound = (isset($_REQUEST['lostfound'])) ? $_REQUEST['lostfound'] : '';

// DECLARE FUNCTIONS:

// validate title
function valid_title($title) {
  return (empty($title)) ? false : true;
}

// test zip code 
function valid_zipcode($zipcode) {
  //  if (!((preg_match("/[^0-9]/", '', $zip)) && strlen($zip) == 5)) {
  if ((preg_match("/[^0-9]/", $zipcode) || strlen($zipcode) != 5)) {
    return false;
    }
    
  return true;
}

// validate description / text_body
function valid_description($text_body) {
  return (empty($text_body)) ? false : true;
}

// validate species
function valid_species($species) {
  return (empty($species)) ? false : true;
}

// validate e-mail format
function valid_email($email) {
  if ($email === NULL || $email === '') return true;

  if (!preg_match('/@.+\..+$/', $email)) {
    return false;
  }
  return true;
}

// validate phone format
function valid_phone($number) {

  if ($number === NULL || $number === '') return true;

  if ((preg_match('/[^0-9]/', $number)) || (strlen($number) != 10)) {
    return false;
  }
    return true;
}


// valid url to photo
function valid_photo_url($url) {

  if ($url === NULL || $url === '') return true;

  return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
}

function callAPI($zipcode) {

  // set variables
  $key = '62Ty50Io9S1CNSl18FTQC9KSuP8nc97jb1Rh1zGasHNfz8hIOazqjjjO8rblAjEM';
  $statement = '/info.json/' . $zipcode . '/degrees/';
  $url = 'https://www.zipcodeapi.com/rest/' . $key . $statement;

  // initialize cURL
  // found help here: codular.com/curl-with-php
  $curl = curl_init();

  // set curl settings for API call
  curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url
  ));

  // execute API call
  $response = curl_exec($curl);

  // close curl
  curl_close($curl);

  return $response;
}

 
// add to database
function add_to_db($mysqli, $title, $zipcode, $text_body, $species, $email, $tel, $picture_url, $lostfound) {

  // step 1 - prepare the query
  $sql = 'INSERT INTO LOST_FOUND(id, title, zipcode, lat, lng, text_body, species, email, tel, picture_url, lostfound) VALUES (?,?,?,?,?,?,?,?,?,?,?);';

  // make API call to get lat and long
  $result = callAPI($zipcode);

  if (!$result) {
    echo $error_message;
    exit(0);
  }

  // decode the json response as an assoc array
  $result = json_decode($result,true);

  foreach($result as $keys => $value){
    //echo "$keys:$value\n";
    if ($keys === 'lat'){
      $lat = $value;
      //echo "from lat: " . $lat . "\n";
    }elseif($keys === 'lng'){
      $lng = $value;
      //echo "From Lng: " . $lng. "\n";
    }
  };

  // step 2 - make the prepared statement
  if (!($stmt = $mysqli->prepare($sql))) {
    echo $error_message . " ERROR 1";
    return false;
  }


  // step 3 - bind the parameters
  if (!$stmt->bind_param("isiddsssiss", $id, $title, $zipcode, $lat, $lng, $text_body, $species, $email, $tel, $picture_url, $lostfound)) {
    echo $error_message . " ERROR 2";
    return false;
  }

  // step 4 - execute the prepared statement
  if (!$stmt->execute()) {
    echo $error_message . " ERROR 3";
    echo $stmt->error;;
    return false;
  }

  // close the statement
  $stmt->close();

  // close the database connection
  $mysqli->close();

  return true;
}

// validate form data and check that required values are provided
$invalid = false;
if ( !valid_title($title)) { echo "Invalid title.\n"; $invalid = true;}
if ( !valid_zipcode($zipcode)) { echo "Invalid zip code.\n"; $invalid = true;}
if ( !valid_species($species)) { echo "Invalid species.\n"; $invalid = true;}
if ( !valid_species($text_body)) { echo "Invalid description.\n"; $invalid = true;}

if ( !valid_email($email)) { echo "Invalid e-mail.\n"; $invalid = true;}
if ( !valid_phone($tel)) { echo "Invalid phone number.\n"; $invalid = true;}
if ( !valid_photo_url($picture_url)) { echo "Invalid URL for photo.\n"; $invalid = true;}

if ( $invalid ) { exit(0); }

// call function to send posted data to db
 if (!add_to_db($mysqli, $title, $zipcode, $text_body, $species, $email, $tel, $picture_url, $lostfound)) {
   echo $error_message;
   exit(0);
 }

echo 'Success!';
exit(0);

?>
