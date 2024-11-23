<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style2.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script>

		function confUpdate(idTour, status){
			if(confirm("Bạn có muốn thay đổi thông tin?"))
			{

				if(status == 2){
					status = 1;
				}
				else{
					status = 2;
				}

				$.ajax({
					url: "updatetStatus_tour.php?id="+idTour+"&status="+status,
					context: document.body
				}).done(function(data) {

					if(data == 202){
						alert("Vui lòng cập nhật Chi tiết của Tour!");
					}
					else{
						alert("Cập nhật thành công!");
						window.location = '?quanly=list_qltourdl';
					}
				});

			}

		}

	</script>

</head>
<body>
	 
	<?php
		$flagCustomer = (in_array($_SESSION['position'], ['CUSTOMER'])) ? true: false; 
	?>
	
	<div class="titleOfTable">
		<h1 align="center">LỊCH SỬ TOUR</h1>
	</div>

	<table class="list-data" align="center" border="1 solid" cellpadding="5">
		<colgroup>  
			<col width="10%" />
			<col width="10%" />
			<col  />
			<col width="12%" />
			<col width="12%" />
			<col width="12%" />
			<col width="15%" />
		</colgroup>
		<tr bgcolor="lightblue" style="font-size: 20px">
			<th class="listtour" align="left">
				Mã Thanh toán
			</th>
			<th class="listtour" align="left">
				Mã Tour
			</th>
			<th class="listtour" align="left">
				Tên Tour
			</th>
			<th class="listtour" align="left">
				Phân loại
			</th>
			<th class="listtour" align="left">
				Số người tối đa
			</th>
			<th class="listtour" align="left">
				Trạng thái
			</th>
			<th class="listtour" align="left" >
				Chức năng
			</td>
		</tr>
		<?php
		 	include("pagination_history_tour.php");
			while ($row = mysqli_fetch_assoc($tours)){ // print_r($row); exit;
		?>
			<tr>
				<td align="center"><?php echo $row['CODE_PAY'] ?></td>
				<td align="center"><?php echo $row['ID'] ?></td>
				<td><?php echo $row['NAME']?></td>
				<td align="center"><?php echo $row['KIND_TOUR']?></td>
				<td align="center"><?php echo $row['MAX_PEOPLE'] ?></td>
				<td align="center">
					<?php 

						$status = "Chưa sẵn sàng"; $today = date('Y-m-d'); $date_NULL = '0000-00-00';
						$flagStatus = 0;

						// print_r(array($row['START'], $row['END'])); exit;

						if(@$row['END'] != $date_NULL && @$row['START'] != $date_NULL){
							
							if ($row['START'] >= $today && $row['END'] >= $today ){
								$status       = 'Đang diễn ra';
								$flagStatus   = 1;
							}
							else if($row['END'] <= $today ){
								$status       = 'Hoàn thành';
								$flagStatus   = 3;
							}
							
						}
						
						echo $status;	
					?>
				</td>
				<td align="center">
					<button type="button" class="btn btn-info" ><a href="?quanly=show_tour_details&idTour=<?php echo $row['ID'] ?>" style="color: black">Chi tiết</a></button>
				</td>
			</tr>			
		<?php } ?>
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