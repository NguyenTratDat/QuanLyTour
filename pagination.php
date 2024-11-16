 <?php 

    // BƯỚC 1: KẾT NỐI CSDL
    $conn = mysqli_connect('localhost', 'root', '', 'ql_tourdulich');
    mysqli_set_charset($conn, 'UTF8');
    // BƯỚC 2: TÌM TỔNG SỐ RECORDS
    $result = mysqli_query($conn, "select count(ID) as total from thongtinchitiettour where KIND_TOUR = 'Trong Nước'");
    $row = mysqli_fetch_assoc($result);
    $total_records = $row['total'];
    
    // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 8;
    
    // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
    $total_page = ceil($total_records / $limit);
    
    // Giới hạn current_page trong khoảng 1 đến total_page
    if ($current_page > $total_page){
        $current_page = $total_page;
    }
    else if ($current_page < 1){
        $current_page = 1;
    }

    // Tìm Start
    $start = ($current_page - 1) * $limit;

    // BƯỚC 5: TRUY VẤN LẤY DANH SÁCH TIN TỨC
    $resultCountry = mysqli_query($conn, "SELECT * FROM thongtinchitiettour where KIND_TOUR ='Trong Nước' ORDER BY ID DESC LIMIT $start, $limit");


?>


<?php 
    $conn1 = mysqli_connect('localhost', 'root', '', 'ql_tourdulich');
    mysqli_set_charset($conn1, 'UTF8');

    $results = mysqli_query($conn1, "SELECT count(ID) as totals from `thongtinchitiettour` where KIND_TOUR = 'Ngoài Nước' ");
    $rows = mysqli_fetch_assoc($results);
    $total_recordss = $rows['totals'];

    // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
    $current_pages = isset($_GET['page']) ? $_GET['page'] : 1;
    $limits = 8;

    // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
    // tổng số trang
    $total_pages = ceil($total_recordss / $limits);

    // Giới hạn current_page trong khoảng 1 đến total_page
    if ($current_pages > $total_pages){
        $current_pages = $total_pages;
    }
    else if ($current_pages < 1){
        $current_pages = 1;
    }

    // Tìm Start
    $starts = ($current_pages - 1) * $limits;

    $resultGlobal  = mysqli_query($conn1, "SELECT * FROM thongtinchitiettour where KIND_TOUR ='Nước Ngoài' ORDER BY ID DESC LIMIT $start, $limit");
 ?>