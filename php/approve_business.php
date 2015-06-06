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

echo "<html>
    		<head>
      		<meta charset='UTF-8'>
      		<title>Approve Businesses</title>
    		</head>
    	<body>";

	if(isset($_REQUEST['approved'])) {
		$id = $_REQUEST['approved'];
		$query = "UPDATE business_accounts SET approved = 1 WHERE id = $id";
		$update_business = $mysqli->prepare($query);
		if($update_business->execute()){
			echo "<h3>Business Approved</h3>";
		} else {
			echo "Something when terribly wrong";
		}
	}

	$query = "SELECT id, companyName, email, phoneNumber, website, contact FROM business_accounts WHERE approved = 0";
	$need_approval = $mysqli->prepare($query);
	if($need_approval->execute()) {
		$need_approval->bind_result($id, $companyName, $email, $phoneNumber, $website, $contact);	
		
    	echo "<table id=\"business_table\">";
    	echo "<tr id=\"header_row\">
    			<td>Company Name</td>
    			<td>Website</td>
    			<td>Point of Contact</td>
    			<td>Email</td>
    			<td>Phone Number</td></tr>";
    	while($need_approval->fetch()) {
    		echo "<tr id=\"$id\">";
    		echo "<td>$companyName</td>";
    		echo "<td><a href=\"http://$website\">Link</a></td>";
    		echo "<td>$contact</td>";
    		echo "<td><a href=\"mailto:$email\">$email</a></td>";
    		echo "<td>$phoneNumber</td>";
    		echo "<td><a href=\"approve_business.php?approved=$id\">Approve</a></td>";
    		echo "</tr>";
    	}
    	echo "</table>";
    } else {
    	echo "Something terrible happend";
    }
    echo "</body></html>";
	$need_approval->close();
?>