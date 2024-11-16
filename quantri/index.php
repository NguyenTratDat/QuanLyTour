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

if (isset($_POST['dangnhap'])) 
{

    $connect = mysqli_connect("localhost", "root", "", "ql_tourdulich");

	// ktra connect
	if (!$connect) {
	    die("Connection failed: " . mysqli_connect_error());
	}


    //Lấy dữ liệu nhập vào tu input
    $username = addslashes($_POST['txtUsername']);
    $password = addslashes($_POST['txtPassword']);

	$error_mgs = "";
     
    //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
    if (!$username || !$password) {
        $error_mgs = "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu!";
        exit;
    }    
     
    //Kiểm tra tên đăng nhập có tồn tại không

	$sql = "
		SELECT login.ID, login.PASSWORD,login.POSITION, employees.NAME, employees.ID as user_id
		FROM login
			left join employees on employees.ID = login.ID
		WHERE USERNAME='$username' 
	";

    $query = mysqli_query($connect,$sql);

    if (mysqli_num_rows($query) == 0) {
        $error_mgs = "Tên đăng nhập không tồn tại. Vui lòng kiểm tra lại!";
    }
    else{
		//Lấy mật khẩu trong database ra
		$row = mysqli_fetch_array($query);
     
		if (md5($password) != $row['PASSWORD']) {
			$error_mgs = "Tên đăng nhập hoặc Mật khẩu không đúng. Vui lòng kiểm tra lại!";
		}
		else{

			$error_mgs = "";

			//Lưu tên đăng nhập
			$_SESSION['username'] = $username;
			$_SESSION['user_id']  = $row['user_id'];
			$_SESSION['name']     = $row['NAME'];
			$_SESSION['position'] = $row['POSITION'];
		
			header("location:admin.php");
			die();
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

				<div>
					<h3>Đăng nhập</h3>
				</div>

				<form method="post" action="index.php" >
					<label for="username">
						Tài Khoản
						<input autocomplete="off" onchange="onChangeVal()" type="text" name="txtUsername" id="username" required="required" />
					</label>
					<label for="password">
						Mật khẩu
						<input autocomplete="off" onchange="onChangeVal()" type="password" name="txtPassword" id="password" required="required" />
					</label>

					<input type="submit" class="btn btn-primary" name="dangnhap" value="Đăng nhập" ></input>
					<br>
					<span id="error"><?php echo $error_mgs; ?></span>

				</form>

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