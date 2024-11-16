<?php
if(isset($_GET['id']))
{
	$id=$_GET['id'];
	try{
		include("connection.php");
		$sql="DELETE FROM `tour_details` WHERE ID='$id'";
		$sql1="DELETE FROM `tourS` WHERE ID='$id'";
		$connect->exec($sql);
		$connect->exec($sql1);
		header("location:list_qltourdl.php");
	}
	catch(PDOException $e)
	{
		echo $sql."<br>".$e->getMessage();
		header("location:list_qltourdl.php");
	}
}
$connect=null;
?>
