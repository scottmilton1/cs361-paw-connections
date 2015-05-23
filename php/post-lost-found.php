<? php

$error_message = 'Unable to post listing to database.';

// get form data

// connect to database
require_once('connect.php');

// check that required values are provided


// validate e-mail format
function validate_email($email) {
	if (!preg_match('/@.+\..+$/', $email)) {
		return false;
	}
	return true;
}

// validate phone format
function validate_phone($number) {
	if (!((preg_match("/[^0-9]/", '', $number)) && strlen($number) == 10)) {
		return false;
	}
	return true;
}

// test zip code to make sure has 5 digits
function validate_zip($zip) {
	if (!((preg_match("/[^0-9]/", '', $zip)) && strlen($zip) == 5)) {
		return false;
	}
	return true;
}


// valid url to photo
function validate_photo_url($url) {
	return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
}

// add to database
// make sure that what was added to database is same as what was handed to functionality

function send_to_db() {

// step 1 - prepare the query
$sql = 'INSERT INTO LOST_FOUND(id, title, zipcode, lat, lng, text_body, species, email, tel, picture_url) VALUES (?,?,?,?,?,?,?,?,?,?);';

// step 2 - make the prepared statement
if (!($stmt = $conn->prepare($sql))) {
	return false;
}

// step 3 - bind the parameters
$id = NULL; // auto increment
$title = $_POST['title'];
$zipcode = $_POST['zipcode'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];
$text_body = $_POST['text_body'];
$species = $_POST['species'];
$email = (isset($_POST['email']) ? $_POST['email'] : NULL;
$tel = (isset($_POST['tel']) ? $_POST['tel'] : NULL;
$picture_url = (isset($_POST['picture_url']) ? $_POST['picture_url'] : NULL;

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
	$conn->close();

	return true;
}

// call function to send posted data to db
// if (!send_to_db()) {
// 		echo $error_message;
// 		exit(0);
// 	}

?>
