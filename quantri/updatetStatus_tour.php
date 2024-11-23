<?php
if(isset($_GET['id']))
{
	$id     = $_GET['id'];
	$status = ($_GET['status'] == 2) ? '2' : '1';

	try{
		include("connection.php");

		$detail_script = " SELECT * FROM tour_details WHERE ID='$id' ";

		$result     = $connect->query($detail_script);

		foreach($result as $info){
			
			$START   = $info['START'];
			$END     = $info['END'];
			$EXPIRED = $info['EXPIRED'];

			$date_NULL = '0000-00-00';

			if($START == $date_NULL || $END == $date_NULL || $EXPIRED == $date_NULL ){
				echo '202';
			}
			else{
				$disabled_Tour_script = "
					UPDATE tours SET IS_ACTIVE = '$status' WHERE ID='$id'
				";
				
				$connect->exec($disabled_Tour_script);

				header("location:list_qltourdl.php");
			}

		}
	}
	catch(PDOException $e)
	{
		echo $sql."<br>".$e->getMessage();
		header("location:list_qltourdl.php");
	}
}
$connect=null;
?>
