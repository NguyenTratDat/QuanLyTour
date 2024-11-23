<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" type="text/css" href="style2.css">
<?php 

	$tourID = '';
	
	if(isset($_GET['idTour']) && ($_GET['idTour'])!=''){
		$tourID = $_GET['idTour'];
	}
	
	include("connection.php");
	if(isset($_POST['btnthemcttour']))
	{

		$bd       = ($_POST['txtngaybd'])		   ?: '';
		$kt       = ($_POST['txtngaykt']) 		   ?: '';
		$ks       = ($_POST['txtks']) 			   ?: '';
		$pt       = ($_POST['txtptien']) 		   ?: '';
		$treem    = ($_POST['txtgiatreem']) 	   ?: '';
		$nglon    = ($_POST['txtgianguoilon']) 	   ?: '';
		$cttour   = ($_POST['txtchuongtrinhtour']) ?: '';

		$selectOption = $_POST["select_matour"];

		$sql = "
			INSERT INTO `tour_details`(`ID`, `START`, `END`, `HOTEL_NAME`, `VEHICLE`, `CHILD_PRICE`, `ADULT_PRICE`, `TOUR_PROGRAM`)
			VALUES ('$tourID','$bd','$kt','$ks','$pt','$treem','$nglon','$cttour')
		";

		// print_r($sql); exit;

		$connect->query($sql);

		?>
			<script> alert("Thêm chi tiếu tour thành công !"); </script>
			<script>window.location = '?quanly=list_qltourdl'</script>
		<?php
	}
	?>
<body>

	<form action="add_tour_details.php" method="POST">
	<table class="list-data" width="1000px" align="center" border="1 solid" cellpadding="5">
		<tr align="center">
			<h1 align="center">Thêm mới chi tiết</h1>
		</tr>
		<tr>
			<td>Mã Tour</td>
			<td>

				<select name="select_matour" <?php echo (($tourID) ? 'disabled' : '' ) ?> >
				<?php

					$sql = "
						SELECT * 
						FROM tours
						WHERE 1
						ORDER BY ID DESC
					";

					$matours=$connect->query($sql);
			
					foreach ($matours as $ma) 
					{
						$lbCheck = ($ma['ID'] == $tourID) ? 'selected' : '';

						echo " <option $lbCheck value='".$ma['ID']."'>".$ma['NAME'].' - '.$ma['ID']."</option>";
					}	

				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Ngày bắt đầu</td>
			<td><input type="date" name="txtngaybd" required="required"></td>
		</tr>
		<tr>
			<td>Ngày kết thúc</td>
			<td><input type="date" name="txtngaykt" required="required"></td>
		</tr>
		<tr>
			<td>Tên khách sạn</td>
			<td><input type="text" name="txtks" required="required"></td>
		</tr>
		<tr>
			<td>Phương tiện di chuyển</td>
			<td><input type="text" name="txtptien" required="required"></td>
		</tr>
		<tr>
			<td>Giá trẻ em</td>
			<td><input type="number" min="0" name="txtgiatreem" required="required"> VND</td>
		</tr>
		<tr>
			<td>Giá người lớn</td>
			<td><input type="number" min="0" name="txtgianguoilon" required="required"> VND</td>
		</tr>
		<tr>
			<td>Chương trình Tour</td>
			<td><input type="text" name="txtchuongtrinhtour" required="required" style="width:100%;"></td>
		</tr>
			<tr align="center">
			<td colspan="2">
				<button class="btn btn-primary btn-custom" id="button1" type="submit" name="btnthemcttour" >Thêm </button>
			</td>

		</tr>
	</table>
	</form>
</body>
</html>