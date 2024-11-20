<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" type="text/css" href="style2.css">
<?php 

	$flagCustomer = (in_array($_SESSION['position'], ['CUSTOMER'])) ? true: false;

	$id= $_GET['idTour']; 
	$pathT = getcwd(); $path = str_replace("quantri","images",$pathT);
	include("connection.php");

	$sql = "SELECT * FROM `thongtinchitiettour`where ID='$id'";
	$tours= $connect->query($sql);	
		
	try{
		if(isset($_POST['btnsua'])){

			$ten       = ($_POST["txttentour1"])	    ?: '';
			$songuoi   = ($_POST['txtsonguoi1'])	    ?: '';
			$fileanh   = ($_FILES['txtfileanh1'])	    ?: '';
			$bd        = ($_POST['txtngaybd']) 			?: '';
			$kt        = ($_POST['txtngaykt']) 			?: '';
			$ks        = ($_POST['txtks'])				?: '';
			$pt        = ($_POST['txtptien']) 			?: '';
			$treem     = ($_POST['txtgiatreem']) 		?: '';
			$nglon     = ($_POST['txtgianguoilon']) 	?: '';
			$cttour    = ($_POST['txtchuongtrinhtour']) ?: '';
			$loai      = ($_POST['loaitour'])		    ?: '';

			if(!$ten ||$ten == ''){
				?>
					<script> alert("Vui lòng nhập đủ thông tin!"); </script>
				<?php
			}
			else{

				$uploadImage = '';

				if($fileanh != ''){

					$target_dir    = $path."/";
					$fileName      = basename($_FILES["txtfileanh1"]["name"]);
					$target_file   = $target_dir . $fileName;
					$uploadOk      = 1;
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

					if (move_uploaded_file($_FILES["txtfileanh1"]["tmp_name"], $target_file)) {
						$fileanh = $fileName;
						$uploadImage = ",`IMAGE`='$fileanh' ";
					} else {
						$fileanh = '';
					}
				}

				$sql="
					UPDATE tours
					SET `NAME`='$ten',`KIND_TOUR`='$loai',`MAX_PEOPLE`='$songuoi'$uploadImage
					WHERE ID='$id'
				";

				$connect->exec($sql);

				$sql1="
					UPDATE `tour_details` 
					SET `START`='$bd',`END`='$kt',`HOTEL_NAME`='$ks',`VEHICLE`='$pt',`CHILD_PRICE`='$treem',`ADULT_PRICE`='$nglon',`TOUR_PROGRAM`='$cttour' 
					WHERE ID='$id'
				";
				$connect->exec($sql1);
				echo 'CẬP NHẬT THÀNH CÔNG !!';
			}
		}
	}
	catch(PDOException $e)
	{
		echo $sql."<br>".$e->getMessage();
		header("location:list_qltourdl.php");
	}
?>

<body>

	<?php if($flagCustomer){ ?>
		<style>  
			input, select{
				pointer-events: none;
			}
		</style>
	<?php } ?>

	<form method="post">

		<table class="list-data" align="center" border="1px black solid">
			<tr align="center">
				<td colspan="2">
					<h1 align="center">Thông tin chi tiết</h1>
				</td>
			</tr>
			<tr>
				<td>Tên tour <span style="color:red">*</span></td>
				<?php 

					foreach ($tours as $tour) 
					{
				?>
				<td><input type="text" name="txttentour1" size='42' value="<?php echo $tour['NAME']?>"  style="width:100%;"></td>
			</tr>
			<tr>
				<td>Phân loại</td>
				<td>
					<select name="loaitour">
						<option value='Trong Nước'>Trong Nước</option>
						<option value='Tiết kiệm'>Tiết kiệm</option>
						<option value='Nước Ngoài'>Nước Ngoài</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Số người tối đa</td>
				<td><input type="number" name="txtsonguoi1" size='42' value="<?php echo $tour['MAX_PEOPLE']?>" min="1" max="20"></td>
			</tr>

			<?php if(!$flagCustomer){ ?>
				<tr>
					<td>Ảnh bìa</td>
					<td><input type="file" name="txtfileanh1" size='42'  value="<?php echo $tour['IMAGE']?>"></td>
				</tr>	
				<tr>
					<td>Ảnh chi tiết</td>
					<td><input type="file" name="txtfilechitiet1[]" multiple/></td>
				</tr>	
			<?php } ?>
			<tr>
				<td>Ngày bắt đầu</td>
				<td><input type="text" name="txtngaybd" size='42' value="<?php echo $tour['START']?>"></td>
			</tr>
			<tr>
				<td>Ngày kết thúc</td>
				<td><input type="text" name="txtngaykt" size='42' value="<?php echo $tour['END']?>"></td>
			</tr>
			<tr>
				<td>Tên khách sạn</td>
				<td><input type="text" name="txtks" size='42' value="<?php echo $tour['HOTEL_NAME']?>"></td>
			</tr>
			<tr>
				<td>Phương tiện di chuyển</td>
				<td><input type="text" name="txtptien" size='42' value="<?php echo $tour['VEHICLE']?>"></td>
			</tr>
			<tr>
				<td>Giá trẻ em</td>
				<td><input type="text" name="txtgiatreem" size='42' value="<?php echo $tour['CHILD_PRICE']?>"></td>
			</tr>
			<tr>
				<td>Giá người lớn</td>
				<td><input type="text" name="txtgianguoilon" size='42' value="<?php echo $tour['ADULT_PRICE']?>"></td>
			</tr>
			<tr>
				<td>Ghi chú</td>
				<td><input type="text" name="txtchuongtrinhtour" size='42' value="<?php echo $tour['TOUR_PROGRAM']?>" style="width:100%;"></td>
			</tr>
			<tr>
				<td>Chi tiết chương trình</td>
				<td><input type="text" name="txtpdf" size='42' value="Chưa có file PDF" style="width:100%;"></td>
			</tr>
			<tr>
				<td>Ảnh bìa</td>
				<td> <img src="<?php echo "../images/".$tour['IMAGE'] ?>" width=300px height=150px></td>
			</tr>

			<?php if(!in_array($_SESSION['position'], ['CUSTOMER'])){ ?>

				<tr align="center">
					<td colspan="2">
						<button class="btn btn-primary btn-custom" name='btnsua'  id="button1">
							Chỉnh sửa
						</button>
					</td>
				</tr>
			
			<?php } ?>

			<?php } ?>
		</table>
		
	</form>
</body>
</html>