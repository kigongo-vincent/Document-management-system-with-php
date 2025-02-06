<?php
include './connect.php';
    $q3 =mysqli_query($c, "select * from document");
$qr3 = [];
while ($row =mysqli_fetch_assoc($q3)) {
    array_push($qr3, $row);
}
echo json_encode($qr3);

