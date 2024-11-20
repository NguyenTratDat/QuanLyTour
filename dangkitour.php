<!DOCTYPE html>
<html>
<head>
	<title> Quản lý Tour Du Lịch - Nhóm 3  </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 	
	<link rel="stylesheet" href="vendor/bootstrap.css">
	<link rel="stylesheet" href="vendor/angular-material.min.css">
	<link rel="stylesheet" href="vendor/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/1.css">
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<link rel="stylesheet" type="text/css" href="css/component.css" />
	<link rel="stylesheet" type="text/css" href="css/dangkytour.css" />
	<script src="js/modernizr.custom.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<?php 
	include("connection.php");
	
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	
	if(isset($_GET['idtour']) && !empty($_GET['idtour']))
	{
			// Thêm vào session
		$id5=$_GET['idtour'];
		$_SESSION['chon_ck'.$id5]=$id5;

	}
	//print_r($_SESSION);	 
	
	//Khai báo giá trị ban đầu, nếu không có thì khi chưa submit câu lệnh insert sẽ báo lỗi
	$tenkh = "";
	$cmnd = "";
	$dchi = "";
	$ns = "";
	$sdt = "";
	$email = "";	
		
//Lấy giá trị POST từ form vừa submit
if (isset($_POST['btndattour'])) 
{
	if(!is_numeric($_POST['txtcmnd']))
	{?>
		  <script> alert("chứng minh nhân dân phải là chuỗi số !"); </script>
	<?php
	}
	else{
		if(!is_numeric($_POST['txtsdt']))
			{?>
				  <script> alert("số điện thoại phải là chuỗi số !"); </script>
			<?php
			}
		else{
		if(isset($_POST["txttenkh"])) { $tenkh = $_POST['txttenkh']; }
		if(isset($_POST["txtcmnd"])) { $cmnd = $_POST['txtcmnd']; }
		if(isset($_POST["txtdiachi"])) { $dchi = $_POST['txtdiachi']; }
		if(isset($_POST["txtns"])) { $ns = $_POST['txtns']; }
		if(isset($_POST["txtsdt"])) { $sdt = $_POST['txtsdt']; }
		if(isset($_POST["txtemail"])) { $email = $_POST['txtemail']; }
		if(isset($_POST["txtslnguoilon"])) { $nglon = $_POST['txtslnguoilon']; }
		if(isset($_POST["txtsltreem"])) { $treem = $_POST['txtsltreem']; }

		//Code xử lý, insert dữ liệu vào table customers
		$sql3="select * from customers where IDCARD='$cmnd'";
		$query0= $connect->query($sql3);
		$num_row = $query0->rowcount();
		//echo "</br>".$num_row."</br>";
		if($num_row<1)
		{

			$sql = "INSERT INTO `customers`(`NAME`, `IDCARD`, `ADDRESS`, `PHONENUMBER`, `BIRTHDAY`, `EMAIL`) 
					VALUES ('$tenkh','$cmnd','$dchi','$sdt','$ns','$email')";
			if ($connect->query($sql) == TRUE) 
			{
				//echo "Thêm dữ liệu thành công"."<br>";
			}
			 else {
				echo "Error";
			}

		}
		$_SESSION['cmnd_'.$cmnd]=$cmnd;
		//đẩy qua trang cuối dựa vào tenkh vs cmnd để show thong tin khách trang cuối

		//thêm dữ liệu vào bảng order
		foreach($_SESSION as $key1=>$val)
		{
			$id1=substr($key1,0,5);
			if($id1=='chon_')
			{					
				$sql1 = "SELECT CHILD_PRICE,ADULT_PRICE FROM `tour_details`where ID='$val'";
				$tien= $connect->query($sql1);

				//lấy giá tiền trẻ em và người lớn
				foreach($tien as $tien1)
				{
					$child= $tien1['CHILD_PRICE'];
					$adult= $tien1['ADULT_PRICE'];	
				}
				//tính tiền
				$ttnglon=$adult* $nglon;
				$tttreem=$child * $treem;
				$total=$ttnglon+$tttreem;


				// thêm dữ liệu bảng orders
				$sql2="INSERT INTO `orders`(`TOUR_ID`, `IDCARD`, `CHILDS_AMOUNT`, `ADULTS_AMOUNT`, `TOTAL`) 	
						VALUES ('$val','$cmnd','$treem','$nglon','$total')";
				  if ($connect->query($sql2) == TRUE) 
				 {
					 //echo "Thêm dữ liệu Order thành công";

						$sqlcount="select * from orders";
						$query1= $connect->query($sqlcount);
						$num_rowID = $query1->rowcount();
						//echo "<br/>".$num_rowID;
					  $vtcuoi= $num_rowID-1;
					  //echo "<br/>".$vtcuoi."<br/>";				  	  			  

					  $sqlid="select ID from orders limit $vtcuoi,1";
					  //echo $sqlid."</br>";
					  $idcuoi=$connect->query($sqlid);
					  foreach($idcuoi as $a=>$v)
					  {
	//					  echo $a."  ".$v;
						  foreach($v as $a1=>$v1)
						  {
	//						  echo $a1."  ".$v1;
							$_SESSION['idcuoi_'.$val]=$v1;
						  }						
					  }?>
					  
				 <?php }
				  else {
					 echo "Error";
				 }		
			}
		}	    		 
	}
}
}
//Đóng database	
 $connect=null;
?>
<body >
	<form name="dangki" action="dangkitour.php" method="post" >
		<div class="container menu">	

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
			<script src="js/ttwHorizontalMenu.min.js"></script>
			<script>
				$(function() {
					ttwHorizontalMenu.init();
				});
			</script>

			<div class="container dangkitour">
			<div>
				<div id="khung"><h2>THÔNG TIN LIÊN LẠC</h2></div>
				<div id="khung_dienthongtin">
					<table id="thongtinll" align="center" width="1100px" cellpadding="15px" cellspacing="15px">
						<tr>
							<td width="10%"></td>
							<td class="pull-left" height="60px">Tên khách hàng:</td>
							<td height="60px"><input type="text" name="txttenkh" size="70px" required="required"></td>
						</tr>
						<tr>
							<td width="10%"></td>
							<td class="pull-left" height="60px">Chứng minh nhân dân:</td>
							<td height="60px"><input type="text" name="txtcmnd" size="70px" required="required"></td>
						</tr>
						<tr>
							<td width="10%"></td>
							<td class="pull-left" height="60px">Địa chỉ:</td>
							<td height="60px"><input type="text" name="txtdiachi" size="70px" required="required"></td>
						</tr>
						<tr>
							<td width="10%"></td>
							<td class="pull-left" height="60px">Số điện thoại:</td>
							<td height="60px"><input type="tel" name="txtsdt" size="70px" required="required"></td>
						</tr>
						<tr>
							<td width="10%"></td>
							<td class="pull-left" height="60px">Ngày sinh:</td>
							<td height="60px"><input type="date" name="txtns" size="70px" required="required"></td>
						</tr>
						<tr>
							<td width="10%"></td>
							<td class="pull-left" height="60px">Email:</td>
							<td height="60px"><input type="email" name="txtemail" size="70px" required="required"></td>
						</tr>
						<tr><td width="10%"></td>
							<td class="pull-left" height="60px" >Số người lớn</td>
							<td height="60px" width="110px"><input type="number" name="txtslnguoilon" min="1" max="20" value="1"></td>
						</tr>
						<tr>
							<td width="10%"></td>
							<td class="pull-left" height="60px">Số trẻ em</td>
							<td height="60px" width="110px"><input type="number" name="txtsltreem" min="0" value="0"></td>
						</tr>

					</table>
					<br>	
					
					<p align="center"><input onclick="alert('Vui lòng qua bước tiếp theo')" class="btn btn-info" type="submit" name="btndattour" value="Xác Nhận Thông Tin" size="20px"></p>
					
					<p align="center">
					<button class="btn btn-info" ><a href="cart.php?test='true'">Bước Trước</a></button>
					<button class="btn btn-info"><a href="success.php?test='true'">Bước Tiếp Theo</a></button></p>
					
					</<br>
										
				</div>		
			</div>
			</div>
		</form>

		<script type="text/javascript" src="vendor/bootstrap.js"></script>  
		<script type="text/javascript" src="vendor/angular-1.5.min.js"></script>  
		<script type="text/javascript" src="vendor/angular-animate.min.js"></script>
		<script type="text/javascript" src="vendor/angular-aria.min.js"></script>
		<script type="text/javascript" src="vendor/angular-messages.min.js"></script>
		<script type="text/javascript" src="vendor/angular-material.min.js"></script>  
		<script type="text/javascript" src="js/1.js"></script>
	</body>
	</html>