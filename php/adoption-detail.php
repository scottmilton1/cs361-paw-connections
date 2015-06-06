<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  include 'db.php';

  $query = "SELECT title, picture_url, pet_name, zip_code, phone,
            facility_name, facility_url, email, street_add, city, state, adoption_fee,
            description, species, breed, age, size, gender
            FROM ADOPTION
            WHERE id = ?";


  $individ = $mysqli->prepare($query);
  $individ->bind_param('i', $_REQUEST['id']);
  $individ->execute();
  $individ->bind_result(
    $title, $picture_url, $pet_name, $zip_code, $phone,
    $facility_name, $facility_url, $email, $street_add, $city, $state, $adoption_fee,
    $description, $species, $breed, $age, $size, $gender
  );

  $individ->fetch();
  $distance = round($_REQUEST['distance']);

  echo
  "<html>
    <head>
      <meta charset='UTF-8'>
      <title>Adoption Detail</title>
    </head>
    <body>
      <h1 id='title'>$title</h1>
      <img id='picture' src='$picture_url'/>
      <div id='name'>Pet Name: $pet_name</div>
      <div id='species'>Species: $species</div>
      <div id='breed'>Breed: $breed</div>
      <div id='age'>Age: $age</div>
      <div id='gender'>Gender: $gender</div>
      <div id='size'>Size: $size</div>
      <div id='description'>Description: $description</div>
      <div id='shelter_name'>Shelter: <a href='$facility_url'>$facility_name</a></div>
      <div id='phone_number'>Phone: $phone</div>
      <div id='email'>Email: <a href='mailto:$email'>$email</a></div>
      <div id='addr_streetname'>Address: $street_add</div>
      <div id='addr_city'>$city</div>
      <div id='addr_st'>$state</div>
      <div id='addr_zipcode'>$zip_code</div>
      <div id='distance'>$distance miles</div>
      <div id='adoption_fee'>Adoption Fee: $$adoption_fee</div>
    </body>
  </html>";

  $mysqli->close(); //close the db
?>
