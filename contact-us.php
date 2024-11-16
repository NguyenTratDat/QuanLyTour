<!DOCTYPE html>
<html lang="en"  >
<head>
	<title> Star Tour | Chuyến đi tiên cảnh</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 	
	<link rel="stylesheet" href="vendor/bootstrap.css">
	<link rel="stylesheet" href="vendor/angular-material.min.css">
	<link rel="stylesheet" href="vendor/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/1.css">
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<link rel="stylesheet" type="text/css" href="css/component.css" />
	<script src="js/modernizr.custom.js"></script>
</head>
<?php session_start(); ?>
<body ng-app="myApp" ng-controller="MyController">
	
	<?php 
	include("connection.php"); 
	
	// xóa các session cmnd_ và idcuoi_
	if(isset($_GET['test']))		
	{
		foreach($_SESSION as $khoa=>$value)
		{
			$key= substr($khoa,0,5);
			if($key=='cmnd_' || $key=='idcuo')
			{
				unset($_SESSION[$khoa]);				
			}
		}
	}
	?>
	<div class="container text-xs-center">
		<?php include("slideshow.php");?>
	</div>
	<div class="container menu">	
		<div class="main">
			<nav id="ttw-hrmenu" class="ttw-hrmenu">
				<ul>
					<body>
						<a style=color:red href="index.php">Trang chủ</a>
							<!-- <div class="ttw-hrsub">
								<div class="ttw-hrsub-inner">
									<h4><a href="index.php" target="blank">Trang chủ</a></h4>
								</div>
							</div> --><!-- /ttw-hrsub -->
					</body>
					<li>
						<a style=color:red href="#">Tour Trong Nước</a>
						<div class="ttw-hrsub">
							<div class="ttw-hrsub-inner">
								<div>
									<h4>Miền Bắc</h4>
									<ul>
										<li><a href="#">Hà Nội</a></li>
										<li><a href="#">Sapa</a></li>
										<li><a href="#">Lạng Sơn</a></li>
									</ul>
									</div>
									<div>
									<h4>Miền Trung</h4>
									<ul>
										<li><a href="#">Đà Nắng</a></li>
										<li><a href="#">Huế</a></li>
										<li><a href="#">Quảng Nam</a></li>
										<li><a href="#">Quy Nhơn</a></li>
										<li><a href="#">Phú Yên</a></li>
										<li><a href="#">Nha Trang</a></li>
										<li><a href="#">Phan Thiết</a></li>
									</ul>
								</div>
							
								<div>
									<h4>Miền Nam</h4>
									<ul>
										<li><a href="#">Vũng Tàu</a></li>
										<li><a href="#">Long An</a></li>
										<li><a href="#">Cần Thơ</a></li>
										<li><a href="#">Hồ Chí Minh</a></li>
									</ul>
								</div>
							</div><!-- /ttw-hrsub-inner -->
						</div><!-- /ttw-hrsub -->
					</li>
					<li>
						<a style=color:red href="#">Tour Ngoài Nước</a>
						<div class="ttw-hrsub">
							<div class="ttw-hrsub-inner"> 
								<div>
									<h4>Châu Âu</h4>
									<ul>
										<li><a href="#">Thụy Sỹ</a></li>
										<li><a href="#">Phần Lan</a></li>
										<li><a href="#">Pháp</a></li>
									</ul>
								</div>
								<div>
									<h4>Châu Á</h4>
									<ul>
										<li><a href="#">Thượng Hải</a></li>
										<li><a href="#">Hồng Kông</a></li>
										<li><a href="#">Nhật Bản</a></li>
										<li><a href="#">Singapore</a></li>
										<li><a href="#">Úc</a></li>
									</ul>
								</div>
							</div><!-- /ttw-hrsub-inner -->
						</div><!-- /ttw-hrsub -->
					</li>
					<li>
						<a style=color:red href="#">Blog</a>
						<div class="ttw-hrsub">
							<div class="ttw-hrsub-inner"> 
								<div>
									<h4>Tin tức &amp; Điểm đến hot</h4>
									<ul>
										<li><a href="#">Điểm đến cho ngày hè nóng nực</a></li>
										<li><a href="#">Leo núi ban đêm. Tại sao không?</a></li>
										<li><a href="#">Check in nhanh các địa điểm này!</a></li>
									</ul>
									<h4>Review</h4>
									<ul>
										<li><a href="#">Các khách sạn có view đẹp nhất Vũng Tàu!</a></li>
										<li><a href="#">Ăn gì mặc gì khi đi Đà Lạt</a></li>
									</ul>
								</div><!-- /ttw-hrsub-inner -->
							</div><!-- /ttw-hrsub -->
						</li>
						<li>
							<a style=color:red href="contact-us.php">Liên Hệ</a>
							
						</li>
						<li>
							<a style=color:red href="#">Quản lý</a>
							<div class="ttw-hrsub">
								<div class="ttw-hrsub-inner">
									<h4><a href="quantri/index.php" target="blank">Đăng nhập</a></h4>
								</div>
							</div><!-- /ttw-hrsub -->
						</li>
					</ul>
				</nav>
			</div>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="js/ttwHorizontalMenu.min.js"></script>
		<script>
			$(function() {
				ttwHorizontalMenu.init();
			});
		</script>				
		

	</div>
	<br>
	
		<?php 

		if (isset($_REQUEST['ok'])) 
		{
            // Gán hàm addslashes để chống sql injection
			$search = addslashes($_GET['search']);

            // Nếu $search rỗng thì báo lỗi, tức là người dùng chưa nhập liệu mà đã nhấn submit.
			if (empty($search)) {
				echo "Yeu cau nhap du lieu vao o trong";
			} 
			else
			{
                // Dùng câu lênh like trong sql và sứ dụng toán tử % của php để tìm kiếm dữ liệu chính xác hơn.
				$query = "SELECT * from tours where NAME like '%$search%'";

                // Kết nối sql
				mysqli_connect("localhost", "root", "", "ql_tourdulich");

                // Thực thi câu truy vấn
				$sql = mysqli_query($query);

                // Đếm số đong trả về trong sql.
				$num = mysqli_num_rows($sql);

                // Nếu có kết quả thì hiển thị, ngược lại thì thông báo không tìm thấy kết quả
				if ($num > 0 && $search != "") 
				{
                    // Dùng $num để đếm số dòng trả về.
					echo "$num ket qua tra ve voi tu khoa <b>$search</b>";

                    // Vòng lặp while & mysql_fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
					echo '<table border="1" cellspacing="0" cellpadding="10">';
					while ($row = mysqli_fetch_assoc($sql)) {
						echo '<tr>';
						echo "<td>{$row['ID']}</td>";
						echo "<td>{$row['NAME']}</td>";
						echo "<td>{$row['KIND_TOUR']}</td>";
						echo '</tr>';
					}
					echo '</table>';
				} 
				else {
					echo "Khong tim thay ket qua!";
				}
			}
		}
		?>



	</div>
	<br>

	<div class="container cot">
		<?php 
		include("pagination.php");
		?>

			<div id="contact-page" class="container">
		<div class="bg">
			<div class="row">
				<div class="col-sm-12">
					<h2 style="text-align: center;color:sandybrown"><strong>TRƯỜNG ĐẠI HỌC CÔNG NGHỆ TP.HCM (HUTECH)</strong></h2>
					<div class="col-sm-12">
						<div class="contact-info" style="text-align:center">
							<address>
								<p>475A Điện Biên Phủ, P.25, Q.Bình Thạnh, TP.HCM</p>
								<p>Điện thoại: (028) 5445 7777 </p>
								<p>Email: hutech@hutech.edu.vn</p>
							</address>

						</div>
					</div>
				</div>
			</div>


	
		<div class="row" ng-show="display">
			<?php
			

			while ($rows = mysqli_fetch_assoc($resultGlobal)){
				?>
				<div class="mottin">

					<a href="chitiettour.php?id=<?php echo $rows['ID']?>" class="hrefHCM">
						<div class="vien">
							<img src="images/<?php echo $rows['IMAGE']?>" alt="" class="float-xs-left" width="250px" height="170px">
							<b><?php echo $rows['NAME']?></b><br>							
						</div>
					</a>
				</div>
				<?php
			}
			?>
		</div>
		<div id="pagination1" align="center" style="color: black" ng-show="display">
			<?php

            // PHẦN HIỂN THỊ PHÂN TRANG
            // BƯỚC 7: HIỂN THỊ PHÂN TRANG

            // nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
			if ($current_page > 1 && $total_page > 1){
				echo '<a style="color:black" href="index.php?page='.($current_page-1).'">Prev</a> | ';
			}

            // Lặp khoảng giữa
			for ($i = 1; $i <= $total_page; $i++){
                // Nếu là trang hiện tại thì hiển thị thẻ span
                // ngược lại hiển thị thẻ a
				if ($i == $current_page){
					echo '<span>'.$i.'</span> | ';
				}
				else{
					echo '<a style="color:black" href="index.php?page='.$i.'">'.$i.'</a> | ';
				}
			}

            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
			if ($current_page < $total_page && $total_page > 1){
				echo '<a style="color:black" href="index.php?page='.($current_page+1).'">Next</a> | ';

			}

			?>

		</div>
	</div>	
	





	<br>
	<br>
	<br>
	<br>
	<p></p>

	<footer>
		<div class="splitter"></div>
		<ul>
			<!-- three footer columns are here -->
		</ul>

		<div class="bar">
			<div class="bar-wrap">



			</div>
		</div>

		<ul>
			<li>

				<div class="text">
					<h4>Thanh toán tiện lợi</h4>
					<div>Dễ dàng chọn phương thức thanh toán.
					Dễ dàng và linh hoạt với momo! Chỉ cần chọn phương thức thanh toán phù hợp với bạn!</a></div>
				</div>
			</li>
			<li>

				<div class="text">
					<h4>Dịch vụ</h4>
					<div>Đặt chỗ dễ dàng và nhanh chóng mọi lúc mọi nơi
					Được xác nhận đặt chỗ tức thì với Du lịch cuộc sống. Quên cảnh xếp hàng mệt mỏi để mua vé đi!</a></div>
				</div>
			</li>
			<li>

				<div class="text">
					<h4>Chăm sóc</h4>
					<div>Luôn thảnh thơi.
						Chúng tôi có bộ phận Hỗ trợ Khách hàng 24/7 luôn sẵn sàng giúp đỡ bạn. Không âu lo, chẳng muộn phiền!
					</a></div>
				</div>
			</li>
		</ul>
			<div class="bar">
			<div class="bar-wrap">
				<div class="clear"></div>
				<div class="copyright">&copy; Copyright by NHÓM 5</div>
				<div class="copyright">&copy;  Số điện thoại: 0326242748</div>
			</div>
		</div>
	</footer>

	<script type="text/javascript" src="vendor/bootstrap.js"></script>  
	<script type="text/javascript" src="vendor/angular-1.5.min.js"></script>  
	<script type="text/javascript" src="vendor/angular-animate.min.js"></script>
	<script type="text/javascript" src="vendor/angular-aria.min.js"></script>
	<script type="text/javascript" src="vendor/angular-messages.min.js"></script>
	<script type="text/javascript" src="vendor/angular-material.min.js"></script>  
	<script type="text/javascript" src="js/1.js"></script>

</body>

</html>