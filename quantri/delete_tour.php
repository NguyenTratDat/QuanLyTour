<?php
if(isset($_GET['id']))
{
	$id=$_GET['id'];

	try{
		include("connection.php");

		$disabled_Tour_script = "
			UPDATE tours SET IS_ACTIVE = 0 WHERE ID='$id'
		";
		
		$connect->exec($disabled_Tour_script);

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
