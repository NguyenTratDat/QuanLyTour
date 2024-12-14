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
	$idtour = $_GET['idtour'];
}
else{
	header("Location: index.php");
}

if (isset($_POST['btndattour'])) 
{ 	

	$flagOK = true; $arrError = array(); $mgs = "";

	$tenkh   = ($_POST['txttenkh'])      ?: '';
	$cmnd    = ($_POST['txtcmnd'])       ?: '';
	$dchi    = ($_POST['txtdiachi'])     ?: '';
	$ns      = ($_POST['txtns'])         ?: '';
	$sdt     = ($_POST['txtsdt'])        ?: '';
	$email   = ($_POST['txtemail'])      ?: '';
	$nglon   = ($_POST['txtslnguoilon']) ?: 1;
	$treem   = ($_POST['txtsltreem'])    ?: 0;

	$pattern_mobile   = "/^(?:\+84|0)(?:3[2-9]|5[2-9]|7[0|6-9]|8[1-9]|9[0-9])\d{7}$/";
	$pattern_email    = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
	$pattern_cmnd     = "/^\d{9}$|^\d{12}$/";

	$dob   = new DateTime($ns);     $today = new DateTime();
	$age   = $today->diff($dob)->y;

	if (!preg_match($pattern_cmnd, $cmnd)) {
		$arrError[] = "CMND không hợp lệ!";
		$_POST['txtcmnd'] = '';
	}
	
	if (!preg_match($pattern_mobile, $sdt)) {
		$arrError[] = "Số điện thoại không hợp lệ!";
		$_POST['txtsdt'] = '';
	}

	if (!preg_match($pattern_email, $email)) {
		$arrError[] = "Email không hợp lệ!";
		$_POST['txtemail'] = '';
	}

	if ($age < 18) {
		$arrError[] = "Ngày sinh không hợp lệ (>= 18 tuổi)!";
		$_POST['txtns'] = '';
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
		$checkCus_sql = "select * from customers where IDCARD='$cmnd'";
		$resCheckCus  = $connect->query($checkCus_sql);
		$countCus     = $resCheckCus->rowcount();

		if(!$countCus){
			$insertCus_sql = "
				INSERT INTO `customers`(`NAME`, `IDCARD`, `ADDRESS`, `PHONENUMBER`, `BIRTHDAY`, `EMAIL`) 
				VALUES ('$tenkh','$cmnd','$dchi','$sdt','$ns','$email')
			";

			$connect->exec($insertCus_sql);

			$CustomerID = $connect->lastInsertId();
		}
		else{
			foreach($resCheckCus as $info){
				$CustomerID = $info['ID'];
			}
		}

		$checkTour_Available_sql = "
			SELECT tour_details.*, tours.MAX_PEOPLE, 
				( SELECT sum(tour_log.TOTAl_PEOPLE) FROM tour_log WHERE tour_log.TOUR_ID = tours.id AND tour_log.STATUS = 'NEW' ) AS Total_Cus
			FROM tours
				LEFT JOIN tour_details ON tour_details.id = tours.id
			WHERE tours.id = '$idtour' AND tours.IS_ACTIVE = 1 AND tour_details.EXPIRED >= NOW()
		";
		

		$resTour_Available  = $connect->query($checkTour_Available_sql);
		if(!$resTour_Available->rowcount()){
			?>
				<script>alert( `Tour hiện tại không khả dụng. Quý khách vui lòng thử lại sau! ` )</script>
			<?php
		}
		else{

			foreach($resTour_Available as $tourInfo){

				$Total_Cus    = ($tourInfo['Total_Cus']) ?: 0;
				$MAX_PEOPLE   = $tourInfo['MAX_PEOPLE'];  $num_people   = $MAX_PEOPLE - $Total_Cus;
				$CHILD_PRICE  = $tourInfo['CHILD_PRICE']; $total_people = $nglon + $treem;
				$ADULT_PRICE  = $tourInfo['ADULT_PRICE'];

				if($MAX_PEOPLE < $Total_Cus + $total_people){
					?>
						<script>alert( `Vượt quá số lượng người cho phép (SL Còn lại: <?php echo $num_people; ?>  )` )</script>
					<?php
				}
				else{
					$amount_child = $CHILD_PRICE * $treem; 
					$amount_adult = $ADULT_PRICE * $nglon;
					$amount_total = $amount_child + $amount_adult;

					$logTour_sql = "
						INSERT INTO `tour_log`(`TOUR_ID`, `CUSTOMER_ID`, `CHILDS_AMOUNT`, `ADULTS_AMOUNT`, `TOTAL`, `TOTAL_PEOPLE`, `CODE_PAY`) 	
						VALUES ('$idtour','$CustomerID','$treem','$nglon','$amount_total','$total_people' ,UNIX_TIMESTAMP())
					";

					if ($connect->exec($logTour_sql)){

						$logId = $connect->lastInsertId();

						$_SESSION['create_tour_log'] = $logId;

						?>
							<script>window.location = '?page=success'</script>
						<?php
					}
					else{
						?>
							<script>alert( `Đã xảy ra lỗi trong quá trình thao tác. Quý khách vui lòng thử lại sau! ` )</script>
						<?php
					}
				}
			}
		}
	}


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
	<form name="dangki" action="index.php?page=dangkitour&idtour=<?php echo $idtour; ?>" method="post" >
		<div class="container menu">	

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

			<div class="container dangkitour">
				<div id="khung"><h2>THÔNG TIN LIÊN LẠC</h2></div>

					<div id="khung_dienthongtin">
						<table id="thongtinll" align="center" width="1100px" cellpadding="15px" cellspacing="15px">
							<tr>
								<td width="10%"></td>
								<td class="pull-left" height="60px">Tên khách hàng:</td>
								<td height="60px"><input type="text" name="txttenkh" size="70px" required="required" value="<?php echo @$_POST['txttenkh'];?>"></td>
							</tr>
							<tr>
								<td width="10%"></td>
								<td class="pull-left" height="60px">Chứng minh nhân dân:</td>
								<td height="60px"><input type="text" name="txtcmnd" size="70px" required="required" value="<?php echo @$_POST['txtcmnd'];?>"></td>
							</tr>
							<tr>
								<td width="10%"></td>
								<td class="pull-left" height="60px">Địa chỉ:</td>
								<td height="60px"><input type="text" name="txtdiachi" size="70px" required="required" value="<?php echo @$_POST['txtdiachi'];?>"></td>
							</tr>
							<tr>
								<td width="10%"></td>
								<td class="pull-left" height="60px">Số điện thoại:</td>
								<td height="60px"><input type="tel" name="txtsdt" size="70px" required="required" value="<?php echo @$_POST['txtsdt'];?>"></td>
							</tr>
							<tr>
								<td width="10%"></td>
								<td class="pull-left" height="60px">Ngày sinh:</td>
								<td height="60px"><input type="date" class="pull-left" name="txtns" size="70px" required="required" value="<?php echo @$_POST['txtns'];?>"></td>
							</tr>
							<tr>
								<td width="10%"></td>
								<td class="pull-left" height="60px">Email:</td>
								<td height="60px"><input type="text" name="txtemail" size="70px" required="required" value="<?php echo @$_POST['txtemail'];?>"></td>
							</tr>
							<tr><td width="10%"></td>
								<td class="pull-left" height="60px" >Số người lớn</td>
								<td height="60px" width="110px"><input class="pull-left" type="number" style="width: 100px;" name="txtslnguoilon" min="1" max="20" value="<?php echo (@$_POST['txtslnguoilon'])?:1;?>"></td>
							</tr>
							<tr>
								<td width="10%"></td>
								<td class="pull-left" height="60px">Số trẻ em</td>
								<td height="60px" width="110px"><input class="pull-left" type="number" style="width: 100px;" name="txtsltreem" min="0" value="<?php echo (@$_POST['txtsltreem']) ?: 0;?>"></td>
							</tr>

						</table>
						<br>	
						
						<p align="center">
							<input type="submit" class="btn btn-primary" name="btndattour" value="Kiểm tra">
						</p>
						
						<br>
											
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