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
				Email
			</th>
			<th class="listtour"  align="left">
				CMND
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
				Hoạt động
			</th>

			<?php if($_SESSION['position'] != 'USER'){ ?>

				<th class="listtour" align="left">
					Chức năng
				</th>

			<?php }  ?>
		</tr>

		<?php
			include("pagination_listemployees.php");
			while ($employee = mysqli_fetch_assoc($employees)){		
		?>
			<tr>
				<td><?php echo $employee['ID'] ?></td>

				<td>

					<?php if($_SESSION['position'] == 'SUPERADMIN'){ ?>
						<a class="link-info" href="?quanly=show_employee&user_id=<?php echo $employee['ID'] ?>"> <?php echo $employee['USERNAME'] ?> </a>
					<?php } else{  ?>
						<?php if($employee['POSITION'] != 'USER'){ ?>
							<a class="link-info" href="?quanly=show_employee&user_id=<?php echo $employee['ID'] ?>"> <?php echo $employee['USERNAME'] ?> </a>
						<?php } else{  ?>
							<?php echo $employee['USERNAME'] ?>
						<?php }  ?>
					<?php }  ?>

				</td>
				<td><?php echo $employee['NAME'] ?></td>
				<td><?php echo $employee['EMAIL'] ?></td>
				<td><?php echo $employee['IDCARD'] ?></td>
				<td><?php echo $employee['PHONENUMBER'] ?></td>
				<td align="center"><?php echo date('d/m/Y', strtotime($employee['BIRTHDAY'])) ?></td>
				
				<td align="center"><?php echo date('d/m/Y', strtotime($employee['PART_DAY'])) ?></td>
				<td><?php echo $employee['POSITION'] ?></td>

				<td align="center">

					<?php if($_SESSION['position'] == 'SUPERADMIN'){ ?>
						<input class="pointer" type="checkbox" value="1" onclick="confUpdate(<?php echo $employee['ID'] ?>);return false;" <?php echo ($employee['IS_ACTIVE']) ? 'checked="checked"' : '' ?> />
					<?php } else{  ?>

						<?php if($employee['POSITION'] != 'USER'){ ?>
							<input class="pointer" disabled="disabled" type="checkbox" value="1" <?php echo ($employee['IS_ACTIVE']) ? 'checked="checked"' : '' ?> />
						<?php } else{  ?>
							<input class="pointer" type="checkbox" value="1" onclick="confUpdate(<?php echo $employee['ID'] ?>);return false;" <?php echo ($employee['IS_ACTIVE']) ? 'checked="checked"' : '' ?> />
						<?php }  ?>

					<?php }  ?>
				</td>

				<?php if($_SESSION['position'] != 'USER'){ ?>
					<td align="center">
						<button type="button" class="btn btn-info" ><a href="create_account.php?id=<?php echo $employee['ID'] ?>">Reset Password</a></button>
					</td>
				<?php }  ?>
				
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
		function confUpdate(idUser){
			if(confirm("Bạn có muốn thay đổi thông tin?"))
			{
				$.ajax({
					url: "delete_employee.php?id="+idUser,
					context: document.body
				}).done(function() {
					alert("Cập nhật thành công!");
					window.location = '?quanly=list_employees';
				});

			}

		}
	</script>


</body>
</html>
