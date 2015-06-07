<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';

session_start();
/*check for active session*/
//if there is an active session redirect to the user preferences page
if(isset($_SESSION['username'])){
  $filePath = explode('/', $_SERVER['PHP_SELF'], -1);
  $filePath = implode('/', $filePath);
  $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
  header("Location: {$redirect}/userPreferences.php", true);
//if there is not an active session, proceed to register page
}else{
?>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Register Individual Account</title>
   <!--jquery-->
   <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>-->
   <!--Latest compiled and minified javascript-->
<!--   <script src="https://maxcdn.boostrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>-->
<!--   <script src="accounts.js" type="text/javascript"></script>-->
</head>
<body>
  <header>
    <h1>Create Individual User Account</h1>
  </header>
    <div>
      <form action="register.php" method="post">
        <fieldset>
          <legend>
            Create a new User Account
          </legend>
          <p>
            <label for="firstName">First Name</label>
            <input type="text" id ="firstName" name="firstName">
          </p>
          <p>
             <label for="lastName">Last Name</label>
             <input type="text" id="lastName" name="lastName">
          </p>
          <p>
            <label for="email">Email</label>
            <input type="email" id ="email" name="email" required>
          </p>
          <p>
            <label for="zipcode">Zipcode</label>
            <input type="number" id="zipcode" name="zipcode" maxlength=5>
          </p>
          <p>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
          </p>
          <p>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
          </p>
          <br>
          <p>
            <input type="radio" id="newAdoption" name="newAdoption" value="NotifyAdopt">
            Notify me when new animals are up for adoption.
          </p>
          <p>
            Select distance to search for adoptions (in miles) from:
            <label for="adoptionZip">zipcode</label>
            <input type="adoptionZip" id="adoptionZip" name="adoptionZip" maxlength=5>
          <br>
            <input type="radio" id="adoptionDistance" name="adoptionDistance" value="25"> 25
            <input type="radio" id="adoptionDistance" name="adoptionDistance" value="50">  50
            <input type="radio" id="adoptionDistance" name="adoptionDistance" value="75"> 75
            <input type="radio" id="adoptionDistance" name="adoptionDistance" value="100"> 100
          </p>
          <br>
          <p>
            <input type="radio" id="newLost" name="newLost" value="NotifyLost">
            Notify me when new lost animals are posted.
          </p>
          <p>
            Select distance to search for lost animals (in miles) from:
            <label for="lostZip">zipcode</label>
            <input type="lostZip" id="lostZip" name="lostZip" maxlength=5>
            <br>
            <input type="radio" id="lostDistance" name="lostDistance" value="25"> 25
            <input type="radio" id="lostDistance" name="lostDistance" value="50"> 50
            <input type="radio" id="lostDistance" name="lostDistance" value="75"> 75							 
            <input type="radio" id="lostDistance" name="lostDistance" value="100"> 100
          </p>
          <p>
            <button type="submit" id="registerIndividual" name="registerIndividual">Create Account</button>
          </p>
        </fieldset>
     </form>
    </div>
</body>
</html>
<?php
  }
$mysqli->close();
?>
