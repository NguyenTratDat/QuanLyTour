<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
	<link rel="stylesheet" type="text/css" href="style2.css">
	<link rel="stylesheet" href="2.css"> 	
<body>
	<?php 
		include("connection.php");
	 	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

		if(isset($_POST['btnok'])){

			$flagOK = true;

			if(!isset($_POST['txtusername'])){
				$flagOK = false;
				$arrError[] = "Tên đăng nhập không được rỗng!";
			}

			if(!is_numeric($_POST['txtcmndnv'])){
				$flagOK = false;
				$arrError[] = "Chứng minh nhân dân phải là chuỗi số!";
			}

			if(!is_numeric($_POST['txtsdtnv'])){
				$flagOK = false;
				$arrError[] = "Số điện thoại phải là chuỗi số!";
			}

			if(!$flagOK){
				$mgs = "<ul>";

				foreach ($arrError as $value) {
					$mgs .= "<li>".$value."</li>";
				}

				$msg .= "</ul>";

				?>
					<script> alert("<?php echo $msg; ?>"); </script>

				<?php
			
			}
			else{
				$username   = ($_POST["txtusername"]) ?: '';
				$ten        = ($_POST["txttennv"])    ?: '';
				$cmnd       = ($_POST['txtcmndnv'])   ?: '';
				$dchi       = ($_POST['txtdcnv'])     ?: '';
				$sdt        = ($_POST['txtsdtnv'])    ?: '';
				$chucvu     = ($_POST['chucvu'])      ?: 'Employee';
				$nvl        = ($_POST['ngayvl'])      ?: '';
				$ns         = ($_POST['ns']) 		  ?: '';

				$checkUserName = "
					SELECT USERNAME
					FROM login
					WHERE USERNAME = '".$username."'
					LIMIT 1
				";

				$resCheck  = $connect->query($checkUserName); 
				$countData = $resCheck->rowCount();

				if($countData){ // Check trùng
					?>
						<script> alert("Tên đăng nhập đã tồn tại. Vui lòng thử lại!"); </script>
					<?php
				}
				else{
					$sql="
						INSERT INTO `employees`(`NAME`, `IDCARD`, `ADDRESS`, `PHONENUMBER`, `POSITION`, `PART_DAY`, `BIRTHDAY`) 
						VALUES ('$ten','$cmnd','$dchi','$sdt','$chucvu','$nvl','$ns')
					";

					$resInsert = $connect->exec($sql);

					if($resInsert){

						$employeeId = $connect->lastInsertId();

						$passDefault = "P@ssw0rd"; $POSITION = ($chucvu == 'Manager') ? "ADMIN" : "USER";

						$scriptLogin="
							INSERT INTO `login`(`ID`,`USERNAME`, `PASSWORD`, `POSITION`) 
							VALUES ('$employeeId','$username',md5('$passDefault'),'$POSITION')
						";

						$resLogin = $connect->exec($scriptLogin);

						?>
							<script> alert("Thêm mới thành công!"); </script>
						<?php

					}
				}
			}
		}
	?>

	<div class="titleOfTable">
		<h1 align="center">THÊM NHÂN VIÊN</h1>
	</div>

	<form method="post">

		<table class="list-data" align="center" border="1px black solid" id="abc">
			
			<tr>
				<td>Tên đăng nhập</td>
				<td><input type="text" name="txtusername" required="required" value="<?php echo $_POST['txtusername'] ?>"></td>
			</tr>
			<tr>
				<td>Tên nhân viên</td>
				<td><input type="text" name="txttennv" required="required"></td>
			</tr>
			<tr>
				<td>CMND</td>
				<td><input type="text" name="txtcmndnv" required="required"></td>
			</tr>
			<tr>
				<td>Địa chỉ</td>
				<td><input type="text" name="txtdcnv" required="required"></td>
			</tr>
			<tr>
				<td>Điện thoại</td>
				<td><input type="tel" name="txtsdtnv" required="required" ></td>
			</tr>
			<tr>
				<td>Chức vụ</td>
				<td>
					<label class="lb-custom marr-10 pull-left">
						<input type="radio" name="chucvu" value="Manager" >Quản Lý
					</label>

					<label class="lb-custom marr-10 pull-left">
						<input type="radio" name="chucvu" value="Employee" checked="checked">Nhân Viên
					</label>
					
				</td>
			</tr>
			<tr>
				<td>Ngày làm việc</td>
				<td><input type="date" name="ngayvl" required="required"></td>
			</tr>
			<tr>
				<td>Ngày sinh</td>
				<td><input type="date" name="ns" required="required"></td>
			</tr>
			<tr align="center">

				<td colspan="2">
					<button class="btn btn-info"><a href="admin.php?quanly=list_employees" style="text-decoration:none" >Trở về</a></button>
					<input type="submit" name="btnok" value="Thêm" class="btn btn-info">
					
				</td>
			</tr>

		</table>

	</form>
</body>
</html>