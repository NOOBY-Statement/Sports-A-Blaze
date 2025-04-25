<?php 

include('conn.php');
$result = mysqli_query($conn, "SELECT * FROM reservation");
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) 
    {
        $data[] = $row;
    }

echo json_encode($data);

?>