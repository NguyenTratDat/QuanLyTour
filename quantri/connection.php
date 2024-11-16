
	<?php
	$hostName = 'localhost';
	// khai báo biến username
	$userName = 'root';
	//khai báo biến password
	$passWord = '';
	// khai báo biến databaseName
	$databaseName = 'ql_tourdulich';
	// khởi tạo kết nối
	try {
	    $connect = new PDO('mysql:host=' . $hostName . ';dbname=' . $databaseName, $userName, $passWord);
	    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $connect->query("set names utf8");

	    
	}

		catch (PDOException $e)
		{
		    //thất bại
		    die($e->getMessage());
		}


	?>
