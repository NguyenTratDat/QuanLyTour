<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style2.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	
	<div class="titleOfTable">
		<h1 align="center">DANH SÁCH TOUR</h1>

		<button id="add-tour" class="btn btn-primary btn-custom btn-func"><a href="?quanly=add_tour">Thêm mới</a> </button>
	</div>

	<table class="list-data" width="1000px" align="center" border="1 solid" cellpadding="5">
		<tr bgcolor="lightblue" style="font-size: 20px">
			<th class="listtour" width="10%" align="left">
				Mã Tour
			</th>
			<th class="listtour" width="35%" align="left">
				Tên Tour
			</th>
			<th class="listtour" width="15%" align="left">
				Phân loại
			</th>
			<th class="listtour" width="10%" align="left">
				Số người tối đa
			</th>
			<th class="listtour" width="12%" align="left">
				Hình ảnh 
			</th>
			<th class="listtour" width="35%" align="left" >
				Chức năng
			</td>
		</tr>
		<?php
		 	include("pagination_listtour.php");
			while ($row = mysqli_fetch_assoc($tours)){
		?>
			<tr>
				<td align="center"><?php echo $row['ID'] ?></td>
				<td><?php echo $row['NAME']?></td>
				<td align="center"><?php echo $row['KIND_TOUR']?></td>
				<td align="center"><?php echo $row['MAX_PEOPLE'] ?></td>
				<td align="left"><?php echo $row['IMAGE'] ?></td>
				<td align="center">

					<?php 

						if(@$row['detail_ID']){
							?>
								<button type="button" class="btn btn-info" ><a href="?quanly=show_tour_details&idTour=<?php echo $row['ID'] ?>" style="color: black">Chi tiết</a></button>
							<?php
						}
						else{
							?>
								<button type="button" class="btn btn-info" ><a href="?quanly=add_tour_detail&idTour=<?php echo $row['ID'] ?>" style="color: black">Tạo chi tiết</a></button>
							<?php
						}

					?>

					<a id="demo" href="delete_tour.php?id=<?php echo $row['ID'] ?>"><input type="button" value="Xóa" class="btn btn-danger" onclick="confDelete()"></a>
				</td>
			</tr>			
		<?php 
		}
		?>
		<!-- phân trang -->
		
		<script>
			function confDelete(){
				if(confirm("Bấm vào nút OK để tiếp tục"))
				{
					document.getElementById("demo").setAttribute('target','');
				}
				else
				{	
					document.getElementById("demo").setAttribute('href','list_qltourdl.php');
					alert("Xóa ko thành công!");
				}
			}
		</script>

	</table>

	<div id="pagination" align="center" style="color: black">
		<?php
		
		if ($current_page > 1 && $total_page > 1){
			echo '<a style="color:black" href="admin.php?quanly=list_qltourdl&page='.($current_page-1).'">Prev</a> | ';
		}

		for ($i = 1; $i <= $total_page; $i++){
			if ($i == $current_page){
				echo '<span>'.$i.'</span> | ';
			}
			else{
				echo '<a style="color:black" href="admin.php?quanly=list_qltourdl&page='.$i.'">'.$i.'</a> | ';
			}
		}

		if ($current_page < $total_page && $total_page > 1){
			echo '<a style="color:black" href="admin.php?quanly=list_qltourdl&page='.($current_page+1).'">Next</a> | ';
		}
		?>
	</div>	

	<br>		

	<script type="text/javascript" src="vendor/bootstrap.js"></script>  
	<script type="text/javascript" src="vendor/angular-1.5.min.js"></script>  
	<script type="text/javascript" src="vendor/angular-animate.min.js"></script>
	<script type="text/javascript" src="vendor/angular-aria.min.js"></script>
	<script type="text/javascript" src="vendor/angular-messages.min.js"></script>
	<script type="text/javascript" src="vendor/angular-material.min.js"></script>  
	<script type="text/javascript" src="1.js"></script>
</body>
</html>