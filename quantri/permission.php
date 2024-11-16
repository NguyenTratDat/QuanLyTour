<?php
	// session_start();
if(isset($_SESSION['username'])== false)
{
	header('Location:login.php');
}
else
{
	// Ngược lại nếu đã đăng nhập 
	if (isset($_SESSION['position']) == true)
		{  
			$permission = $_SESSION['position']; 
			// Kiểm tra quyền của người đó có phải là admin hay không
			 
			if ($permission == 'USER') 
			{ 
		// Nếu không phải admin thì xuất thông báo echo "Bạn không đủ quyền truy cập vào trang này
				echo "Bạn không đủ quyền truy cập vào trang này";
	 			echo "<a href='index.php'>Click để trở lại trang chủ</a>";	
	 			exit();
			}

		}
}
?>