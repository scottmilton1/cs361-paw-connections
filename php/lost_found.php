<?php 

	$host = 'localhost';
	$user = 'ericiann_pawcon';
	$pwd = 'pawconnections';
	$db = 'ericiann_pawconnections';
	$table = 'LOST_FOUND';

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
	
	$query = "SELECT id, title, picture_url, species, lostfound FROM $table WHERE $where_clause";
	$filtered = $mysqli->prepare($query);
	$filtered->execute();
	$filtered->bind_result($id, $title, $picture_url, $species, $lostfound);
	while($filtered->fetch()) {
		echo "<div><img src=\"$picture_url\"></div>";
		echo "<div>
				<p><a class='detail_link' id='$id' href='http://pawconnections.net/pawconnections/php/lost_found_detail.php?id=$id'>$title</a>
				$lostfound $species</p>
				</div>";
	}
	//search for dogs
	$filtered->close();
	exit();
/*
	if(isset($_REQUEST['dog_filter']) && !isset($_REQUEST['cat_filter']) && !isset($_REQUEST['bird_filter'])) {
		$filtered = $mysqli->prepare("SELECT title FROM $table WHERE species = 'dog'");
		$filtered->execute();
		$filtered->bind_result($title);
		while($filtered->fetch()) {
			echo "<span>";
			echo $title;
			echo "</span><br/>";
		}	
		//search for dogs
		$filtered->close();
		exit();
	}

	if(!isset($_REQUEST['dog_filter']) && isset($_REQUEST['cat_filter']) && !isset($_REQUEST['bird_filter'])) {
		//search for cats
		$filtered = $mysqli->prepare("SELECT title FROM $table WHERE species = 'cat'");
		$filtered->execute();
		$filtered->bind_result($title);
		while($filtered->fetch()) {
			echo "<span>";
			echo $title;
			echo "</span><br/>";
		}
		$filtered->close();
		exit();
	}


	if(!isset($_REQUEST['dog_filter']) && !isset($_REQUEST['cat_filter']) && isset($_REQUEST['bird_filter'])) {
		//search for birds
		$filtered = $mysqli->prepare("SELECT title FROM $table WHERE species = 'bird'");
		$filtered->execute();
		$filtered->bind_result($title);
		while($filtered->fetch()) {
			echo "<span>";
			echo $title;
			echo "</span><br/>";
		}
		$filtered->close();
		exit();
	}


	if(isset($_REQUEST['dog_filter']) && isset($_REQUEST['cat_filter']) && !isset($_REQUEST['bird_filter'])) {
		//search for dogs and cats
		$filtered = $mysqli->prepare("SELECT title FROM $table WHERE species = 'dog' OR species = 'cat'");
		$filtered->execute();
		$filtered->bind_result($title);
		while($filtered->fetch()) {
			echo "<span>";
			echo $title;
			echo "</span><br/>";
		}
		$filtered->close();
		exit();
	}


	if(isset($_REQUEST['dog_filter']) && !isset($_REQUEST['cat_filter']) && isset($_REQUEST['bird_filter'])) {
		//search for dogs and birds
		$filtered = $mysqli->prepare("SELECT title FROM $table WHERE species = 'dog' OR species = 'bird'");
		$filtered->execute();
		$filtered->bind_result($title);
		while($filtered->fetch()) {
			echo "<span>";
			echo $title;
			echo "</span><br/>";
		}
		exit();
	}


	if(!isset($_REQUEST['dog_filter']) && isset($_REQUEST['cat_filter']) && isset($_REQUEST['bird_filter'])) {
		//search for cats and birds
		$filtered = $mysqli->prepare("SELECT title FROM $table WHERE species = 'cat' OR species = 'bird'");
		$filtered->execute();
		$filtered->bind_result($title);
		while($filtered->fetch()) {
			echo "<span>";
			echo $title;
			echo "</span><br/>";
		}
		$filtered->close();
		exit();
	}
	

	if(isset($_REQUEST['dog_filter']) && isset($_REQUEST['cat_filter']) && isset($_REQUEST['bird_filter'])) {
		//search for all
		$filtered = $mysqli->prepare("SELECT title FROM $table");
		$filtered->execute();
		$filtered->bind_result($title);
		while($filtered->fetch()) {
			echo "<span>";
			echo $title;
			echo "</span><br/>";
		}
		$filtered->close();
		exit();
	}*/
 ?>