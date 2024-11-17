<!DOCTYPE html>
<html>
<head>
</head>
	<link rel="stylesheet" type="text/css" href="style2.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php session_start(); ?>

	<?php 
		include("connection.php");

		$flagEdit_User = true;

		if ( (isset($_SESSION['username']) && $_SESSION['username']) || isset($_SESSION['user_id']) && $_SESSION['user_id'] )
		{
			$username = $_SESSION['username'];
			$user_id  = $_SESSION['user_id'];

			if(in_array($_SESSION['position'], ['ADMIN','SUPERADMIN'])){

				if(isset($_GET['user_id'])&&($_GET['user_id'])!=''){
					$user_id = $_GET['user_id'];

					$flagEdit_User = false;
				}

			}

		}
		else{
			header("Location: index.php");
    		die();
		}

		$sqlInfo = "
			SELECT employees.*, login.USERNAME
			FROM employees
				LEFT JOIN login ON login.ID = employees.ID
			WHERE employees.ID='$user_id'
			LIMIT 1
		";

		if($_SESSION['position'] == 'CUSTOMER'){
			$sqlInfo = "
				SELECT customers.*, login.USERNAME
				FROM customers
					LEFT JOIN login ON login.ID = customers.ID
				WHERE customers.ID='$user_id'
				LIMIT 1
			";
		}

		$infoes = $connect->query($sqlInfo);
	?>
	<?php 
		
			foreach($infoes as $info)
			{
	?>
<body>

	<div class="titleOfTable">
		<h1 align="center">THÔNG TIN TÀI KHOẢN</h1>
	</div>

	<form method="post">

		<table class="list-data" width="1000px" align="center" border="1 solid" cellpadding="5">
			<tr>
				<td>Mã số</td>
				<td><input type="text" disabled="disabled" value="<?php echo $info['ID']?>"></td>
			</tr>

			<?php if(!$flagEdit_User){ ?>
				<tr>
					<td>Chức vụ</td>
					<td>
						<label class="lb-custom marr-10 pull-left">
							<input type="radio" name="chucvu" value="ADMIN" <?php echo ($info['POSITION'] == 'ADMIN' ) ? 'checked="checked"' : '' ?> >Quản Lý
						</label>

						<label class="lb-custom marr-10 pull-left">
							<input type="radio" name="chucvu" value="USER" <?php echo ($info['POSITION'] == 'USER' ) ? 'checked="checked"' : '' ?> >Nhân Viên
						</label>
					</td>
				</tr>
			<?php } ?>

			<tr>
				<td>Họ tên</td>
				<td><input type="text" required="required" name="txttennv" value="<?php echo $info['NAME']?>"></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" required="required" name="txtemail" value="<?php echo $info['EMAIL']?>"></td>
			</tr>
			<tr>
				<td>CMND</td>
				<td><input type="text" required="required" name="txtcmndnv" value="<?php echo $info['IDCARD']?>"></td>
			</tr>
			<tr>
				<td>Địa chỉ</td>
				<td>
					<textarea style="width:50%;" name="txtdcnv" ><?php echo $info['ADDRESS']?></textarea>
				</td>
			</tr>
			<tr>
				<td>Điện thoại</td>
				<td><input type="text" required="required" name="txtsdtnv" value="<?php echo $info['PHONENUMBER']?>"></td>
			</tr>

			<?php if(!$flagEdit_User){ ?>

				<tr>
					<td>Ngày vào làm</td>
					<td><input type="date" required="required" name="nvl" value="<?php echo $info['PART_DAY']?>"></td>
				</tr>
			
			<?php } ?>

			<tr>
				<td>Ngày sinh</td>
				<td><input type="date" required="required" name="ns" value="<?php echo $info['BIRTHDAY']?>"></td>
			</tr>
			<?php 
				}
			?>
			<tr align="center">

				<td colspan="2">

					<?php if($flagEdit_User){ ?>
						<button class="btn btn-info"><a href="?quanly=change_password">Đổi mật khẩu</a></button>
					<?php } ?>

					<input class="btn btn-info" type="submit" name="chinhsua" value="Chỉnh Sửa">
				</td>
			</tr>
		</table>

		<?php
			if(isset($_POST['chinhsua']))
			{

				$arrError = array(); $mgs = "";

				$ten        = ($_POST["txttennv"])    ?: '';
				$email      = ($_POST["txtemail"])    ?: '';
				$cmnd       = ($_POST['txtcmndnv'])   ?: '';
				$dchi       = ($_POST['txtdcnv'])     ?: '';
				$sdt        = ($_POST['txtsdtnv'])    ?: '';
				$nvl        = ($_POST['nvl'])         ?: '';
				$ns         = ($_POST['ns']) 		  ?: '';

				$pattern_mobile = "/^(?:\+84|0)(?:3[2-9]|5[2-9]|7[0|6-9]|8[1-9]|9[0-9])\d{7}$/";
				$pattern_email  = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
				$pattern_cmnd   = "/^\d{9}$|^\d{12}$/";

				$dob   = new DateTime($ns);     $today = new DateTime();
				$age   = $today->diff($dob)->y;

				if(!isset($username)){
					$flagOK = false;
					$arrError[] = "Tên đăng nhập không được rỗng!";
				}

				if (!preg_match($pattern_mobile, $sdt)) {
					$arrError[] = "Số điện thoại không hợp lệ!";
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

					$table = ($_SESSION['position'] == 'CUSTOMER') ? 'customers' : 'employees';

					$sql = " 
						UPDATE $table SET 
							NAME       = '$ten',  IDCARD      = '$cmnd',
							ADDRESS    = '$dchi', PHONENUMBER = '$sdt',
							BIRTHDAY   = '$ns',   EMAIL       = '$email'
					";

					if(!$flagEdit_User){

						$POSITION = ($_POST['chucvu'] == "ADMIN") ? "ADMIN" : "USER";

						$sql .= ", POSITION = '$POSITION', PART_DAY = '$nvl'";

					}

					$sql .= " WHERE ID='$user_id' "; 	
					
					$connect->query($sql);

					?>
						<script> alert("Cập nhật thành công!"); </script>

						<?php if(!$flagEdit_User){ ?>
							<script>window.location = '?quanly=list_employees'</script>
						<?php } else { ?>
							<script>window.location = '?quanly=show_employee'</script>
						<?php } ?>

						
					<?php

				}		
			}
		?>
	</form>
</body>
</html>