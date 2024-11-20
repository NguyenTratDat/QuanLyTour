<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="vendor/bootstrap.css">
	<link rel="stylesheet" href="vendor/angular-material.min.css">
	<link rel="stylesheet" href="vendor/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/success.css">
	
</head>

<body >

	<?php

		if(!isset($_SESSION['create_tour_log'])){ 
			?>
				<script>window.location = '?'</script>
			<?php
		}

		$logId = $_SESSION['create_tour_log'];

		$logTour_sql = "
			SELECT tour_log.TOTAL, tour_log.CODE_PAY, tours.NAME as TourName, tour_log.CHILDS_AMOUNT, tour_log.ADULTS_AMOUNT,
				tour_details.CHILD_PRICE, tour_details.ADULT_PRICE,
				customers.NAME as CusName, customers.IDCARD, customers.ADDRESS, customers.BIRTHDAY, customers.EMAIL
			FROM tour_log
				LEFT JOIN tours ON tours.id = tour_log.TOUR_ID
				LEFT JOIN tour_details ON tour_details.id = tours.id
				LEFT JOIN customers ON customers.ID = tour_log.CUSTOMER_ID
			WHERE tour_log.id = '$logId' 
		";
		

		$resLogTour = $connect->query($logTour_sql);

		foreach($resLogTour as $tourInfo){
			$CODE_PAY        = $tourInfo['CODE_PAY'];
			$TourName        = $tourInfo['TourName'];

			$CHILDS_AMOUNT   = $tourInfo['CHILDS_AMOUNT']; $CHILD_PRICE   = $tourInfo['CHILD_PRICE'];
			$ADULTS_AMOUNT   = $tourInfo['ADULTS_AMOUNT']; $ADULT_PRICE   = $tourInfo['ADULT_PRICE'];

			$TOTAL           = $tourInfo['TOTAL'];

			$CusName         = $tourInfo['CusName'];
			$IDCARD          = $tourInfo['IDCARD'];
			$ADDRESS         = $tourInfo['ADDRESS'];
			$BIRTHDAY        = $tourInfo['BIRTHDAY'];
			$EMAIL           = $tourInfo['EMAIL'];
		}

	?>

	<div class="container body">

		<div class="container">

			<br>
			<h3 align="center" style="color: red">Chúc mừng bạn đã đặt tour thành công</h3>
			<h3 align="center" style="color: red">Thông tin của bạn đã được gửi đi. Chúng tôi sẽ sớm liên hệ với bạn</h3>
			<h3 align="center" style="color: red">Cảm ơn bạn đã tin tưởng dịch vụ của công ty chúng tôi</h3>

			<div class="container" align="center">

				<div class="title">
					<p>Thông tin thanh toán</p>
				</div>

				<table width="1000px" align="center" id="abc" border="2px" cellpadding="2px" cellspacing="2px">
					<tr>
						<th class="center">Mã thanh toán</th>
						<th class="center">Tên tour</th>			
						<th class="center">Số lượng người lớn</th>
						<th class="center">Số lượng trẻ em</th>
						<th class="center">Tổng thanh toán</th>	
					</tr>
					<tr>
						<td class="center"><?php echo $CODE_PAY ?></td>
						<td><?php echo $TourName ?></td>
						<td class="center"><?php echo ( ( $ADULTS_AMOUNT ) ? $ADULTS_AMOUNT . ' x ' . number_format($ADULT_PRICE) : 0 ); ?></td>
						<td class="center"><?php echo ( ( $CHILDS_AMOUNT ) ? $CHILDS_AMOUNT . ' x ' . number_format($CHILD_PRICE) : 0 );?></td>
						<td class="right"><?php echo number_format($TOTAL) ?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td class="right"><b>Tổng tiền: <?php echo number_format($TOTAL) ?> </b></td>
					</tr>
				</table>

				<br>

				<div class="title"><p>Thông tin liên lạc</p></div>

				<div class="container" align="center">
					<table width="1000px" align="center" id="abc" border="2px">
						<tr>
							<th class="center" >Tên khách</th>
							<th class="center" width="100px">CMND</th>
							<th class="center" width="200px">Email</th>
							<th class="center" width="150px">Ngày sinh</th>
							<th class="center">Địa chỉ</th>
						</tr>	
						<tr>
							<td><?php echo $CusName ?></td>
							<td class="center"><?php echo $IDCARD ?></td>
							<td><?php echo $EMAIL ?></td>
							<td class="center"><?php echo date('d/m/Y', strtotime($BIRTHDAY)); ?></td>
							<td><?php echo $ADDRESS ?></td>
						</tr>
					</table>
				</div>

			</div>

		</div>
</body>
</html>