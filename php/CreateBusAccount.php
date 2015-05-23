<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';

session_start();

/*Checks to see if there is an active session*/
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
     <title>Register Business Account</title>
     <!--jquery-->
<!--     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>-->
     <!--Latest compiled and minified javascript-->
<!--     <script src="https://maxcdn.boostrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>-->
<!--     <script src="accounts.js" type="text/javascript"></script>-->
</head>
<body>
  <header>
    <h1>Create Business Account</h1>
  </header>
  <div>
    <form action="register.php" method="post">
      <fieldset>
        <legend>
          Create a new User Account
        </legend>
        <p>
          <label for="companyName">Business Name</label>
          <input type="text" id ="companyName" name="companyName" required>
        </p>
        <p>
          <label for="contact">Contact Person</label>
          <input type="text" id="contact" name="contact" required>
        </p>
        <p>
          <label for="email">Email</label>
          <input type="email" id ="email" name="email" required>
        </p>
        <p>
          <label for="address">Address</label>
          <input type="text" id="address" name="address" required>
        </p>
        <p>
          <label for="city">City</label>
          <input type="text" id="city" name="city" required>
        </p>
        <p>
          <label for="state">State</label>
          <input type="text" id="state" name="state" required>
        </p>
        <p>
          <label for="zipcode">Zipcode</label>
          <input type="number" id="zipcode" name="zipcode" maxlength=5 required>
        </p>
        <p>
          <label for="phoneNumber">Phone Number</label>
          <input type="number" id="phoneNumber" name="phoneNumber" placeholder="no dashes, ex: 1234567890" required>
        </p>
        <p>
          <label for="website">Website</label>
          <input type="text" id="website" name="website" required>
        </p>
        <p>
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required>
        </p>
        <p>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </p>
        <p>
          <button type="submit" id="registerBusiness" name="registerBusiness">
            Create Account
          </button>
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
