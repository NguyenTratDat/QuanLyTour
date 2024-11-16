<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="vendor/bootstrap.css">
	<link rel="stylesheet" href="vendor/angular-material.min.css">
	<link rel="stylesheet" href="vendor/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/success.css">
	
</head>

<?php
include("connection.php");
session_start();	  

// xóa các session chon_
if(isset($_GET['test']))		
{
	foreach($_SESSION as $khoa=>$value)
	{
		$key= substr($khoa,0,5);
		if($key=='chon_')
		{
			unset($_SESSION[$khoa]);

		}
	}
}

	//print_r($_SESSION);
?>
<body >
	<div class="container body">
		<div class="container ima">
			<img src="images/thegioi1.jpg" width="1100px" alt="">
		</div>
		<div class="container">
			<br>
			<h3 align="center" style="color: red">Chúc mừng bạn đã đặt tour thành công</h3>
			<h3 align="center" style="color: red">Thông tin của bạn đã được gửi đi. Chúng tôi sẽ sớm liên hệ với bạn</h3>
			<h3 align="center" style="color: red">Cảm ơn bạn đã tin tưởng dịch vụ của công ty chúng tôi</h3>
			<!--	<p align="center"><a href="index.php">Bấm vào đây để về lại trang chủ</a></p>-->
			<div class="container" align="center">
				<br>
				<div class="title">
					<p>Thông tin thanh toán</p>
				</div>
				<table width="1000px" align="center" id="abc" border="2px" cellpadding="2px" cellspacing="2px">
					<th>Mã thanh toán</th>
					<th>Tên tour</th>			
					<th>Số lượng người lớn</th>
					<th>Số lượng trẻ em</th>
					<th>Tổng thanh toán	</th>			
					<tr>
						<?php
						$sumTotal = 0;
						foreach($_SESSION as $k=>$v)
						{
							$idorder=substr($k,0,7);

							if($idorder=='idcuoi_')
							{

								$sql10="select * from orders where ID='$v'";
								$varid= $connect->query($sql10);
								foreach( $varid as $var)
									{?>
										<?php 
				//SELECT `ID`, `NAME`, `KIND_TOUR`, `MAX_PEOPLE`, `IMAGE` FROM `tours` WHERE 1
										$matour=$var['TOUR_ID'];
										$sqltt="select NAME from tours where ID='$matour'";
										$tentour=$connect->query($sqltt);
										$sumTotal += $var['TOTAL'];				
										?>
										<td><?php echo $var['ID']?></td>
										<td><?php foreach( $tentour as $t) {echo $t['NAME'];} ?></td>
										<td><?php echo $var['ADULTS_AMOUNT']?></td>
										<td><?php echo $var['CHILDS_AMOUNT']?></td>
										<td><?php echo $var['TOTAL']?></td>
									<?php	}
								}?>
								</tr>	<?php
							}		
							?>	
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>Tổng tiền: <?php echo $sumTotal ?></td>
							</tr>

						</div>

					</table>
					<br>
					<div class="title"><p>Thông tin liên lạc</p></div>
					<div class="container" align="center">
						<table width="1000px" align="center" id="abc" border="2px">
							<th align="" height="50px" width="200px">Tên khách</th>
							<th  height="50px">Chứng minh nhân dân</th>
							<th  height="50px">Địa chỉ</th>
							<th height="50px">Ngày sinh</th>
							<th height="50px">Email</th>
							<th height="50px">Ghi chú</th>		
							<tr>
								<?php
								foreach($_SESSION as $kcmnd=>$vcmnd)
								{
									$gtcmnd=substr($kcmnd,0,5);				
									if($gtcmnd=='cmnd_')
									{
										$sql1="select *from customers where IDCARD='$vcmnd'";
										$t=$connect->query($sql1);
										foreach ($t as $a) 
										{
											?>
											<td height="40px"><?php echo $a['NAME']?></td>
											<td height="40px"><?php echo $a['IDCARD']?></td>
											<td height="40px"><?php echo $a['ADDRESS']?></td>
											<td height="40px"><?php echo $a['BIRTHDAY']?></td>
											<td height="40px"><?php echo $a['EMAIL']?></td>
											<td height="40px"><?php echo $a['NOTES']?></td>
										</tr>
									<?php } 
								}
							}
							?>		
						</table>
					</div>
					<br><br>


					<div class="container">

						<button class="btn btn-info" name="ketthuc">
							<body>
							<a style = color:red href="index.php?test='true'">Quay về trang chủ</a>
							</body>	
							</button>
					</div>
				</div>
			</div>
		</body>
		</html>