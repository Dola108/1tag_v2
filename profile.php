<?php

	include("connection.php");

	$res = mysqli_query($dbc, "SELECT * FROM registration");

	while ($row = mysqli_fetch_array($res)) {
		echo $row['username']."/".$row['age'];
	}
?>