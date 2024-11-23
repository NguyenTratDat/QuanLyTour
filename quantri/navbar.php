<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" type="text/css" href="style.css">
<body>

    <div id="navbar">
        <ul>
            <li><a href="admin.php">Trang chủ</a></li>   

            <?php if($_SESSION['position'] == 'CUSTOMER'){ ?>
                <li><a href="admin.php?quanly=history_qltourdl">Lịch sử Tour</a></li>  
            <?php } else{  ?>
                <li><a href="admin.php?quanly=list_qltourdl">Tour</a></li>
                <li><a href="admin.php?quanly=history_qltourdl">Lịch sử Tour</a></li>  
                <li><a href="admin.php?quanly=dskhachdk">Khách hàng</a></li>

                <?php if($_SESSION['position'] != 'USER'){ ?>
                    <li><a href="admin.php?quanly=list_employees">Nhân viên</a></li>
                <?php }  ?>

            <?php }  ?>

            <li><a href="admin.php?quanly=show_employee">Thông tin cá nhân</a></li>
        </ul>
	</div>
</body>
</html>