<!DOCTYPE html>
<html>
<head>
	<!-- <link rel="stylesheet" href="vendor/bootstrap.css">
	<link rel="stylesheet" href="vendor/angular-material.min.css">
	<link rel="stylesheet" href="vendor/font-awesome.css"> -->
	<link rel="stylesheet" type="text/css" href="email.css">
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<?php 

	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

	$email   = $_POST['txtmail'];
	$chude   = $_POST['txtchude'];
	$noidung = $_POST['txtnoidung'];

	if(isset($_POST['btnok']))
	{

		?>
			<script> alert("Đang phát triển tính năng!"); </script>
		<?php
	}
?>  
<body style="margin: 0 auto;">
	
	<div class="titleOfTable">
		<h1 align="center">Thông tin gửi mail</h1>
	</div>

	<div class="container marb-10" align="center">
		<form method="post" action='email.php' >
			<table width="700px">

				<tr>
					<td height="50px" width="150px">Email khách</td>
					<td height="50px" ><input size="50px" type="mail" name="txtmail" required="required"></td>
				</tr>
				<tr>
					<td height="60px" width="150px">Tên chủ đề</td>
					<td><input size="50px" type="text" name="txtchude" required="required"></td>
				</tr>
				<tr>
					<td height="150px" width="150px">Nội dung</td>
					<td><textarea rows="4" cols="52px" size="50px" type="text" name="txtnoidung" required="required" height="50px"></textarea></td>
				</tr>
			</table>

			<br>

			<div class="container">
				<input type="submit" class="btn btn-info" name="btnok" value="Hoàn tất">
			</div>
		</form>
	</div>

</body>
</html>