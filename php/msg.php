<?php
header("content-type: text/html;charset=utf-8");
date_default_timezone_set("PRC");

$conn = new mysqli('localhost', 'chen', 'chen123', 'db');
if ($conn->connect_error) {
  $status = 0;
  $arr = [
    "status" => $status
  ];
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
} else {
  $status = 1;
  $page = $_POST['page'];
  $pageSize = 5;

  $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $username = "";
  for ($i = 0; $i < 2; $i++) {
    $username .= $chars[mt_rand(0, strlen($chars))];
  }
  // print_r(base_convert(time() - 1420070400, 10, 36).$username);
  // $username = uniqid($username);
  // print_r(md5(time()));
  // exit;

  $sql = "select * from message order by id desc limit ".($page - 1)*$pageSize.", {$pageSize}";
  $result = $conn->query($sql);
  $list = array();
  while($row = mysqli_fetch_array($result)){
    $array = array(
      "id"=>$row["id"],
      "username"=>$row["username"],
      "time"=>$row["time"],
      "text"=>$row["text"],
      "image"=>"http://".$_SERVER["SERVER_NAME"]."/".$row["image"]
    );
    array_push($list, $array);
  }
  $total_sql = "select count(*) from message";
  $total_result = mysqli_fetch_array($conn->query($total_sql));
  $total = $total_result[0];
  $total_pages = ceil($total / $pageSize);
  $arr = [
    "status" => $status,
    "list" => $list,
    "maxPage" => $total_pages
  ];
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
}


exit;
$pageSize = 5;
$showPage = 5;

mysqli_query($conn, "set names 'utf8'");
$sql="select * from message order by id desc";
// $sql = "SELECT * FROM `message` ORDER BY `id` DESC LIMIT " . ($page - 1) * $pageSize . "," . $pageSize;
$result=$conn->query($sql);

$arr=array();
$http = $_SERVER["HTTP_HOST"];

while($row = mysqli_fetch_array($result)){
  // echo $row['image'];
  // exit;
  $image = "http://" . $_SERVER["SERVER_NAME"] . "/" . $row["image"];
  $array = array(
    'id'=>$row['id'],
    'username' => $row['username'],
    'time' => $row['time'],
    'text' => $row['text'],
    'image' => $image
  );
  array_push($arr,$array);
}

print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));

mysqli_free_result($result);

$total_sql = "select count(*) from message";
$total_result = mysqli_fetch_array($conn->query($total_sql));
$total = $total_result[0];
$total_pages = ceil($total / $pageSize);
mysqli_close($conn);

$pageStr = "<div style='text-align:center;margin:40px 0;'>";
$page_banner = '<span>';
$pageOffset = ($showPage - 1) / 2;
if($page > 1){
  $page_banner .= "<a href='index.php?page=1'>首页</a>";
  $page_banner .= "<a href='index.php?page='".($page-1).">上一页</a>";
}

$start = 1;
$end = $total_pages;
if($total_pages > $showPage){
  if($page > $pageOffset + 1){
    $page_banner .= '...';
  }
  if($page > $pageOffset) {
    $start = $page - $pageOffset;
    $end = $total_pages > $page + $pageOffset ? $page + $pageOffset : $total_pages;
  } else {
    $start = 1;
    $end = $total_pages > $showPage ? $showPage : $total_pages;
  }
  if($page + $pageOffset > $total_pages){
    $start = $start - ($page + $pageOffset - $end);
  }
}
for($i = $start; $i <= $end; $i++){
  if($i == $page){
    $page_banner .= "<a class='sel' href='index.php?page=".$i."'>{$i}</a>";
  } else {
    $page_banner .= "<a href='index.php?page=".$i."'>{$i}</a>";
  }
}
if($total_pages > $showPage && $total_pages > $page + $pageOffset){
  $page_banner .= '...';
}
if($page < $total_pages) {
  $page_banner .= "<a href='index.php?page=".($page + 1)."'>下一页</a>";
  $page_banner .= "<a href='index.php?page=".$total_pages."'>尾页</a>";
}

$page_banner .= '共'.$total_pages. '页</span>';
$page_banner .= '<form action="queryIndex.php" method="get" style="display:inline;background: none;">';
$page_banner .= '到第<input type="number" min="1" max="'.$total_pages.'" name="page">页';
$page_banner .= '<input type="submit" value="确定">';
$page_banner .= '</form>';

// echo $page_banner;


