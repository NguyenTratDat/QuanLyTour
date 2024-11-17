<!DOCTYPE html>
<html lang="en"  >
<head>
	<title> Quản lý Tour Du Lịch - Nhóm 3  </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 	
	<link rel="stylesheet" href="vendor/bootstrap.css">
	<link rel="stylesheet" href="vendor/angular-material.min.css">
	<link rel="stylesheet" href="vendor/font-awesome.css">
	<link rel="stylesheet" href="1.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<?php session_start(); ?>
<body ng-app="myApp" ng-controller="MyController">
	
	<form action="" method="post" class="index" enctype="multipart/form-data" >

		<div>

			<div class="logo pull-left">
				<img src="images/logo.png" width="100" alt="Hutech" style="border:none; display:block;">
			</div>

			<div class="login loginT" align="right">
				<h5>

					<?php 
					if (isset($_SESSION['name']) && $_SESSION['name']){
						echo 'Xin chào, ['.$_SESSION['name']."]<br/>";
					}
					else{
						echo "Bạn chưa đăng nhập";

						header("Location: index.php");
					}
					?>

				</h5>
				<button class="btn btn-primary"><a href="dangxuat.php">Đăng xuất</a></button>
			</div>

			<div class="container  text-xs-center">
				<h2 class="display-4">Quản lý Tour Du Lịch - Nhóm 3!</h1>
			</div>

		</div>

		<br>

		<br>

		<?php 
			include("navbar.php");
		?>

		<div id="chucnang">
			<?php
				if(isset($_GET['quanly'])&&($_GET['quanly'])!=''){
					$tam= $_GET['quanly'];
				}
				else
				{
					$tam ='';
				}

				if($tam == 'admin')
				{
					include('admin.php');
				}
				
				if($tam == 'list_qltourdl')
				{
					include('list_qltourdl.php');
				}
				elseif($tam == 'dskhachdk')
				{
					include('dskhachdk.php');
				}
				elseif($tam == 'list_employees')
				{
					include('list_employees.php');
				}
				elseif($tam == 'show_employee')
				{
					include('show_employee.php');
				}
				elseif($tam == 'add_tour')
				{
					include('add_tour.php');
				}
				elseif($tam == 'add_tour_detail')
				{
					include('add_tour_details.php');
				}
				elseif($tam == 'show_tour_details')
				{
					include('show_tour_details.php');
				}
				elseif($tam == 'send_email')
				{
					include('email.php');
				}
				elseif($tam == 'add_employees')
				{
					include('add_employees.php');
				}
				elseif($tam == 'change_password')
				{
					include('change_password.php');
				}
				
			?>
		</div>

		<?php if($tam == 'admin' || $tam == ''){ ?>

			<div style="margin: 50px 0;">

				<section id="team" class="team section" data-builder="section">

					<div class="container section-title aos-init aos-animate" data-aos="fade-up" data-builder="section-title">
						<h2>Thành viên</h2>
					</div>

					<div class="container">

						<div class="row gy-4">
						
							<div class="col-lg-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
								<div class="team-member d-flex align-items-start">
									<div class="pic"><img src="images/avatar1.png" class="img-fluid" alt=""></div>
									<div class="member-info">
									<h4>Lê Hải Nhất Hiếu</h4>
									<span>MSSV: 2210060075</span>
									<p>Lớp: 22TXTH01</p>
									</div>
								</div>
							</div>
						
							<div class="col-lg-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
								<div class="team-member d-flex align-items-start">
									<div class="pic"><img src="images/avatar2.png" class="img-fluid" alt=""></div>
									<div class="member-info">
									<h4>Nguyễn Trát Đạt</h4>
									<span>MSSV: 2210060048</span>
									<p>Lớp: 22TXTH01</p>
									</div>
								</div>
							</div>
						
						</div>

					</div>

				</section>

			</div>

		<?php } ?>

		<footer>

			<ul style="display:none;">
				<li>

					<div class="text">
						<h4>Khám phá sản phẩm</h4>
						<div class="sub-text">Hãy tận hưởng trải nghiệm du lịch chuyên nghiệp, mang lại cho bạn những khoảnh khắc tuyệt vời và nâng tầm cuộc sống. Chúng tôi cam kết mang đến những chuyến đi đáng nhớ, giúp bạn khám phá thế giới theo cách hoàn hảo nhất.</div>
					</div>
				</li>
				<li>

					<div class="text">
						<h4>Điểm đến yêu thích</h4>
						<div class="sub-text">Hãy chọn một điểm đến du lịch nổi tiếng dưới đây để khám phá các chuyến đi độc quyền của chúng tôi với mức giá vô cùng hợp lý.</div>
					</div>
				</li>
				<li>

					<div class="text">
						<h4>Combo giá tốt</h4>
						<div class="sub-text">Luôn thảnh thơi.
						Với sự hợp tác giảm giá ưu đãi cùng hệ thống đối tác lớn, chúng tôi tự tin mang đến cho quý khách combo vé máy bay và khách sạn với giá tốt nhất!
						</div>
					</div>
				</li>
			</ul>

			<div class="bar">

				<div class="bar-wrap">

					<div class="clear"></div>

					<!-- <div class="copyright">&copy;  Liên hệ: <b>TRƯỜNG ĐẠI HỌC CÔNG NGHỆ TP.HCM (HUTECH)</b></div>
					<div class="copyright">&copy;  Địa chỉ: 475A Điện Biên Phủ, P.25, Q.Bình Thạnh, TP.HCM</div>
					<div class="copyright">&copy;  Điện thoại: (028) 5445 7777 </div>
					<div class="copyright">&copy;  Email: hutech@hutech.edu.vn </div>
					<div class="copyright">&copy;  Quản lý Tour Du Lịch - Nhóm 3 </div> -->

					<div class="content noidung copyright">

						<div class="col-sm-9 footer-left">
							<div><b>TRƯỜNG ĐẠI HỌC CÔNG NGHỆ TP.HCM (HUTECH)</b></div>
							<div><b class="truso">Trụ sở Điện Biên Phủ:</b> 475A Điện Biên Phủ, P.25, Q.Bình Thạnh, TP.HCM</div>
							<div class="coso"><b>Cơ sở Ung Văn Khiêm:</b> 31/36 Ung Văn Khiêm, P.25, Q.Bình Thạnh, TP.HCM</div>
							<div class="coso"><b>Trung tâm Đào tạo Nhân lực chất lượng cao HUTECH:</b> Khu Công nghệ cao TP.HCM, Xa lộ Hà Nội, P.Hiệp Phú, TP.Thủ Đức, TP.HCM</div>
							<div class="coso"><b>Viện Công nghệ Cao HUTECH:</b> Khu Công nghệ cao TP.HCM, Đường D1, P.Long Thạnh Mỹ, TP.Thủ Đức, TP.HCM</div>
							<div><b>Điện thoại:</b> (028) 5445 7777 - <b>Email:</b> hutech@hutech.edu.vn</div>

							<br>

							<div class="copyright">Quản lý Tour Du Lịch - Nhóm 3 </div>

						</div>
        
    				</div>
					
				</div>

			</div>

		</footer>

	</form>

	<script type="text/javascript" src="vendor/bootstrap.js"></script>  
	<script type="text/javascript" src="vendor/angular-1.5.min.js"></script>  
	<script type="text/javascript" src="vendor/angular-animate.min.js"></script>
	<script type="text/javascript" src="vendor/angular-aria.min.js"></script>
	<script type="text/javascript" src="vendor/angular-messages.min.js"></script>
	<script type="text/javascript" src="vendor/angular-material.min.js"></script>  
	<script type="text/javascript" src="1.js"></script>
</body>
</html>