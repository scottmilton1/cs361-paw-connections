<?php

//post_adoption_backend.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
?>

<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <title>Animal Adoption</title>
</head>
<body>
  <header>
    <h1>Post an animal for adoption</h1>
  </header>
  <div>
   <form id="form1" action="javascript:void(0);" method="post">
      <fieldset>
        <legend>
          Create a new listing
        </legend>
        <p>
          <label for="title">Title</label>
          <input type="text" id="title" name="title">
        </p>
        <p>
          <label for="species">Species</label>
          <input type="text" id="species" name="species">
        </p>
         <p>
          <label for="gender">Gender</label>
          <input type="text" id="gender" name="gender">
        </p>      
         <p>
          <label for="size">Size</label>
          <input type="text" id="size" name="size">
        </p>  
        <p>
          <label for="name">Name</label>
          <input type="text" id="name" name="name">
        </p>    
          <p>
          <label for="breed">Breed</label>
          <input type="text" id="breed" name="breed">
        </p>
         <p>
          <label for="age">Age</label>
          <input type="text" id="age" name="age">
        </p>  
        <p>
          <label for="description">Description</label>
          <input type="text" id="description" name="description">
        </p> 
         <p>
          <label for="adoption_fee">Adoption Fee</label>
          <input type="text" id="adoption_fee" name="adoption_fee">
        </p>  
        <p>
           <label for="pictureurl">Photo URL</label>
          <input type="text" id="pictureurl" name="pictureurl">
        </p>
        <p>
          <label for="facility_name">Facility Name</label>
          <input type="text" id="facility_name" name="facility_name">
        </p>    
        <p>
          <label for="address">Address</label>
          <input type="text" id="address" name="address">
        </p>   
         <p>
          <label for="city">City</label>
          <input type="text" id="city" name="city">
        </p>   
        <p>
          <label for="zipcode">Zip Code</label>
          <input type="text" id="zipcode" name="zipcode">
        </p>
         <p>
          <label for="state">State</label>
          <input type="text" id="state" name="state">
        </p>   
         <p>
          <label for="facility_url">Facility Url</label>
          <input type="text" id="facility_url" name="facility_url">
        </p>

        
        <p>
           <label for="email">E-mail address</label>
          <input type="email" id="email" name="email">
        </p>
        <p>
           <label for="tel">Telephone number</label>
          <input type="tel" id="tel" name="tel">
        </p>
                          
        <p>
          <button type="submit" id="submit" name="submit">Submit</button>
        </p>
      </fieldset>
    </form>
  </div>
  <script src="../js/post_adoption.js"></script>
</body>
</html>
