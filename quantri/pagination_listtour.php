 <?php 
    $conn = mysqli_connect('localhost', 'root', '', 'ql_tourdulich');
    mysqli_set_charset($conn, 'UTF8');

    $result = mysqli_query($conn, "select count(ID) as total from tours");
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
            (select SUM(TOTAL_PEOPLE) FROM tour_log WHERE TOUR_ID = tours.ID) as total_people
        FROM tours
            LEFT JOIN tour_details ON tour_details.ID = tours.ID
        ORDER BY ID DESC 
        LIMIT $start, $limit";

    $tours = mysqli_query($conn, $sql);
?>