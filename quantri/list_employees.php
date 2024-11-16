<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style2.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php 
		include("permission.php");
	?>
	<title></title>
</head>
<body>

	<div class="titleOfTable">
		<h1 align="center">DANH SÁCH NHÂN VIÊN</h1>

		<button id="add-tour" class="btn btn-primary btn-custom btn-func"><a href="?quanly=add_employees">Thêm mới</a> </button>
	</div>

	<table class="list-data"  width="1150px" align="center" border="1 solid" cellpadding="5">
		<tr bgcolor="lightblue" style="font-size: 20px">
			<th class="listtour"  align="left">
				Mã NV
			</th>
			<th class="listtour"  align="left">
				Tên đăng nhập
			</th>

			<th class="listtour"  align="left">
				Họ tên
			</th>
			<th class="listtour"  align="left">
				CMND
			</th>
			<th class="listtour"  align="left">
				Địa chỉ
			</th>
			<th class="listtour"  align="left">
				Điện thoại 
			</th>
			<th class="listtour"  align="left">
				Ngày sinh
			</th>

			<th class="listtour"  align="left">
				Ngày làm việc
			</th>
			<th class="listtour"  align="left">
				Chức vụ
			</th>

			<th class="listtour"  align="left">
				Chức năng
			</th>
		</tr>
		<?php
			include("pagination_listemployees.php");
			while ($employee = mysqli_fetch_assoc($employees)){		
		?>
			<tr>
				<td><?php echo $employee['ID'] ?></td>
				<td><?php echo $employee['USERNAME'] ?></td>
				<td><?php echo $employee['NAME'] ?></td>

				<td><?php echo $employee['IDCARD'] ?></td>
				<td><?php echo $employee['ADDRESS'] ?></td>
				<td><?php echo $employee['PHONENUMBER'] ?></td>
				<td align="center"><?php echo date('d/m/Y', strtotime($employee['BIRTHDAY'])) ?></td>
				
				<td align="center"><?php echo date('d/m/Y', strtotime($employee['PART_DAY'])) ?></td>
				<td><?php echo $employee['POSITION'] ?></td>
				
				<td>
					<button type="button" class="btn btn-info" ><a href="create_account.php?id=<?php echo $employee['ID'] ?>">Reset Password</a></button>
					<button value="Xóa" class="btn btn-danger" onclick="confDelete()">
						<a id="demo" href="delete_employee.php?id=<?php echo $employee['ID'] ?>">Xóa
						</a>
					</button>
				</td>
			</tr>
			<?php 
		}
		?>
	</table>

	<div id="pagination marb-10" align="center" style="color: black">
		<?php

			if ($current_page > 1 && $total_page > 1){
				echo '<a style="color:black" href="admin.php?quanly=list_employees?page='.($current_page-1).'">Prev</a> | ';
			}

			for ($i = 1; $i <= $total_page; $i++){
				if ($i == $current_page){
					echo '<span>'.$i.'</span> | ';
				}
				else{
					echo '<a style="color:black" href="admin.php?quanly=list_employees?page='.$i.'">'.$i.'</a> | ';
				}
			}

			if ($current_page < $total_page && $total_page > 1){
				echo '<a style="color:black" href="admin.php?quanly=list_employees?page='.($current_page+1).'">Next</a> | ';
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
				document.getElementById("demo").setAttribute('href','admin.php?quanly=list_employees');
				alert("Xóa ko thành công!");
			}

		}
	</script>


</body>
</html>
