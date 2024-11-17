<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php
		include("connection.php");

		$sql="SELECT * FROM `customers`";
		$customers=$connect->query($sql);
	?>
	
	<link rel="stylesheet" type="text/css" href="style2.css">
	<title></title>
</head>
<body>
	
	<div class="titleOfTable">
		<h1 align="center">DANH SÁCH KHÁCH HÀNG</h1>

		<button id="btnxoa" class="btn btn-primary btn-custom btn-func pos-absolute"><a href="?quanly=send_email">Gửi Mail</a></button>
	</div>
	
	<br>
	<table class="list-data">
		<tr bgcolor="lightblue" style="font-size: 20px">
			<th class="idCustomer" width="5%" align="left">
				Mã KH
			</th>
			<th class="nametour" width="10%" align="left">
				Họ tên
			</th>
			<th class="addrtour" width="8%" align="left">
				CMND
			</th>
			<th class="phonetour" width="15%" align="left">
				Địa chỉ
			</th>
			<th class="mailtour" width="8%" align="left">
				Điện thoại
			</th>
			<th class="mailtour" width="8%" align="left">
				Ngày sinh
			</th>
			<th class="mailtour" width="15%" align="left">
				Email
			</th>
			<th class="mailtour" width="15%" align="left">
				Ghi chú
			</th>
			<!-- <th class="mailtour" width="8%" align="left">
				Chức năng
			</th> -->
		</tr>
		<?php
			include("pagination_dskhach.php");
			while ($customer = mysqli_fetch_assoc($employees)){
					
			?>
			<tr>
				<td><?php echo $customer['ID'] ?></td>
				<td><?php echo $customer['NAME']?></td>
				<td><?php echo $customer['IDCARD']?></td>
				<td><?php echo $customer['ADDRESS'] ?></td>
				<td><?php echo $customer['PHONENUMBER'] ?></td>
				<td><?php echo date('d/m/Y', strtotime($customer['BIRTHDAY'])) ?></td>
				<td><?php echo $customer['EMAIL'] ?></td>
				<td><?php echo $customer['NOTES'] ?></td>
				<!-- <td align="center">
					<button type="button" class="btn btn-danger center" onclick="confDelete()">
						<a id="demo" href="delete_customer.php?id=<?php echo $customer['ID']?>">Xóa</a>
					</button>
				</td> -->

			</tr>
			<?php 
		}
		?>
	</table>

	<div id="pagination" align="center" style="color: black">
	
	<?php
		if ($current_page > 1 && $total_page > 1){
			echo '<a style="color:black" href="admin.php?quanly=dskhachdk?page='.($current_page-1).'">Prev</a> | ';
		}

		for ($i = 1; $i <= $total_page; $i++){
			if ($i == $current_page){
				echo '<span>'.$i.'</span> | ';
			}
			else{
				echo '<a align="center" style="color:black" href="admin.php?quanly=dskhachdk?page='.$i.'">'.$i.'</a> | ';
			}
		}

		if ($current_page < $total_page && $total_page > 1){
			echo '<a align="center" style="color:black" href="admin.php?quanly=dskhachdk?page='.($current_page+1).'">Next</a> | ';
		}
		?>
	</div>

	<br>	

	<script>
		function confDelete(){
			if(confirm("Bấm vào nút OK để tiếp tục"))
			{
				document.getElementById("demo").setAttribute('target','');
			}
			else
			{	
				document.getElementById("demo").setAttribute('href','dskhachdk.php');
				alert("Xóa ko thành công!");
			}
		}
	</script>


</body>
</html>