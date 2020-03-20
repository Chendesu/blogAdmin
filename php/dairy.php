<?php
header("content-type:text/html;charset=utf-8;");
date_default_timezone_set("PRC"); // 设置时区

$postData = file_get_contents('php://input');
$requests = !empty($postData) ? json_decode($postData, true) : array();


$conn = new mysqli("localhost","chen","chen123","db");
if($conn->connect_error){
  $status = 0;
  $arr = [
    "status"=>$status
  ];
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
} else {
  $status = 1;
  mysqli_query($conn,"set names 'utf8'");
  // if(isset($_POST["page"])) {
  //   $page = $_POST["page"];
  // } else {
  //   $page = 1;
  // }
  $page = $_POST["page"];//页码
  $pageSize = 5;//每页显示条数


  $sql = "select * from daily order by id desc limit " . ($page - 1) * $pageSize .", {$pageSize}";
  $result = $conn->query($sql);
  $list = array();
  while ($row = mysqli_fetch_array($result)) {
    $array = array(
      'id' => $row['id'],
      'user' => $row['username'],
      'title' => $row['title'],
      'content' => $row['content'],
      'time' => $row['time'],
      'read' => $row['read']
    );
    array_push($list, $array);
  }
  $total_sql = "select count(*) from daily";
  $total_result = mysqli_fetch_array($conn->query($total_sql));
  $total = $total_result[0];
  $total_pages = ceil($total / $pageSize);
  $arr = [
    "status" => $status,
    "list" => $list,
    "maxPage"=>$total_pages
  ];
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
}

