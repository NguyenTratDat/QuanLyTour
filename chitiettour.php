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

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>

	<script> 

		var slideIndexT = [1,1,1];
		var slideId = ["mySlides1","mySlides2"];

		setTimeout(() => {
			plusSlides(0, 1);

			setInterval(() => {
				plusSlides(1, 1);
			}, 3000);

		}, 100);

		function plusSlides(n, no) {
			showSlides_detail(slideIndexT[no] += n, no);
		}

		function showSlides_detail(n, no) {
			let i;
			let x = document.getElementsByClassName(slideId[no]); console.log(x);

			if (n > x.length) {slideIndexT[no] = 1}    
			if (n < 1) {slideIndexT[no] = x.length}

			for (i = 0; i < x.length; i++) {
				x[i].style.display = "none";  
			}

			x[slideIndexT[no]-1].style.display = "block";  
		}

	</script>
</head>

<body ng-app="myApp" ng-controller="MyController">
	
	<form method="post" name="chitiettour">
		<div class="container menu">	

			<?php 
				include("connection.php");

				$id=$_GET['idTour'];
				
				$sql   = "
					SELECT tours.*, START, END, EXPIRED, CHILD_PRICE, ADULT_PRICE, TOUR_PROGRAM, HOTEL_NAME,
						IMAGE_DETAIL, PDF, DETAIL_TEXT,
						(select SUM(TOTAL_PEOPLE) FROM tour_log WHERE TOUR_ID = tours.ID) as total_people
					FROM tours
						LEFT JOIN tour_details ON tour_details.ID = tours.ID
					WHERE tours.ID='$id'
				";

				$tours = $connect->query($sql);
			?>

			<?php

				foreach ($tours as $tour) 
				{
					$IS_ACTIVE       = $tour['IS_ACTIVE'];
					$total_people    = $tour['total_people'];
					$MAX_PEOPLE      = $tour['MAX_PEOPLE'];
					$EXPIRED         = $tour['EXPIRED']; 
					$END             = $tour['END'    ]; 
					$today           = date('Y-m-d');

					$flag_Disabled   = false;

					if(!$IS_ACTIVE || $total_people >= $MAX_PEOPLE || $EXPIRED < $today || $END <= $today ){
						$flag_Disabled = true;
					}

			?>

					<div class="container body1">
						<div class="infor" align="left">
							<table class="chitiettour" align="center" width="1100px" border="0px" cellpadding="2px" cellspacing="2px">
								<tr>	
									<td rowspan="3" width="60%">
										<div id="nametour">
											<h4><?php echo $tour['NAME'] ?></h4>
										</div>

										<!-- <img src="images/<?php echo $tour['IMAGE'] ?>" alt="" width="95%" height="400px"> -->

										<div class="slideshow-containerT">

											<?php if(@$tour['IMAGE']){ ?>
												<div class=" mySlides2">
													<img src="<?php echo "images/".$tour['IMAGE'] ?>"  width="95%" height="400px" height=150px>
												</div>
											<?php } ?>

											<?php if(@$tour['IMAGE_DETAIL']){ 
												$arrImg = explode(',', $tour['IMAGE_DETAIL']);

												foreach ($arrImg as $value) {
													
													?>  

														<div class=" mySlides2">
															<img src="<?php echo "details/".$id."/".$value ?>"  width="95%" height="400px" height=150px>
														</div>

													<?php

												}

											?>

											<?php } ?>

											<?php if(@$tour['IMAGE_DETAIL']){ ?>

												<a class="prev" onclick="plusSlides(-1, 1)">&#10094;</a>
												<a class="next" onclick="plusSlides(1, 1)">&#10095;</a>

											<?php } ?>

										</div>

									</td>
									<td id="idtour" colspan="3" align="left" width="20%">

										Mã Tour:<br><br>
										Ngày đi:<br><br>
										Ngày về:<br><br>
										Phân loại:<br><br>	
										Ngày hết hạn đăng ký<span style="color:red">**</span>:<br>								

									</td>
									<td width="20%">
										<div id="idtour1">
											<?php echo $tour['ID'] ?><br><br>
											<?php echo date("d/m/Y", strtotime($tour['START'])) ?><br><br>
											<?php echo date("d/m/Y", strtotime($tour['END'])) ?><br><br>
											<?php echo $tour['KIND_TOUR']?><br><br>
											<?php echo date("d/m/Y", strtotime($tour['EXPIRED'])) ?><br>
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
										<p>

											<?php if($flag_Disabled){ ?>
												<button class="btn btn-danger" disabled="disabled" style="width: 200px">
													Hết hạn đăng ký
												</button>
											<?php } else { ?>
												<button class="btn btn-danger" style="width: 200px">
													<a href="?page=dangkitour&idtour=<?php echo $tour['ID']?>">
														Đặt ngay
												</button>
											<?php } ?>

										</p>
									</td>
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

										<?php if(@$tour['PDF']){ ?>
											<p>Xem lịch trình tại đây:&nbsp;<a target="_blank" href="<?php echo "details/".$id."/".$tour['PDF'] ?>" ><?php echo @$tour['PDF'] ?></a> 
										<?php } ?>   
										

										<?php 
											if(@$tour['DETAIL_TEXT'] && $tour['DETAIL_TEXT'] != ''){ 

												$detail          = json_decode($tour['DETAIL_TEXT'], true); 
												$count_detail    = 0;

												$pathT     = getcwd();
												$pathImg   = str_replace("quantri","images",$pathT);
												$pathFile  = str_replace("quantri","details",$pathT);

												foreach ($detail as $key => $value) {
													$content = $value['content'];
													$image   = ($value['image']) ?: '';
													$count_detail ++;

													?>

														<div style="border-bottom: 1px solid #ccc;padding: 10px;" class="detail-content" id="detail-content-<?php echo $count_detail;?>">
															
															<?php if($image != ''){ ?>
																<iframe width="600" height="400" allowfullscreen style="border-style:none;" src="./js/standalone/pannellum.htm?panorama=/quan_ly_tour_nhom_3/details/<?php echo $id;?>/detail/<?php echo $image;?>"></iframe>
															<?php }
															?>
															
															<div class="div-detail-content">
																<div class="detail-1">
																	<div>
																		<?php echo $content; ?>
																	</div>
																</div>
															</div>
														</div>

													<?php

												}
										?>

										<?php } ?>   
										
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