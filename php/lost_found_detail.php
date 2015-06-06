<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  include 'db.php';

  $query = "SELECT title, picture_url, zipcode, tel,
            text_body, email, species, lostfound
            FROM LOST_FOUND
            WHERE id = ?";


  $individ = $mysqli->prepare($query);
  $individ->bind_param('i', $_REQUEST['id']);
  $individ->execute();
  $individ->bind_result(
    $title, $picture_url, $zipcode, $tel,
            $text_body, $email, $species, $lostfound
  );

  $individ->fetch();

  echo
  "<html>
    <head>
      <meta charset='UTF-8'>
      <title>Adoption Detail</title>
    </head>
    <body>
      <h1 id='title'>$title ($lostfound)</h1>
      <img id='picture' src='$picture_url'/>
      <div id='species'>Species: $species</div>
      <div id='description'>Description: $text_body</div>
      <div id='phone_number'>Phone: $tel</div>
      <div id='email'>Email: <a href='mailto:$email'>$email</a></div>
      <div id='addr_zipcode'>Zip Code: $zipcode</div>
    </body>
  </html>";

  $mysqli->close(); //close the db
?>
