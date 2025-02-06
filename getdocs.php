<?php
include './connect.php';

$content = trim(file_get_contents('php://input'));
$array = json_decode($content, TRUE);
$value =  $array['id'];
    $q3 =mysqli_query($c, "select * from document left join user on document.userID = user.userID order by docID desc");
$qr3 = [];
while ($row =mysqli_fetch_assoc($q3)) {
   if($row['category'] == $value){
    array_push($qr3, $row);
   }
   if($value == ''){
    array_push($qr3, $row);
   }
}
echo json_encode($qr3);

