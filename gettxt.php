<?php
$contents = trim(file_get_contents('php://input'));
$array = json_decode($contents, TRUE);
$path = $array['id'];
echo file_get_contents($path);