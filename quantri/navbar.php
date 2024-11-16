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
            <li><a href="admin.php?quanly=list_qltourdl">List Tour</a></li>
            <li><a href="admin.php?quanly=dskhachdk">List khách</a></li>

            <?php if($_SESSION['position'] == 'ADMIN'){ ?>

                <li><a href="admin.php?quanly=list_employees">List nhân viên</a></li>

            <?php }  ?>

            
            <li><a href="admin.php?quanly=show_employee">Thông tin cá nhân</a></li>
        </ul>
	</div>
</body>
</html>