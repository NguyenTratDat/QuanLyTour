<?php
if(isset($_GET['id']))
{
	$id=$_GET['id'];
	try{
		include("connection.php");
		$sql="DELETE FROM `customers` WHERE ID='$id'";
		$connect->exec($sql);
		header("location:dskhachdk.php");
	}
	catch(PDOException $e)
	{
		echo $sql."<br>".$e->getMessage();
		header("location:dskhachdk.php");
	}
}
$connect=null;
?>
