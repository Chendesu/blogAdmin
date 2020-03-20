<?php
header("content-type: text/html;charset=utf-8");
$conn = new mysqli("localhost", "chen", "chen123", "db");
if($conn->connect_error){
  $status = 0;
  $arr = [
    "status"=>$status
  ];
} else {
  $status = 1;
  $sql = "select * from daily where recommend=1";
  $result_query = $conn->query($sql);
  $arr = array();
  while($row = mysqli_fetch_array($result_query)){
    $array = array(
      "id"=>$row["id"],
      "username"=>$row["username"],
      "title"=>$row["title"],
      "time"=>$row["time"]
    );
    array_push($arr, $array);
  }
  $arr_query = [
    "status"=>$status,
    "list"=>$arr
  ];
  print_r(json_encode($arr_query, JSON_UNESCAPED_UNICODE));
}