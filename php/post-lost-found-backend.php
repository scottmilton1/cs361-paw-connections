<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$error_message = 'Unable to post listing to database.';

// get form data

// connect to database
if ( !require_once('db.php') ) {
  echo $error_message;
  exit(0);
};

// DECLARE VARIABLES
$id = NULL; // auto increment

if ( !isset($_REQUEST['title'] )) {
  echo "1";
  exit(0);
} else {
  $title = $_REQUEST['title'];
}

if ( !isset($_REQUEST['zipcode'] )) {
  echo "2";
  exit(0);
} else {
  $title = $_REQUEST['zipcode'];
}

if ( !isset($_REQUEST['textbody'] )) {
  echo "3";
  exit(0);
} else {
  $title = $_REQUEST['textbody'];
}

if ( !isset($_REQUEST['species'] )) {
  echo "4";
  exit(0);
} else {
  $title = $_REQUEST['species'];
}


//$email = (isset($_REQUEST['email'])) ? $_REQUEST['email'] : NULL;
//$tel = (isset($_REQUEST['tel'])) ? $_REQUEST['tel'] : NULL;
//$picture_url = (isset($_REQUEST['picture_url'])) ? $_REQUEST['picture_url'] : NULL;

echo 'Success!';
exit(0);

// DECLARE FUNCTIONS:

// validate e-mail format
function valid_email($email) {
  if (!preg_match('/@.+\..+$/', $email)) {
    return false;
  }
  return true;
}

// validate phone format
function valid_phone($number) {
  if (!((preg_match("/[^0-9]/", '', $number)) && strlen($number) == 10)) {
    return false;
  }
  return true;
}

// test zip code to make sure has 5 digits
function valid_zip($zip) {
  if (!((preg_match("/[^0-9]/", '', $zip)) && strlen($zip) == 5)) {
    return false;
  }
  return true;
}


// valid url to photo
function valid_photo_url($url) {
  return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
}

// add to database
// make sure that what was added to database is same as what was handed to functionality

function add_to_db() {

// step 1 - prepare the query
$sql = 'INSERT INTO LOST_FOUND(id, title, zipcode, lat, lng, text_body, species, email, tel, picture_url) VALUES (?,?,?,?,?,?,?,?,?,?);';

// step 2 - make the prepared statement
if (!($stmt = $mysqli->prepare($sql))) {
  return false;
}

// step 3 - bind the parameters

// these won't be in _REQUEST rather from API
$lat = $_REQUEST['lat'];
$lng = $_REQUEST['lng'];

if (!$stmt->bind_param("isiddsssis", $id, $title, $zipcode, $lat, $lng, $text_body, $species, $email, $tel, $picture_url)) {
return false;
}

  // step 4 - execute the prepared statement
  if (!$stmt->execute()) {
  return false;
  }

  // close the statement
  $stmt->close();

  // close the database connection
  $mysqli->close();

  return true;
}

// check that required values are provided

// validate form data
$invalid = false;
if ( !valid_email($email)) { echo 'Invalid e-mail'; $invalid = true;}
if ( !valid_phone($tel)) { echo 'Invalid phone number'; $invalid = true;}
if ( !valid_zip($zipcode)) { echo 'Invalid zip code'; $invalid = true;}
if ( !valid_photo_url($picture_url)) { echo 'Invalid URL for photo'; $invalid = true;}

if ( $invalid ) { exit(0); }

echo 'Ready to add to database';

// add_to_db();

// call function to send posted data to db
// if (!send_to_db()) {
//    echo $error_message;
//    exit(0);
//  }

?>