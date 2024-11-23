 <?php 
    $conn = mysqli_connect('localhost', 'root', '', 'ql_tourdulich');
    mysqli_set_charset($conn, 'UTF8');

    $whereCus = '';

    if($_SESSION['position'] == 'CUSTOMER'){
        $cusId = $_SESSION['user_id'];

        $whereCus = "  AND CUSTOMER_ID = '$cusId' ";
    }

    $result = mysqli_query($conn, "select count(ID) as total from tour_log WHERE 1" . $whereCus);
    $row = mysqli_fetch_assoc($result);
    $total_records = $row['total'];

    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 10;

    $total_page = ceil($total_records / $limit);

    if ($current_page > $total_page){
        $current_page = $total_page;
    }
    else if ($current_page < 1){
        $current_page = 1;
    }

    $start = ($current_page - 1) * $limit;

    $sql = "
        SELECT tours.*, tour_details.ID as detail_ID, tour_details.END, tour_details.START, tour_details.EXPIRED,
            (SELECT SUM(TOTAL_PEOPLE) FROM tour_log WHERE TOUR_ID = tours.ID) as total_people,
            tour_log.CREATED_AT AS created_book, tour_log.CODE_PAY
        FROM tour_log
            LEFT JOIN tours on tours.ID = tour_log.TOUR_ID
            LEFT JOIN tour_details ON tour_details.ID = tours.ID
        WHERE 1 " . $whereCus . "
        ORDER BY tour_log.ID DESC 
        LIMIT $start, $limit";

    $tours = mysqli_query($conn, $sql);
?>