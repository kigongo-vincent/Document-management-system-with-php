<?php
include './connect.php';
$content = trim(file_get_contents('php://input'));
$array = json_decode($content, TRUE);
$value =  '%'.$array['id'].'%';
$q3 =mysqli_query($c, "select * from 
(
    select * from document WHERE doct like '$value' and access = 0) sub
left join user on sub.userID = user.userID order by docID desc");
$qr3 = [];
while ($row =mysqli_fetch_assoc($q3)) {

    array_push($qr3, $row);
 
}
echo json_encode($qr3);