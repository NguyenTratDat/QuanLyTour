<!DOCTYPE html>
<html lang="en"  >
<head>
	<title> Quản lý Tour Du Lịch | Nhóm 3</title>
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

		$page = ""; $showDetail = false; 

		if(isset($_GET['page'])&&($_GET['page'])!=''){
			$page= $_GET['page'];
		}
		else{
			unset($_SESSION['create_tour_log']);
		}

	?>

	<div class="container text-xs-center">
		<?php include("slideshow.php");?>
	</div>

	<div class="container menu">	
		<div class="main">
			<nav id="ttw-hrmenu" class="ttw-hrmenu">
				<ul>
					<li>
						<a id="index-link" href="?page=trangchu">Trang Chủ</a>
													
					</li>
					<li>
						<a href="#">Tour Trong Nước</a>
						<div class="ttw-hrsub">
							<div class="ttw-hrsub-inner">
								<div>
									<h4>Miền Bắc </h4>
									<ul>
										<li><a href="#">Hà Nội</a></li>
										<li><a href="#">Sapa</a></li>
										<li><a href="#">Lạng Sơn</a></li>
									</ul>
								</div>
								<div>
									<h4> Miền Trung </h4>
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
									<h4>Miền Nam </h4>
									<ul>
										<li><a href="#">Vũng Tàu</a></li>
										<li><a href="#">Long An</a></li>
										<li><a href="#">Cần Thơ</a></li>
										<li><a href="#">Hồ Chí Minh</a></li>
									</ul>
								</div>
								
							</div>
						</div>
					</li>
					<li>
						<a href="#">Tour Ngoài Nước</a>
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
						<a href="#">Blog</a>
						<div class="ttw-hrsub">
							<div class="ttw-hrsub-inner"> 
								<div>
									<h4>Tin tức &amp; Điểm đến hot</h4>
									<ul>
										<li><a href="#">Điểm đến cho ngày hè nóng nực</a></li>
										<li><a href="#">Leo núi ban đêm. Tại sao không?</a></li>
										<li><a href="#">Check in nhanh các địa điểm này!</a></li>
									</ul>
								</div>
								
								<div>
									<h4>Review</h4>
									<ul>
										<li><a href="#">Các khách sạn có view đẹp nhất Vũng Tàu!</a></li>
										<li><a href="#">Ăn gì mặc gì khi đi Đà Lạt</a></li>
									</ul>
								</div>
							</div>
					</li>
					<li>
						<a href="#">Quản lý</a>
						<div class="ttw-hrsub">
							<div class="ttw-hrsub-inner">
								<h4><a href="quantri/index.php" target="blank">Đăng nhập</a></h4>
							</div>
						</div>
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

		$( "#index-link" ).on( "click", function() {
			window.location = '?page=trangchu'
		} );

	</script>				
		
	<br>
	<?php
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED); 
		$searchS = (@$_POST['seacrh']) ?: '';
	?>

	<?php if($page == '' || $page == 'trangchu' ) { ?>
		<div class="container" align="right" style="position: absolute;" >
			<div class="searchform cf">
				<form action="search.php?search=<?php echo $searchS ?>" method="get">
					<input type="text" placeholder="Nhập tên thành phố bạn muốn tới?" name="search">
					<button type="submit" name="ok">Tìm kiếm</button>
				</form>
			</div>
		</div>
	<?php } ?>

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

	<?php

		if($page == 'chitiettour'){
			$showDetail = true;
			include('chitiettour.php');
		}
		else if($page == 'dangkitour'){
			$showDetail = true;
			include('dangkitour.php');	
		}
		else if($page == 'success'){  
			$showDetail = true;
			include('success.php');	
		}

	?>

	<?php if(!$showDetail){ ?>

		<div class="container cot">
			<?php 
				include("pagination.php");
			?>

			<button type="submit" class="btn btn-info trongnuoc" ng-click="show('trong_nuoc');" >Trong nước</button>
			<button type="submit" class="btn btn-info ngoainuoc" ng-click="show('ngoai_nuoc');" >Ngoài nước</button>

			<div class="row" ng-hide="display">
				<?php while ($row = mysqli_fetch_assoc($resultCountry)){ ?>

					<div class="mottin">

						<a href="?page=chitiettour&idTour=<?php echo $row['ID']?>" class="hrefHCM">
							<div class="vien">
								<img src="images/<?php echo $row['IMAGE']?>" alt="" class="" height="170px">
								<b><?php echo $row['NAME']?></b>							
							</div>
						</a>

					</div>

				<?php } ?>
			</div>

			<div id="pagination" align="center" style="color: black" ng-hide="display">
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

			<div class="row" ng-show="display">
				<?php
				

				while ($rows = mysqli_fetch_assoc($resultGlobal)){
					?>
					<div class="mottin">

						<a href="?page=chitiettour&idTour=<?php echo $rows['ID']?>" class="hrefHCM">
							<div class="vien">
								<img src="images/<?php echo $rows['IMAGE']?>" alt="" height="170px">
								<b><?php echo $rows['NAME']?></b>						
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

	<?php } ?>

	<br>

	<footer>

			<ul>
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


	<script type="text/javascript" src="vendor/bootstrap.js"></script>  
	<script type="text/javascript" src="vendor/angular-1.5.min.js"></script>  
	<script type="text/javascript" src="vendor/angular-animate.min.js"></script>
	<script type="text/javascript" src="vendor/angular-aria.min.js"></script>
	<script type="text/javascript" src="vendor/angular-messages.min.js"></script>
	<script type="text/javascript" src="vendor/angular-material.min.js"></script>  
	<script type="text/javascript" src="js/1.js"></script>

</body>

</html>