<?php
if(isset($_GET['id']))
{
	$id  = $_GET['id'];

	try{
		include("connection.php");

		$updatePass = "
			UPDATE login
			SET PASSWORD=md5('P@ssw0rd')
			WHERE ID='$id';
		";

		$res = $connect->exec($updatePass);

		?>
			<script> alert("Cập nhật thành công!"); </script>

			<script>window.location = 'admin.php?quanly=list_employees'</script>

		<?php
		
	}
	catch(PDOException $e)
	{
		echo $sql."<br>".$e->getMessage();
		header("location:admin.php?quanly=list_employees");
	}
}
$connect=null;
?>
