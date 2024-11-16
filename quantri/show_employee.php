<!DOCTYPE html>
<html>
<head>
</head>
	<link rel="stylesheet" type="text/css" href="style2.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php session_start(); ?>

	<?php 
		include("connection.php");

		if ( (isset($_SESSION['username']) && $_SESSION['username']) || isset($_SESSION['user_id']) && $_SESSION['user_id'] )
		{
			$username = $_SESSION['username'];
			$user_id  = $_SESSION['user_id'];
		}
		else{
			header("location:quantri/index.php");
    		die();
		}

			$show="
				SELECT employees.*, login.USERNAME
				FROM employees
					LEFT JOIN login ON login.ID = employees.ID
				WHERE employees.ID='$user_id'
			";

			$infoes= $connect->query($show);
	?>
	<?php 
		
			foreach($infoes as $info)
			{
	?>
<body>

	<div class="titleOfTable">
		<h1 align="center">THÔNG TIN NHÂN VIÊN</h1>
	</div>

	<form method="post">

		<table class="list-data" width="1000px" align="center" border="1 solid" cellpadding="5">
			<tr>
				<td>Mã số</td>
				<td><input type="text" disabled="disabled" value="<?php echo $info['ID']?>"></td>
			</tr>
			<tr>
				<td>Họ tên</td>
				<td><input type="text" name="txttennv" value="<?php echo $info['NAME']?>"></td>
			</tr>
			<tr>
				<td>CMND</td>
				<td><input type="text" name="txtcmndnv" value="<?php echo $info['IDCARD']?>"></td>
			</tr>
			<tr>
				<td>Địa chỉ</td>
				<td><input type="text" name="txtdcnv" value="<?php echo $info['ADDRESS']?>"></td>
			</tr>
			<tr>
				<td>Điện thoại</td>
				<td><input type="tel" name="txtsdtnv" value="<?php echo $info['PHONENUMBER']?>"></td>
			</tr>
			<tr>
				<td>Ngày vào làm</td>
				<td><input type="date" name="nvl" value="<?php echo $info['PART_DAY']?>"></td>
			</tr>
			<tr>
				<td>Ngày sinh</td>
				<td><input type="date" name="ns" value="<?php echo $info['BIRTHDAY']?>"></td>
			</tr>
			<?php 
				}
			?>
			<tr align="center">

				<td colspan="2">
					<button class="btn btn-info"><a href="?quanly=change_password">Đổi mật khẩu</a></button>

					<input class="btn btn-info" type="submit" name="chinhsua" value="Chỉnh Sửa">
				</td>
			</tr>
		</table>

		<?php
			if(isset($_POST['chinhsua']))
			{
				if(!is_numeric($_POST['txtcmndnv']))
				{?>
					<script> alert("chứng minh nhân dân phải là chuỗi số !"); </script>
				<?php
				}
				else{
					if(!is_numeric($_POST['txtsdtnv']))
						{?>
							<script> alert("số điện thoại phải là chuỗi số !"); </script>
						<?php
					}
					else{

						$ten    = $_POST['txttennv'];
						$cmnd   = $_POST['txtcmndnv'];
						$dchi   = $_POST['txtdcnv'];
						$sdt    = $_POST['txtsdtnv'];
						$nvl    = $_POST['nvl'];
						$ns     = $_POST['ns'];

						$sql=" 
							UPDATE employees SET 
								NAME='$ten', 	
								IDCARD='$cmnd', 
								ADDRESS='$dchi',
								PHONENUMBER='$sdt', 
								PART_DAY='$nvl', 
								BIRTHDAY='$ns' 
							WHERE ID='$user_id'
						";
						
						$connect->query($sql);

						?>
							<script> alert("Cập nhật thành công!"); </script>
							<script>window.location = '?quanly=show_employee'</script>
						<?php
					}
				}			
			}
		?>
	</form>
</body>
</html>