<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

session_start();
?>

<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <title>Lost / Found Animal</title>
</head>
<body>
  <header>
    <h1>Post a Lost / Found Animal</h1>
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
          Type of listing:
          <br>
          <input type="radio" id="lost" name="lostfound" value="lost" selected="true" checked> Lost
          <input type="radio" id="found" name="lostfound" value="found"> Found
        </p>
        <p>
          <label for="zipcode">Zip Code</label>
          <input type="text" id="zipcode" name="zipcode">
        </p>
        <p>
          <label for="species">Species</label>
          <input type="text" id="species" name="species">
        </p>
        <p>
           <label for="pictureurl">Photo URL</label>
          <input type="text" id="picture_url" name="picture_url">
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
          <label for="description">Description</label>
          <input type="text" id="description" name="description">
        </p>                   
        <p>
          <button type="submit" id="submit" name="submit">Submit</button>
        </p>
      </fieldset>
    </form>
  </div>
  <script src="post-lost-found.js"></script>
</body>
</html>