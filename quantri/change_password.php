<!DOCTYPE html>
<html lang="en"  >
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 	
	<link rel="stylesheet" type="text/css" href="2.css">
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<?php 
		session_start();

		if ( (isset($_SESSION['username']) && $_SESSION['username']) || isset($_SESSION['user_id']) && $_SESSION['user_id'] )
		{
			$username = $_SESSION['username'];
			$user_id  = $_SESSION['user_id'];
		}
		else{
			header("location:quantri/index.php");
    		die();
		}

		include("connection.php");

	 	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
		if(isset($_POST['hoantat']))
		{
			$info    = '';
			$flag    = 1;

			if(isset($_POST["txtoldpass"]))
			{
				$old_pass=$_POST["txtoldpass"];
			}

			if(isset($_POST['txtnewpass']))
			{
				$new_pass=$_POST['txtnewpass'];
			}

			if(isset($_POST['txtconfirmpass']))
			{
				$confirm_pass=$_POST['txtconfirmpass'];
			}

			if($new_pass != $confirm_pass){
				$info = "Xác nhận mật khẩu không đúng!";
				$flag = 0;

				?>
					<script> alert("<?php echo $info; ?>"); </script>
					<script>window.location = '?quanly=change_password'</script>
				<?php
			}

			$pattern_pwd = "/^(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*\d).+$/";

			if (!preg_match($pattern_pwd, $new_pass)) {
				$info = "Mật khẩu phải bao gồm kí tự in hoa, có cả số và chữ!";
				$flag = 0;

				?>
					<script> alert("<?php echo $info; ?>"); </script>
					<script>window.location = '?quanly=change_password'</script>
				<?php
			}

			$sql   = " SELECT * FROM `login` where ID = '$user_id' ";
			$vara  = $connect->query($sql);

			foreach($vara as $a){
				$pass_csdl = $a['PASSWORD'];
			}
			

			if(md5($old_pass) != $pass_csdl){
				$info = "Mật khẩu hiện tại không đúng!";
				$flag = 0;
			}

			if($flag == 1){
				$sql1   = "UPDATE `login` SET `PASSWORD`=md5('$new_pass') WHERE ID='$user_id'";
				$connect->query($sql1);

				$info   = 'Cập nhật thành công!';

				?>
					<script> alert("<?php echo $info; ?>"); </script>
					<script>window.location = '?quanly=show_employee'</script>
				<?php
			}
			else{

				?>
					<script> alert("<?php echo $info; ?>"); </script>
					<script>window.location = '?quanly=change_password'</script>
				<?php
			}		
		}

	?>
	
<body>

	<div class="titleOfTable">
		<h1 align="center">ĐỔI MẬT KHẨU</h1>
	</div>

	<div class="login-content-changepw">
		<form method="post" action="change_password.php" >

			<label for="username">
				Mật khẩu cũ <span style="color:red">*</span>
				<input type="password" name="txtoldpass" id="password"  required="required" />
			</label>

			<label for="password">
				Mật khẩu mới <span style="color:red">*</span>
				<input type="password" name="txtnewpass" id="password" placeholder="Mật khẩu phải bao gồm kí tự in hoa, có cả số và chữ"  required="required" />
			</label>

			<label for="password">
				Xác nhận Mật khẩu <span style="color:red">*</span>
				<input type="password" name="txtconfirmpass" id="password" placeholder="Mật khẩu phải bao gồm kí tự in hoa, có cả số và chữ"  required="required" />
			</label>
		
			<div class="center">
				<input type="submit" class="btn btn-info" name="hoantat" value="Hoàn tất"></input>	
			</div>

		</form>

	</div>
	<script type="text/javascript" src="vendor/bootstrap.js"></script>  
	<script type="text/javascript" src="vendor/angular-1.5.min.js"></script>  
	<script type="text/javascript" src="vendor/angular-animate.min.js"></script>
	<script type="text/javascript" src="vendor/angular-aria.min.js"></script>
	<script type="text/javascript" src="vendor/angular-messages.min.js"></script>
	<script type="text/javascript" src="vendor/angular-material.min.js"></script>  
	<script type="text/javascript" src="2.js"></script>
</body>
</html>