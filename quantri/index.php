<!DOCTYPE html>
<html lang="en"  >
<head>
	<title> Quản lý Tour Du Lịch - Nhóm 3 </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 	
	<link rel="stylesheet" href="vendor/bootstrap.css">
	<link rel="stylesheet" href="vendor/angular-material.min.css">
	<link rel="stylesheet" href="vendor/font-awesome.css">
	<link rel="stylesheet" href="2.css">
	
</head>
<body ng-app="myApp" ng-controller="MyController" >
<?php
//Khai báo sử dụng session
session_start();
 
//Khai báo utf-8 để hiển thị được tiếng việt
header('Content-Type: text/html; charset=UTF-8');
 
//Xử lý đăng nhập

$connect = mysqli_connect("localhost", "root", "", "ql_tourdulich");

if (!$connect) {
	die("Connection failed: " . mysqli_connect_error());
}
 

$is_active = 0;  $user_id      = "";
$error_mgs = ""; $error_forgot = ""; $error_create = ""; $error_change_pwd = "";

unset($_SESSION['create']); unset($_SESSION['change_user_id']);

$func = (isset($_GET['func'])&&($_GET['func'])!="") ? $_GET['func'] : "";

if (isset($_POST['dangnhap'])) {

    $username = addslashes($_POST['txtUsername']);
    $password = addslashes($_POST['txtPassword']);

	$error_mgs = "";
     
    if (!$username || !$password) {
        $error_mgs = "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu!";
        exit;
    }    

	$sql = "
		SELECT login.ID AS user_id, login.PASSWORD,login.USERNAME,login.TYPE
		FROM login
		WHERE USERNAME='$username' 
	"; 

    $query = mysqli_query($connect,$sql);

    if (mysqli_num_rows($query) == 0) {
        $error_mgs = "Tên đăng nhập không đúng. Vui lòng kiểm tra lại!";
    }
    else{

		$row    = mysqli_fetch_array($query);
		$userId = $row['user_id'];
		$type   = $row['TYPE']; 
     
		if (md5($password) != $row['PASSWORD']) {
			$error_mgs = "Tên đăng nhập hoặc Mật khẩu không đúng. Vui lòng kiểm tra lại!";
		}
		else{

			$sqlInfo = "
				SELECT employees.*
				FROM employees
				WHERE ID='$userId' 
			";

			if($type == 'CUSTOMER'){
				$sqlInfo = "
					SELECT customers.*, '1' AS IS_ACTIVE, 'CUSTOMER' AS POSITION
					FROM customers
					WHERE ID='$userId' 
				";
			}

			$queryUser = mysqli_query($connect,$sqlInfo);
			$rowUser   = mysqli_fetch_array($queryUser); 

			if(!$rowUser['IS_ACTIVE']){
				$error_mgs = "Tài khoản đã bị khoá! Vui lòng liên hệ với ADMIN";
			}
			else{
				$error_mgs = "";

				$_SESSION['username'] = $username;
				$_SESSION['user_id']  = $rowUser['ID'];
				$_SESSION['name']     = $rowUser['NAME'];
				$_SESSION['position'] = $rowUser['POSITION'];
			
				header("location:admin.php");
				die();
			}

		}
	}
}
else if(isset($_POST['forgot_pwd'])){

	$func = "forgot_pwd";
	
    $username = addslashes($_POST['txtUsername']);
    $email    = addslashes($_POST['txtEmail']);

	$error_forgot = "";

	$sql = "
		SELECT login.ID AS user_id, login.PASSWORD,login.USERNAME, employees.*
		FROM login
			LEFT JOIN employees on employees.ID = login.ID
		WHERE USERNAME='$username' AND EMAIL = '$email' 
		LIMIT 1
	";

    $query = mysqli_query($connect,$sql);

    if (mysqli_num_rows($query) == 0) {
        $error_forgot = "Tên đăng nhập không đúng. Vui lòng kiểm tra lại!";
    }
	else{

		foreach($query as $info){
			$is_active = $info['IS_ACTIVE'];
			$user_id   = $info['user_id'];
		}

		if(!$is_active){
			$error_forgot = "Tài khoản đã bị khoá! Vui lòng liên hệ với ADMIN";
		}
		else{
			$_SESSION['change_user_id'] = $user_id;
		}

		$func = "reset_pwd";
	}
}
else if(isset($_POST['change_pwd'])){

	$func = "reset_pwd";
	
    $password    = addslashes($_POST['txtChangePwd']);
    $re_password = addslashes($_POST['txtReChangePwd']);

	$pattern_pwd = "/^(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*\d).+$/";

	if($password != $re_password){
		$error_change_pwd = "Xác nhận Mật khẩu không đúng!";
	}
	else if(!preg_match($pattern_pwd, $re_password)){
		$error_change_pwd = "Mật khẩu phải bao gồm kí tự in hoa, có cả số và chữ!";
	}
	else{
		$sql1 = "UPDATE `login` SET `PASSWORD`=md5('$re_password') WHERE ID='".$_SESSION['change_user_id']."'"; 
		$res1 = $connect->query($sql1);

		if($res1){

			?>
				<script>alert('Cập nhật thành công!')</script>
			<?php

			unset($_SESSION['change_user_id']);

			header("Location: index.php");
			$func = "";
		}
		else{
			$error_change_pwd = "Lỗi cập nhật!";
		}
	}
}
else if(isset($_POST['create_account'])){
	$func = "create_account"; $error_create = "";

	$name        = addslashes($_POST['txtName']);         
    $email       = addslashes($_POST['txtEmail']);        
	$username    = addslashes($_POST['txtUsername']);     
	$password    = addslashes($_POST['txtChangePwd']);    
    $re_password = addslashes($_POST['txtReChangePwd']);  

	$_SESSION['create'] = array(
		'name'        => $name,        'email'    => $email,
		'username'    => $username,    'password' => $password,
		're_password' => $re_password,
	);

	$pattern_username = "/^[^\s]+$/";
	$pattern_mobile   = "/^(?:\+84|0)(?:3[2-9]|5[2-9]|7[0|6-9]|8[1-9]|9[0-9])\d{7}$/";
	$pattern_email    = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
	$pattern_cmnd     = "/^\d{9}$|^\d{12}$/";
	$pattern_pwd      = "/^(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*\d).+$/";

	$arrError_Create = array();
	
	if (!preg_match($pattern_email, $email)) {
		$arrError_Create[] = "Email không hợp lệ!";
		unset($_SESSION['create']['email']);
	}

	if (!preg_match($pattern_username, $username)) {
		$arrError_Create[] = "Tên đăng nhập không hợp lệ!";
		unset($_SESSION['create']['username']);
	}

	if($password != $re_password){
		$arrError_Create[] = "Xác nhận mật khẩu không đúng!";
		unset($_SESSION['create']['password']);
		unset($_SESSION['create']['re_password']);
	}
	else{
		if (!preg_match($pattern_pwd, $password)) {
			$arrError_Create[] = "Mật khẩu phải bao gồm kí tự in hoa, có cả số và chữ!";
			unset($_SESSION['create']['password']);
			unset($_SESSION['create']['re_password']);
		}
	}

	if(count($arrError_Create) > 0){
		foreach ($arrError_Create as $key => $value) {
			$error_create .= "• ".$value." <br>";
		}
	}
	else{
		$checkUserName = "
			SELECT USERNAME
			FROM login
			WHERE USERNAME = '".$username."'
			LIMIT 1
		"; 
 
		$resCheck  = $connect->query($checkUserName); 

		if(mysqli_num_rows($resCheck)){ // Check trùng
			$error_create = "Tên đăng nhập đã tồn tại!";
			unset($_SESSION['create']['username']);
		}
		else{

			$sql ="
				INSERT INTO `customers` (`NAME`,`EMAIL`) 
				VALUES ('$name','$email')
			";

			$resInsert = mysqli_query($connect, $sql);

			if($resInsert){
				$cusId = mysqli_insert_id($connect); 

				$scriptLogin = "
					INSERT INTO `login`(`ID`,`USERNAME`, `PASSWORD`, `TYPE`) 
					VALUES ('$cusId','$username',md5('$password'), 'CUSTOMER')
				"; 

				$resLogin = mysqli_query($connect, $scriptLogin);

				if($resLogin){
					$_SESSION['username'] = $username;
					$_SESSION['user_id']  = $cusId;
					$_SESSION['name']     = $name;
					$_SESSION['position'] = "CUSTOMER";

					unset($_SESSION['create']);

					header("location:admin.php");
					die();
				}
				else{
					$error_create = "Lỗi tạo tài khoản!"; unset($_SESSION['create']);
				}
			}
			else{
				$error_create = "Lỗi tạo tài khoản!"; unset($_SESSION['create']);
			}

		}
	}
}

?>

	<div class="logo pull-left">
		<img src="images/logo.png" width="100" alt="Hutech" style="border:none; display:block;">
	</div>

	<div class="login-content">

		<div>
			<img src="images/banner0.png" style="width:1000px; height: 500px">
		</div>

		<div class="login-contentT" >

			<div class="login-wrapper">

				<?php 
				
					if($func == 'forgot_pwd'){
						?>
							<div>
								<h3>Quên mật khẩu</h3>
							</div>

							<form method="post" action="index.php" >
								<label for="txtUsername">
									Tên đăng nhập <span style="color:red">*</span>
									<input autocomplete="off" onchange="onChangeVal()" type="text" name="txtUsername" id="txtUsername" required="required" />
								</label>
								<label for="txtEmail">
									Email<span style="color:red">*</span>
									<input autocomplete="off" onchange="onChangeVal()" type="text" name="txtEmail" id="txtEmail" required="required" />
								</label>

								<div>
									<input type="submit" class="btn btn-primary" name="forgot_pwd" value="Kiểm tra" ></input>
									<br>
									<span class="error_lb"><?php echo $error_forgot; ?></span>
								</div>

								<div style="margin: 10px 0;text-align: right;">
									<a href="index.php">Trang chủ</a>
								</div>

							</form>

						<?php
					}
					else if($func == 'reset_pwd'){
						?>

							<div>
								<h3>Thay đổi mật khẩu</h3>
							</div>

							<form method="post" action="index.php" >
								<label for="txtChangePwd">
									Mật khẩu mới <span style="color:red">*</span>
									<input placeholder="Mật khẩu phải viết hoa 1 kí tự đầu, có số và chữ" autocomplete="off" onchange="onChangeVal()" type="password" name="txtChangePwd" id="txtChangePwd" required="required" />
								</label>
								<label for="txtReChangePwd">
									Xác nhận Mật khẩu<span style="color:red">*</span>
									<input placeholder="Mật khẩu phải viết hoa 1 kí tự đầu, có số và chữ" autocomplete="off" onchange="onChangeVal()" type="password" name="txtReChangePwd" id="txtReChangePwd" required="required" />
								</label>

								<div>
									<input type="submit" class="btn btn-primary" name="change_pwd" value="Kiểm tra" ></input>
									<br>
									<span class="error_lb"><?php echo $error_change_pwd; ?></span>
								</div>

								<div style="margin: 10px 0;text-align: right;">
									<a href="index.php">Trang chủ</a>
								</div>

							</form>

						<?php
					}
					else if($func == 'create_account'){
						?>

							<div>
								<h3>Đăng ký thành viên</h3>
							</div>

							<form method="post" action="index.php" >
								<label for="txtName">
									Họ tên <span style="color:red">*</span>
									<input autocomplete="off" onchange="onChangeVal()" type="text" name="txtName" id="txtName" required="required" value="<?php echo @$_SESSION['create']['name']; ?>" />
								</label>
								<label for="txtEmail">
									Email<span style="color:red">*</span>
									<input autocomplete="off" onchange="onChangeVal()" type="text" name="txtEmail" id="txtEmail" required="required" value="<?php echo @$_SESSION['create']['email']; ?>" />
								</label>
								<label for="txtUsername">
									Tên đăng nhập <span style="color:red">*</span>
									<input autocomplete="off" onchange="onChangeVal()" type="text" name="txtUsername" id="txtUsername" required="required" value="<?php echo @$_SESSION['create']['username']; ?>" />
								</label>
								<label for="txtChangePwd">
									Mật khẩu mới <span style="color:red">*</span>
									<input placeholder="Mật khẩu phải viết hoa 1 kí tự đầu, có số và chữ" autocomplete="off" onchange="onChangeVal()" type="password" name="txtChangePwd" id="txtChangePwd" required="required" value="<?php echo @$_SESSION['create']['password']; ?>" />
								</label>
								<label for="txtReChangePwd">
									Xác nhận Mật khẩu<span style="color:red">*</span>
									<input placeholder="Mật khẩu phải viết hoa 1 kí tự đầu, có số và chữ" autocomplete="off" onchange="onChangeVal()" type="password" name="txtReChangePwd" id="txtReChangePwd" required="required" value="<?php echo @$_SESSION['create']['re_password']; ?>" />
								</label>
								<div>
									<input type="submit" class="btn btn-primary" name="create_account" value="Kiểm tra" ></input>
									<br>
									<span class="error_lb"><?php echo $error_create; ?></span>
								</div>

								<div style="margin: 10px 0;text-align: right;">
									<a href="index.php">Trang chủ</a>
								</div>

							</form>

						<?php 
					}
					else { ?>
						<div>
							<h3>Đăng nhập</h3>
						</div>

						<form method="post" action="index.php" >
							<label for="username">
								Tài Khoản
								<input autocomplete="off" onchange="onChangeVal()" type="text" name="txtUsername" id="username" required="required" />
							</label>
							<label for="password" style="margin-bottom: 0px;">
								Mật khẩu
								<input autocomplete="off" onchange="onChangeVal()" type="password" name="txtPassword" id="password" required="required" />
							</label>

							<div style="margin-top: -15px; margin-bottom:10px;">
								<a href="?func=forgot_pwd"><i>Quên mật khẩu?</i></a>
							</div>

							<div>
								<input type="submit" class="btn btn-primary" name="dangnhap" value="Đăng nhập" ></input>
								<br>
								<span class="error_lb"><?php echo $error_mgs; ?></span>
							</div>

							<div style="margin: 10px 0;text-align: right;">
								Không phải thành viên? <a href="?func=create_account">Đăng ký ngay</a>
							</div>

						</form>
				<?php } ?>

			</div>

		</div>

	</div>

	
	<script type="text/javascript" src="vendor/bootstrap.js"></script>  
	<script type="text/javascript" src="vendor/angular-1.5.min.js"></script>  
	<script type="text/javascript" src="vendor/angular-animate.min.js"></script>
	<script type="text/javascript" src="vendor/angular-aria.min.js"></script>
	<script type="text/javascript" src="vendor/angular-messages.min.js"></script>
	<script type="text/javascript" src="vendor/angular-material.min.js"></script>  
	<script type="text/javascript" src="2.js"></script>

	<script>

		function onChangeVal(id) {
			$('#error').html('');
		}

	</script>
</body>
</html>