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

			$flagOK = true; $arrError = array(); $mgs = "";

			$username   = ($_POST["txtusername"]) ?: '';
			$ten        = ($_POST["txttennv"])    ?: '';
			$email      = ($_POST["txtemail"])    ?: '';
			$cmnd       = ($_POST['txtcmndnv'])   ?: '';
			$dchi       = ($_POST['txtdcnv'])     ?: '';
			$sdt        = ($_POST['txtsdtnv'])    ?: '';
			$chucvu     = ($_POST['chucvu'])      ?: 'USER';
			$nvl        = ($_POST['ngayvl'])      ?: '';
			$ns         = ($_POST['ns']) 		  ?: '';

			$pattern_username = "/^[^\s]+$/";
			$pattern_mobile = "/^(?:\+84|0)(?:3[2-9]|5[2-9]|7[0|6-9]|8[1-9]|9[0-9])\d{7}$/";
			$pattern_email  = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
			$pattern_cmnd   = "/^\d{9}$|^\d{12}$/";

			$dob   = new DateTime($ns);     $today = new DateTime();
			$age   = $today->diff($dob)->y;

			if(!isset($username)){
				$flagOK = false;
				$arrError[] = "Tên đăng nhập không được rỗng!";
			}
			else{

				if (!preg_match($pattern_username, $username)) {
					$arrError[] = "Tên đăng nhập không hợp lệ!";
				}
				else{
					$checkUserName = "
						SELECT USERNAME
						FROM login
						WHERE USERNAME = '".$username."'
						LIMIT 1
					";

					$resCheck  = $connect->query($checkUserName); 
					$countData = $resCheck->rowCount();

					if($countData){ // Check trùng
						$arrError[] = "Tên đăng nhập đã tồn tại!";
					}
				}
			}

			if(!is_numeric($cmnd)){
				$arrError[] = "Chứng minh nhân dân phải là chuỗi số!";
			}
			else{
				if (!preg_match($pattern_cmnd, $cmnd)) {
					$arrError[] = "CMND không hợp lệ!";
				}
			}

			if(!is_numeric($sdt)){
				$arrError[] = "Số điện thoại phải là chuỗi số!";
			}
			else{
				if (!preg_match($pattern_mobile, $sdt)) {
					$arrError[] = "Số điện thoại không hợp lệ!";
				}
			}

			if (!preg_match($pattern_email, $email)) {
				$arrError[] = "Email không hợp lệ!";
			}

			if ($age < 18) {

				$arrError[] = "Ngày sinh không hợp lệ (>= 18 tuổi)!";
			}

			if(count($arrError) > 0){

				foreach ($arrError as $key => $value) {
					$mgs .= "• ".$value." \n";
				}

				?>
					<script>alert( ` <?php echo $mgs; ?> ` )</script>
				<?php
			
			}
			else{

				$POSITION = ($chucvu == 'ADMIN') ? "ADMIN" : "USER";

				$sql="
					INSERT INTO `employees`(`NAME`, `IDCARD`, `ADDRESS`, `PHONENUMBER`, `POSITION`, `PART_DAY`, `BIRTHDAY`, `EMAIL`) 
					VALUES ('$ten','$cmnd','$dchi','$sdt','$POSITION','$nvl','$ns','$email')
				";

				$resInsert = $connect->exec($sql);

				if($resInsert){

					$employeeId = $connect->lastInsertId();

					$passDefault = "P@ssw0rd";

					$scriptLogin="
						INSERT INTO `login`(`ID`,`USERNAME`, `PASSWORD`) 
						VALUES ('$employeeId','$username',md5('$passDefault'))
					";

					$resLogin = $connect->exec($scriptLogin);

					?>
						<script> alert("Thêm mới thành công!"); </script>
						<script>window.location = '?quanly=list_employees'</script>
					<?php

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
				<td><input type="text" name="txttennv" required="required" value="<?php echo $_POST['txttennv'] ?>"></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" name="txtemail" required="required" value="<?php echo $_POST['txtemail'] ?>"></td>
			</tr>
			<tr>
				<td>CMND</td>
				<td><input type="text" name="txtcmndnv" required="required" value="<?php echo $_POST['txtcmndnv'] ?>"></td>
			</tr>
			<tr>
				<td>Địa chỉ</td>
				<td><input type="text" name="txtdcnv" required="required" value="<?php echo $_POST['txtdcnv'] ?>"></td>
			</tr>
			<tr>
				<td>Điện thoại</td>
				<td><input type="text" name="txtsdtnv" required="required" value="<?php echo $_POST['txtsdtnv'] ?>" ></td>
			</tr>
			<tr>
				<td>Chức vụ</td>
				<td>
					<label class="lb-custom marr-10 pull-left">
						<input type="radio" name="chucvu" value="ADMIN" >Quản Lý
					</label>

					<label class="lb-custom marr-10 pull-left">
						<input type="radio" name="chucvu" value="USER" checked="checked">Nhân Viên
					</label>
					
				</td>
			</tr>
			<tr>
				<td>Ngày làm việc</td>
				<td><input type="date" name="ngayvl" required="required" value="<?php echo $_POST['ngayvl'] ?>"></td>
			</tr>
			<tr>
				<td>Ngày sinh</td>
				<td><input type="date" name="ns" required="required" value="<?php echo $_POST['ns'] ?>"></td>
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