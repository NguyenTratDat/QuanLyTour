<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" type="text/css" href="style2.css">

	<?php 
		include("connection.php");
		
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
		if(isset($_POST['btnok'])){

			$flagOk = true;

			$ten      = ($_POST["txttentour"])  ?: '';
			$songuoi  = ($_POST['txtsonguoi'])  ?: '';
			$fileanh  = ($_FILES['txtfileanh']) ?: '';
			$loai     = ($_POST['loaitour'])    ?: '';			

			if(!$ten ||$ten == ''){
				?>
					<script> alert("Vui lòng nhập đủ thông tin!"); </script>
				<?php
			}
			else{

				if($fileanh != ''){

					$pathT = getcwd(); $path = str_replace("quantri","images",$pathT);

					$target_dir    = $path."/";
					$fileName      = basename($_FILES["txtfileanh"]["name"]);
					$target_file   = $target_dir . $fileName;
					$uploadOk      = 1;
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

					if (move_uploaded_file($_FILES["txtfileanh"]["tmp_name"], $target_file)) {
						$fileanh = $fileName;
					} else {
						$fileanh = '';
					}
				}
				
				$insertTour_script = "
					INSERT INTO `tours`(`NAME`, `KIND_TOUR`, `MAX_PEOPLE`, `IMAGE`) 
					VALUES ('$ten','$loai','$songuoi','$fileanh')
				";

				$connect->query($insertTour_script);

				$tourID = $connect->lastInsertId();

				$insertDetail_script = "
					INSERT INTO `tour_details`(`ID`)
					VALUES ('$tourID')
				";

				$connect->query($insertDetail_script);

				?>	
					<script> alert("Thêm mới thành công !"); </script>
					<script>window.location = '?quanly=list_qltourdl'</script>
				<?php
			}
			
		}
	?>
<body>

	<table class="list-data" width="1000px" align="center" border="1 solid" cellpadding="5">
		<form action='add_tour.php' method='post'  enctype="multipart/form-data">
			<tr align="center">
				<h1 align="center">Thêm mới</h1>
			</tr>
			<tr>
				<td>Tên tour <span style="color:red">*</span></td>
				<td><input type="text" name="txttentour" required="required" style="width:100%;"></td>
			</tr>
			<tr>
				<td>Phân loại</td>
				<td>
					<select name="loaitour">
						<option value='Trong Nước'>Trong Nước</option>
						<option value='Tiết kiệm'>Tiết Kiệm</option>
						<option value='Nước Ngoài'>Nước Ngoài</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Số người tối đa</td>
				<td><input type="number" name="txtsonguoi" value="20" min="1" max="20" ></td>
			</tr>
			<tr>
				<td>Tên file ảnh</td>
				<td><input type="file" name="txtfileanh" required="required"></td>
			</tr>	
			<tr align="center">

				<td colspan="2">
					<button class="btn btn-primary btn-custom" type="submit" name="btnok">
						Thêm
					</button>
				</td>

			</tr>

		</form>

	</table>
</body>
</html>