<?php
include 'db.php';
session_start();

/*register new individual account*/
if(isset($_POST['registerIndividual'])){
  //set variables
  if(isset($_POST['newAdopt'])){
    $newAdopt = 1;
  }else{
    $newAdopt = 0;
  }
  if(isset($_POST['newLost'])){
    $newLost = 1;
  }else{
    $newLost = 0;
  }
  $firstname = $_POST['firstName'];
  $lastname = $_POST['lastName'];
  $email = $_POST['email'];
  $zipcode = $_POST['zipcode'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $adoptionzip = $_POST['adoptionZip'];
  $lostzip = $_POST['lostZip'];
  $adoptiondistance = $_POST['adoptionDistance'];
  $lostdistance = $_POST['lostDistance'];
  
  //check if user is already in table
  //prepare, bind, and execute statement
  $stmt = $mysqli->prepare("SELECT username FROM individual_accounts WHERE username= ?");
  if(!$stmt->bind_param('s', $username)){
    echo "Binding parameters failed: (" . $stmt->errno .") ". $stmt->error;
  }
  if(!$stmt->execute()){
    echo "Execute failed: (" . $stmt->errno .") " . $stmt->error;
  }
  //is user is not already table 
  if(!$stmt->fetch()){
    $stmt->close();
    //add new user to table
    $stmt = $mysqli->prepare("INSERT INTO individual_accounts(firstName, lastName, email, zipcode, username, password, newAdoption, newLost, adoptionZip, adoptionDistance, lostZip, lostDistance) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
    if(!$stmt->bind_param('sssissiiiiii', $firstname, $lastname, $email, $zipcode, $username, $password, $newAdopt, $newLost, $adoptionzip, $adoptiondistance, $lostzip, $lostdistance)){
      echo "Binding parameters failed: (" . $stmt->errno .") ". $stmt->error;
    }
    if(!$stmt->execute()){
      echo "Execute failed: (" . $stmt->errno .") " . $stmt->error;
    }
    //if successful redirect to Login page
    $stmt->close();
    $filePath = explode('/', $_SERVER['PHP_SELF'], -1);
    $filePath = implode('/', $filePath);
    $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
    header("Location: {$redirect}/accountLogin.php", true);
  //if existing user
  }else{
    echo "Existing user name, please try again.";
  }
}

/*register new business account*/
if(isset($_POST['registerBusiness'])){
  //set variables
  $businessName = $_POST['companyName'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $zipcode = $_POST['zipcode'];
  $phoneNumber = $_POST['phoneNumber'];
  $website = $_POST['website'];
  $username = $_POST['username'];
  $password = $_POST['password'];
    
  //check if user is already in database
  //prepare, bind, and execute statement
  $stmt = $mysqli->prepare("SELECT username FROM business_accounts WHERE username= ?");
  if(!$stmt->bind_param('s', $username)){
    echo "Binding parameters failed: (" . $stmt->errno .") ". $stmt->error;
  }
  if(!$stmt->execute()){
    echo "Execute failed: (" . $stmt->errno .") " . $stmt->error;
  }
  //is user is not already in database
  if(!$stmt->fetch()){
    $stmt->close();
    //add new user to database
    $stmt = $mysqli->prepare("INSERT INTO business_accounts(companyName, username, password, email, streetAddress, city, state, zipcode, phoneNumber, contact, website) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
    if(!$stmt->bind_param('sssssssiiss', $businessName, $username, $password, $email, $address, $city, $state, $zipcode, $phoneNumber, $contact, $website)){
      echo "Binding parameters failed: (" . $stmt->errno .") ". $stmt->error;
    }
    if(!$stmt->execute()){
      echo "Execute failed: (" . $stmt->errno .") " . $stmt->error;
    }
    //if successful redirect to Login page
    $stmt->close();
    $filePath = explode('/', $_SERVER['PHP_SELF'], -1);
    $filePath = implode('/', $filePath);
    $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
    header("Location: {$redirect}/accountLogin.php", true);
 //if existing user
 }else{
   echo "Existing username, please try again";
 }
}
$mysqli->close();
?>
