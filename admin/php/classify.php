<?php
header("content-type:text/html;charset=utf-8");

$conn = new mysqli("localhost", "chen", "chen123", "db");
if($conn->connect_error) {
  $status = 0;
  $arr = [
    "status"=>$status
  ];
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
} else {
  $status = 1;
  $sql = "select * from classify";
  $result = $conn->query($sql);
  $list = array();
  while($row = mysqli_fetch_array($result)){
    $array = array(
      "id"=>$row["id"],
      "name"=>$row["name"]
    );
    array_push($list, $array);
  }
  $arr = [
    "status"=>$status,
    "list"=>$list
  ];
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
}