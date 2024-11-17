<?php
if(isset($_GET['id']))
{
	$id=$_GET['id'];
	try{
		include("connection.php");

		$update_script="UPDATE employees SET IS_ACTIVE = NOT IS_ACTIVE WHERE ID='$id'"; 
		$connect->exec($update_script);

		header("location:admin.php?quanly=list_employees");
	}
	catch(PDOException $e)
	{
		echo $sql."<br>".$e->getMessage();
		header("location:admin.php?quanly=list_employees");
	}
}
$connect=null;
?>