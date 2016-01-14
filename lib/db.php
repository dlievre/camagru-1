<?php 
$servername = "localhost";
$username = "root";
$password = "mdebelle";

try {
    $conn = new PDO("mysql:host=$servername;", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS kikou";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Database created successfully<br>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;

die();

	// try{
	// 	$db = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'root');
	// 	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	// 	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
 // 	}catch (Exception $e){
 // 		echo "Impossible de se connecter à la base de donnée";
	// 	echo $e->getMessage();
 // 		die();
 // 	}
