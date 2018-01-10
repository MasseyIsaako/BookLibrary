<?php
	$dbc = mysqli_connect('localhost', 'root', 'root', 'bookLibrary');
	if(!$dbc){
		die("Server error, database not responding");
	}