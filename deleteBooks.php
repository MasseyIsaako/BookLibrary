<?php
	require("./templates/databaseConnection.php");
	$id = $_GET['id'];
	var_dump($id);
	$sql = "DELETE FROM `books` WHERE id = $id";
	$result = mysqli_query($dbc, $sql);
	if($result){
		header("Location: index.php");
	} else {
		die("Something went wrong, cannot delete book");
	}