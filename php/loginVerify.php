<?php
include 'db.php';
session_start();

/*for Individual login*/
if(isset($_POST['loginIndividual'])){
  //set variables
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  //check if username and password are in table
  //prepare, bind, and execute statement
  $stmt = $mysqli->prepare("SELECT username, password FROM individual_accounts WHERE username = ? AND password = ?");
  if(!$stmt->bind_param('ss', $username, $password)){
    echo "Binding parameters failed: (" . $stmt->errno .") ". $stmt->error;
  }
  if(!$stmt->execute()){
    echo "Execute failed: (" . $stmt->errno .") " . $stmt->error;
  }
  //if successful, SESSION vars for username and account type
  //then redirect to user account page
  if($stmt->fetch()){
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['account_type'] = 0;
    $stmt->close();
    $filePath = explode('/', $_SERVER['PHP_SELF'], -1);
    $filePath = implode('/', $filePath);
    $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
    header("Location: {$redirect}/userPreferences.php", true);
  //if no existing user/password combo
  }else{
    echo "Invalid username or password.  Please try again or register as a new user.";
  }
}

/*for Business login*/
if(isset($_POST['loginBusiness'])){
  //set variables
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  //check if user is already in database
  //prepare, bind, and execute statement
  $stmt = $mysqli->prepare("SELECT username, password FROM business_accounts WHERE username = ? AND password = ?");
  if(!$stmt->bind_param('ss', $username, $password)){
    echo "Binding parameters failed: (" . $stmt->errno .") ". $stmt->error;
  }
  if(!$stmt->execute()){
    echo "Execute failed: (" . $stmt->errno .") " . $stmt->error;
  }
  //if successful, SESSION vars for username and account type
  //then redirect to user account page
  if($stmt->fetch()){
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['account_type'] = 0;
    $stmt->close();
    $filePath = explode('/', $_SERVER['PHP_SELF'], -1);
    $filePath = implode('/', $filePath);
    $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
    header("Location: {$redirect}/userPreferences.php", true);
  //if no existing user/password combo
  }else{
    echo "Invalid username or password.  Please try again or register as a new user.";
  }
}

/*create New account*/
if(isset($_POST['createAccount'])){  
  if(isset($_POST['business'])){
    $filePath = explode('/', $_SERVER['PHP_SELF'], -1);
    $filePath = implode('/', $filePath);
    $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
    header("Location: {$redirect}/CreateBusAccount.php", true);
  }else if(isset($_POST['individual'])){
    $filePath = explode('/', $_SERVER['PHP_SELF'], -1);
    $filePath = implode('/', $filePath);
    $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
    header("Location: {$redirect}/createIndAccount.php", true);
  }else{
    echo "Create New Account: Please select whether you are a business or an individual.";
  }
}
$mysqli->close();
?>
