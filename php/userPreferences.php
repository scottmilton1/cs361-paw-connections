<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php'; //includes connection information to the database

session_start();

/*Checks to see if there is an active session*/
//If not, redirect to account login page
if(!isset($_SESSION['username'])){
  $filePath = explode('/', $_SERVER['PHP_SELF'], -1);
  $filePath = implode('/', $filePath);
  $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
  header("Location: {$redirect}/accountLogin.php", true);
//If there is an active session, query database for account information and display on page
}else{
  /*Checks whether account is an individual or business*/
  //if individual account
  if($_SESSION['account_type'] === 0){
      $stmt = $mysqli->prepare("SELECT firstName, lastName, username, email, zipcode, adoptionZip, lostZip, newAdoption, adoptionDistance, adoptionZip, newLost, lostDistance, lostZip FROM individual_accounts WHERE username = '".$_SESSION['username']."'");
      if(!$stmt->execute()){
        echo "Execute failed: (" . $stmt->errno .") " . $stmt->error;
      }
    	$stmt->store_result();
      if(!$stmt->bind_result($firstname, $lastname, $username, $email, $zipcode, $adoptionzip, $lostzip, $newadoption, $adoptiondistance, $adoptionzip, $newlost, $lostdistance, $lostzip)){
    	echo "Binding output parameters failed: (" . $stmt->errno .") " . $stmt->error;
      }
      //loop through results and print account details to screen
      /****************************************************************
       * FIX: newlines are not displaying between each echo statement *
       * ***************************************************************/
      while($stmt->fetch()){
        echo "First Name: $firstname\n";
        echo "Last Name: $lastname\n";
        echo "Username: $username\n";
        echo "Email $email\n";
        echo "Zipcode: $zipcode\n";
        echo "Adoption Zip search area: $adoptionzip\n";
        echo "Lost Pets Zip search area: $lostzip\n";
        if($newadoption){
            echo "You would like to be notified of new adoptions in your area\n";
            echo "Search within $adoptiondistance miles of $adoptionzip\n";
        }else{
            echo "You do not wish to be notified of new adoption in your area\n";
        }
        if($newlost){
            echo "You would like to be notified of lost pets in your area\n";
              echo "Search within $lostdistance miles of $lostzip\n";
        }else{
            echo "You do not wish to be notified of lost pets in your area\n";
        }
      }
      $stmt->close();
  //if business account
  /****************************************************************
   * FIX: business account information is not displaying on page *
   ****************************************************************/
  }else if($_SESSION['account_type'] ===1){
      $stmt = $mysqli->prepare("SELECT companyName, username, email, streetAddress, city, state, zipcode, phoneNumber, contact, website FROM business_accounts WHERE username = '".$_SESSION['username']."'");
      if(!$stmt->execute()){
        echo "Execute failed: (" . $stmt->errno .") " . $stmt->error;
      }
    	$stmt->store_result();
      if(!$stmt->bind_result($companyname, $username, $email, $address, $city, $state, $zipcode, $phoneNumber, $contact, $website)){
    	echo "Binding output parameters failed: (" . $stmt->errno .") " . $stmt->error;
  	  }
      while($stmt->fetch()){
        echo "Company Name: $companyname\n";
        echo "Username: $username\n";
        echo "Email $email\n";
        echo "Address $address\n";
        echo "City $city\n";
        echo "State $state\n";
        echo "Zipcode $zipcode\n";
        echo "Phone Number $phoneNumber\n";
        echo "Contact $contact\n";
        echo "Website $website\n";
      }
      $stmt->close();
  }
}
?>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <title>User Preferences</title>

     <!--jquery-->
<!--     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>-->
     <!--Latest compiled and minified javascript-->
<!--     <script src="https://maxcdn.boostrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>-->
<!--     <script src="accounts.js" type="text/javascript"></script>-->
</head>
<body>
     <header>
          <h1>User Profile</h1>
     </header>
          <div>
              
          </div>
</body>
</html>
<?php
$mysqli->close();
?>
