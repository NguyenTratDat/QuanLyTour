<!DOCTYPE html>
<html lang="en"  >
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 	
	<link rel="stylesheet" href="vendor/bootstrap.css">
	<link rel="stylesheet" href="vendor/angular-material.min.css">
	<link rel="stylesheet" href="vendor/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<link rel="stylesheet" type="text/css" href="css/component.css" />
	<link rel="stylesheet" type="text/css" href="css/1.css">
	<link rel="stylesheet" type="text/css" href="css/cart.css">
	<script src="js/modernizr.custom.js"></script>
</head>

<body ng-app="myApp" ng-controller="MyController">
	
	<form method="post" name="chitiettour">
		<div class="container menu">	

			<?php 
				include("connection.php");

				$id=$_GET['idTour'];
				
				$sql   = "SELECT * FROM `thongtinchitiettour`where ID='$id'";
				$tours = $connect->query($sql);
			?>

			<?php

				foreach ($tours as $tour) 
				{
					?>

					<div class="container body1">
						<div class="infor" align="left">
							<table class="chitiettour" align="center" width="1100px" border="0px" cellpadding="2px" cellspacing="2px">
								<tr>	
									<td rowspan="3" width="60%"><div id="nametour"><h4><?php echo $tour['NAME'] ?></h4></div>
										<img src="images/<?php echo $tour['IMAGE'] ?>" alt="" width="95%" height="400px">
									</td>
									<td id="idtour" colspan="3" align="left" width="20%">

										Mã Tour:<br><br>
										Ngày đi:<br><br>
										Ngày về:<br><br>
										Phân loại:<br>										

									</td>
									<td width="20%">
										<div id="idtour1">
											<?php echo $tour['ID'] ?><br><br>
											<?php echo date("d/m/Y", strtotime($tour['START'])) ?><br><br>
											<?php echo date("d/m/Y", strtotime($tour['END'])) ?><br><br>
											<?php echo $tour['KIND_TOUR']?><br>
										</div>
									</td>
								</tr>

								<tr>
									<td id="idtour2" colspan="3">
										<p>Số người tối đa:&nbsp;&nbsp;&nbsp;<?php  echo $tour['MAX_PEOPLE']?><br></p>
									</td>
								</tr>

								<tr>
									<td colspan="3" align="left" id="price">
										<div >
											<p>Người lớn: <?php echo number_format($tour['ADULT_PRICE'])?> VNĐ</p>
											<p>Trẻ em: <?php echo number_format($tour['CHILD_PRICE'])?> VNĐ</p>
										</div>
									</td>
									<td align="right">
										<p><button class="btn btn-danger" style="width: 200px"><a href="?page=dangkitour&idtour=<?php echo $tour['ID']?>">Đặt ngay</button></p>									</td>
								</tr>
							</table>
						</div>
					</div>

					<br><br>

					<div class="container body2" align="float-xs-left">
						<table align="center" width="1100px" border="0px" cellpadding="2px" cellspacing="2px">
							<tr style="text-align:left;">	
								<td rowspan="3" width="70%"><div id="nametour">

									<div class="firstWord">
										<p><b>CHƯƠNG TRÌNH TOUR</b></p>
									</div>
									<div class="thongtin">
										<?php echo $tour['TOUR_PROGRAM'] ?>
									</div>
									<br><br><br>
									<div class="firstWord">
										<p><b>CHI TIẾT TOUR</b></p>
									</div>
									<div class="hotel">
										<p>Thông tin khách sạn:&nbsp; <?php echo $tour['HOTEL_NAME'] ?></p>
									</div>					

								</td>
								<td  rowspan="3"  align="left" width="20%">

								</td>
								<td width="20%">
									<div id=bannerBody2>
										<?php 
										/*----------banner-----------*/
										?>
									</div>
								</td>
							</tr>
						</table>
					</div>

					<br><br>

				<?php 
				} 
				?>

			<div class="container body2" align="float-xs-left">

				<div class="sortGoiytour" ng-hide="display">
					<?php
						include("connection.php");
						$sql2     = "select*from tours  where KIND_TOUR ='Trong Nước' and ID <> '$id'";
						$tourGoiy = $connect->query($sql2);
					?>

				</div>

				<div class="firstWord">
					<p><b>GỢI Ý TOUR</b></p>
				</div>

				<div class="row">
					<?php
						$count = 0;
						foreach ($tourGoiy as $tour) 
						{
							$count++;
							if($count==5)
								break;

						?>

						<div class="mottin">
							<div class="vien">
								<a href="?page=chitiettour&idTour=<?php echo $tour['ID']?>" class="hrefHCM">
									<img src="images/<?php echo $tour['IMAGE']?>" alt=""  width="250px" height="170px">
									<br>
									<b>	<?php echo $tour['NAME']?></b>
								</a>
							</div>
						</div>

						<?php 
						}
						?>
				</div>
				
			</div>
				
	</form>

</body>
</html>