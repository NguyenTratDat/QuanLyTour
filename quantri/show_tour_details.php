<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" type="text/css" href="style2.css">

<script> 

let slideIndex = [1,1,1];
let slideId = ["mySlides1","mySlides2"];
// showSlides(1, 0);

setTimeout(() => {
	plusSlides(0, 1);

}, 0);

function plusSlides(n, no) {
  showSlides(slideIndex[no] += n, no);
}

function showSlides(n, no) {
  let i;
  let x = document.getElementsByClassName(slideId[no]);

  if (n > x.length) {slideIndex[no] = 1}    
  if (n < 1) {slideIndex[no] = x.length}

  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";  
  }

  x[slideIndex[no]-1].style.display = "block";  
}

</script>

<?php 

	$flagCustomer = (in_array($_SESSION['position'], ['CUSTOMER'])) ? true: false;

	$id        = $_GET['idTour'];
	$pathT     = getcwd();
	$pathImg   = str_replace("quantri","images",$pathT);
	$pathFile  = str_replace("quantri","details",$pathT);

	include("connection.php");

	$sql = "
		SELECT tours.*, tour_details.*
		FROM `tours`
		LEFT JOIN tour_details ON tour_details.ID = tours.ID
		WHERE `tours`.`ID` = '$id' 
	";

	$tours= $connect->query($sql);	
		
	try{
		if(isset($_POST['btnsua'])){

			$ten           = ($_POST["txttentour1"])	    ?: '';
			$songuoi       = ($_POST['txtsonguoi1'])	    ?: '';
			
			$filedetail    = ($_FILES['txtfilechitiet1'])   ?: '';

			$bd            = ($_POST['txtngaybd']) 			?: '';
			$kt            = ($_POST['txtngaykt']) 			?: '';
			$hn            = ($_POST['txtngayhn']) 			?: '';
			$ks            = ($_POST['txtks'])				?: '';
			$pt            = ($_POST['txtptien']) 			?: '';
			$treem         = ($_POST['txtgiatreem']) 		?: '';
			$nglon         = ($_POST['txtgianguoilon']) 	?: '';
			$cttour        = ($_POST['txtchuongtrinhtour']) ?: '';
			$loai          = ($_POST['loaitour'])		    ?: '';

			if(!$ten || $ten == ''){
				?>
					<script> alert("Vui lòng nhập đủ thông tin!"); </script>
				<?php
			}
			else{

				$uploadImage = ''; $uploadImage_Detail = ''; $uploadPDF = '';

				if( isset($_FILES['txtfileanh1']) ){

					$fileanh       = $_FILES['txtfileanh1'];
					$target_dir    = $pathImg."/";

					if (!is_dir($target_dir)) {
						mkdir($target_dir, 0777, true);
					}

					$fileName      = basename($fileanh["name"]);
					$target_file   = $target_dir . $fileName;

					if (move_uploaded_file($fileanh["tmp_name"], $target_file)) {
						$fileanh = $fileName;
						$uploadImage = ",`IMAGE`='$fileanh' ";
					} else {
						$fileanh = '';
					}
				}

				if( isset($_FILES['txtfilechitiet1']) ){

					$fileanh       = $_FILES['txtfilechitiet1'];
					$target_dir    = $pathFile."/".$id."/";

					if (!is_dir($target_dir)) {
						mkdir($target_dir, 0777, true);
					}

					$arr_Detail = array();  

					foreach($fileanh["tmp_name"] as $key => $tmp_name) {

						$fileName       = basename($fileanh["name"][$key]);
						$fileTmp        = $tmp_name;
						$target_file    = $target_dir . $fileName;

						if (move_uploaded_file($fileTmp, $target_file)) {
							$arr_Detail[] = $fileName;
						} 
					}

					if(count($arr_Detail) > 0){ 
						$strDetail = implode(',', $arr_Detail);
						$uploadImage_Detail = ",`IMAGE_DETAIL`='$strDetail' ";
					} 
					else{ 
						$uploadImage_Detail = '';
					}

				}

				if( isset($_FILES['txtpdf']) ){
					$filepdf       = $_FILES['txtpdf'];
					$target_dir    = $pathFile."/".$id."/";

					if (!is_dir($target_dir)) {
						mkdir($target_dir, 0777, true);
					}

					$fileName      = basename($filepdf["name"]);
					$target_file   = $target_dir . $fileName;

					if (move_uploaded_file($filepdf["tmp_name"], $target_file)) {
						$filepdf    = $fileName;
						$uploadPDF  = ",`PDF`='$filepdf' ";
					} else {
						$filepdf = '';
					}

				}

				$sql = "
					UPDATE tours
					SET `NAME`='$ten',`KIND_TOUR`='$loai',`MAX_PEOPLE`='$songuoi' $uploadImage
					WHERE ID='$id'
				";

				$connect->exec($sql);

				$sql1 = "
					UPDATE `tour_details` 
					SET `START`='$bd',`END`='$kt',`EXPIRED`='$hn',`HOTEL_NAME`='$ks',`VEHICLE`='$pt',`CHILD_PRICE`='$treem',`ADULT_PRICE`='$nglon',`TOUR_PROGRAM`='$cttour' $uploadPDF $uploadImage_Detail
					WHERE ID='$id'
				";
				$resUpdate = $connect->exec($sql1);

				if($resUpdate){
					?>  
						<script> alert('Cập nhật thành công!'); location.reload();</script>
					<?php
				}
			}
		}
	}
	catch(PDOException $e)
	{
		echo $sql."<br>".$e->getMessage();
		header("location:?quanly=list_qltourdl");
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
				<td><input required="required" type="text" name="txttentour1" size='42' value="<?php echo @$tour['NAME']?>"  style="width:100%;"></td>
			</tr>
			<tr>
				<td>Phân loại</td>
				<td>
					<select name="loaitour">
						<option value='Trong Nước' <?php ( ($tour['KIND_TOUR'] == 'Trong Nước') ? 'checked="checked"' : '' ); ?> >Trong Nước</option>
						<option value='Tiết kiệm'  <?php ( ($tour['KIND_TOUR'] == 'Tiết kiệm')  ? 'checked="checked"' : '' ); ?> >Tiết kiệm</option>
						<option value='Nước Ngoài' <?php ( ($tour['KIND_TOUR'] == 'Nước Ngoài') ? 'checked="checked"' : '' ); ?> >Nước Ngoài</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Số người tối đa <span style="color:red">*</span></td>
				<td><input type="number" name="txtsonguoi1" size='42' value="<?php echo @$tour['MAX_PEOPLE']?>" min="1" max="20"></td>
			</tr>
			<tr>
				<td>Ngày bắt đầu <span style="color:red">*</span></td>
				<td><input required="required" type="date" name="txtngaybd" size='42' value="<?php echo @$tour['START']?>"></td>
			</tr>
			<tr>
				<td>Ngày kết thúc <span style="color:red">*</span></td>
				<td><input required="required" type="date" name="txtngaykt" size='42' value="<?php echo @$tour['END']?>"></td>
			</tr>
			<tr>
				<td>Ngày hết hạn đăng ký <span style="color:red">*</span></td>
				<td><input required="required" type="date" name="txtngayhn" size='42' value="<?php echo @$tour['EXPIRED']?>"></td>
			</tr>
			<tr>
				<td>Tên khách sạn</td>
				<td><input type="text" name="txtks" size='42' value="<?php echo @$tour['HOTEL_NAME']?>"></td>
			</tr>
			<tr>
				<td>Phương tiện di chuyển</td>
				<td><input type="text" name="txtptien" size='42' value="<?php echo @$tour['VEHICLE']?>"></td>
			</tr>
			<tr>
				<td>Giá trẻ em</td>
				<td><input type="text" name="txtgiatreem" size='42' value="<?php echo @$tour['CHILD_PRICE']?>"></td>
			</tr>
			<tr>
				<td>Giá người lớn</td>
				<td><input type="text" name="txtgianguoilon" size='42' value="<?php echo @$tour['ADULT_PRICE']?>"></td>
			</tr>
			<tr>
				<td>Ghi chú</td>
				<td>
					<textarea name="txtchuongtrinhtour" style="width:100%;height:75px;resize: none;" ><?php echo @$tour['TOUR_PROGRAM']?></textarea>
				</td>
			</tr>
			<?php if(!$flagCustomer){ ?>
				<tr>
					<td>Ảnh bìa</td>
					<td><input accept="image/png, image/jpeg, image/jpg"  type="file" name="txtfileanh1" size='42' ></td>
				</tr>	
				<tr>
					<td>Ảnh chi tiết</td>
					<td><input accept="image/png, image/jpeg, image/jpg"  type="file" name="txtfilechitiet1[]" multiple/></td>
				</tr>	
			<?php } ?>
			<tr>
				<td>Chi tiết chương trình</td>
				<td>  
					<?php if(@$tour['PDF']){ ?>
						<a target="_blank" href="<?php echo "../details/".$id."/".$tour['PDF'] ?>" ><?php echo @$tour['PDF'] ?></a> <br>
					<?php } ?>   
					
					<?php if(!$flagCustomer){ ?>
						<input accept=".pdf, .doc, .docx" type="file" name="txtpdf" size='42' >
					<?php } ?>  
					
				</td>
			</tr>
			<tr>
				<td>Ảnh</td>
				<td> 

					<div class="slideshow-container">

						<?php if(@$tour['IMAGE']){ ?>
							<div class="mySlides mySlides2">
								<img src="<?php echo "../images/".$tour['IMAGE'] ?>"  style="width:calc(100% - 100px);" height=150px>
							</div>
						<?php } ?>

						<?php if(@$tour['IMAGE_DETAIL']){ 
							$arrImg = explode(',', $tour['IMAGE_DETAIL']);

							foreach ($arrImg as $value) {
								
								?>  

									<div class="mySlides mySlides2">
										<img src="<?php echo "../details/".$id."/".$value ?>"  style="width:calc(100% - 100px);" height=150px>
									</div>

								<?php

							}

						?>

						<?php } ?>

						<?php if(@$tour['IMAGE_DETAIL']){ ?>
							<a class="prev" onclick="plusSlides(-1, 1)">&#10094;</a>
							<a class="next" onclick="plusSlides(1, 1)">&#10095;</a>
						<?php } ?>

					</div>

				</td>
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