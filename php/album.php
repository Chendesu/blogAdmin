<?php
header("content-type: text/html;charset=utf-8");
session_start();
date_default_timezone_set("PRC");

$conn = new mysqli("localhost", "chen", "chen123", "db");
if ($conn->connect_error) {
  $status = 0;
  $arr = [
    "status"=>$status
  ];
} else {
  $status = 1;
  mysqli_query($conn, "set names 'utf8'");
  $page = $_POST["page"];
  $pageSize = 9;

  $sql = "select * from album order by id desc limit " . ($page - 1) * $pageSize . ", {$pageSize}";
  $result = $conn->query($sql);
  $list = array();
  while($row = mysqli_fetch_array($result)){
    $array = array(
      "id"=>$row["id"],
      "username"=>$row["username"],
      "time"=>$row["time"],
      "text"=>$row["text"],
      "url" => "http://" . $_SERVER['SERVER_NAME'] . "/" . $row["images"],
    );
    array_push($list, $array);
  }
  $total_sql = "select count(*) from album";
  $total_result = mysqli_fetch_array($conn->query($total_sql));
  $total = $total_result[0];
  $total_pages = ceil($total / $pageSize);
  $arr = [
    "status" => $status,
    "list"=>$list,
    "maxPage"=>$total_pages
  ];
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
}



