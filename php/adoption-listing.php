<?php

	$host = 'localhost';
	$user = 'ericiann_pawcon';
	$pwd = 'pawconnections';
	$db = 'ericiann_pawconnections';
	$table = 'ADOPTION';

	$mysqli = new mysqli($host, $user, $pwd, $db);
	if($mysqli->connect_error) {
	  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
	}


	if(!isset($_REQUEST['filter'])) {
		echo "There was an error applying your filter";
		exit();
	}

	$where_clause = '';
	$count = 0;
	if(isset($_REQUEST['dog_filter'])) {
		$where_clause = $where_clause." species = 'dog'";
		$count += 1;
	}

	if(isset($_REQUEST['cat_filter'])) {
		if($count > 0) {
			$where_clause = $where_clause." OR species = 'cat'";
		} else {
			$where_clause = $where_clause." species = 'cat'";
			$count += 1;
		}
	}

	if(isset($_REQUEST['bird_filter'])) {
		if($count > 0) {
			$where_clause = $where_clause." OR species = 'bird'";
		} else {
			$where_clause = $where_clause." species = 'bird'";
			$count += 1;
		}
	}

	if(isset($_REQUEST['zip_filter'])) {
		if($count > 0) {
			$zip_where = $_REQUEST['zip_filter'];
			$where_clause = "(".$where_clause.") AND (".$zip_where.")";
		} else {
			$zip_where = $_REQUEST['zip_filter'];
			$where_clause = "(".$where_clause.") (".$zip_where.")";
			$count += 1;
		}
	}

	$query = "SELECT id, title, picture_url, gender, size,
						facility_name, city, zip_code FROM $table WHERE $where_clause";
	$filtered = $mysqli->prepare($query);
	$filtered->execute();
	$filtered->bind_result(
		$id, $title, $picture_url, $gender, $size,
		$facility_name, $city, $zip_code
	);

	while($filtered->fetch()) {
		echo "
			<div><img src='$picture_url'></div>
			<div>
				<p><a class='detail_link' id='$id' href='http://pawconnections.net/pawconnections/php/adoption-detail.php?id=$id'>$title</a>
				<p>$facility_name : <span class='zip_code'>$zip_code</span>
				<p>$size | $gender
			</div>
		";
	}
	//search for dogs
	$filtered->close();
	exit();

 ?>
