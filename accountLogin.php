<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';

session_start();

//if there is an active session go to the user preferences page
if(isset($_SESSION['username'])){
  $filePath = explode('/', $_SERVER['PHP_SELF'], -1);
  $filePath = implode('/', $filePath);
  $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
  header("Location: {$redirect}/userPreferences.php", true);
//if there is not an active session, proceed to login page
}else{
?>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Account Login</title>
   <!--jquery-->
   <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>-->
   <!--Latest compiled and minified javascript-->
   <!--<script src="https://maxcdn.boostrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>-->
<!--     <script src="accounts.js" type="text/javascript"></script>-->
</head>
<body>
  <header>
    <h1>Login to existing account</h1>
  </header>
  <div>
    <form action="loginVerify.php" method="post">
      <fieldset>
        <legend>Business Account</legend>
        <p>
          <label for="username">Username</label>
          <input type="text" id ="username" name="username" required>
        </p>
        <p>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </p>
        <p>
          <button type="submit" id="loginBusiness" name="loginBusiness">Login</button>
        </p>
      </fieldset>
    </form>
  </div>
  <div>
    <form action="loginVerify.php" method="post">
      <fieldset>
        <legend>Individual Account</legend>
        <p>
          <label for="username">Username</label>
          <input type="text" id ="username" name="username" required>
        </p>
        <p>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </p>
        <p>
          <button type="submit" id="loginIndividual" name="loginIndividual">Login</button>
        </p>
      </fieldset>
    </form>
  </div>
  <div>
    <header>
    <h1>Create New Account</h1>
    </header>
    <form action="loginVerify.php" method="post">
      <fieldset>
        <legend>Create New Account</legend>
        <p>
          <input type="radio" id="business" name="accountType" value="business">
          I am a shelter/rescue business.
          <br>
          <input type="radio" id="individual" name="accountType" value="individual">
          I am an individual looking to adopt.
        </p>
        <p>
          <button type="submit" id="createAccount" name="createAccount">Create Account</button>
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
