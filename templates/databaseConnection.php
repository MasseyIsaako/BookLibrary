<?php
	$dbc = mysqli_connect('localhost', 'root', '', 'bookLibrary');
	if(!$dbc){
		die("Server error, database not responding");
	}