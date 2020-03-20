<?php 
header("content-type:text/html;charset=utf-8");
$id = $_POST["id"];
// $id = 5;

$conn = new mysqli("localhost","chen","chen123","db");
if($conn->connect_error){
  exit("数据库连接失败") ;
}
mysqli_query($conn,"set names 'utf8'");





$sql_query = "SELECT * FROM daily WHERE id='{$id}'";
$result_query = $conn->query($sql_query);
$num = mysqli_num_rows($result_query);
if($num == 1){
  $row = mysqli_fetch_array($result_query);
  
  $read = $row["read"]+1;
  $sql_update = "UPDATE `daily` SET `read`={$read} WHERE id={$id}";
  $conn->query($sql_update);
  // echo $read; exit;
  $arr = array(
    "id" => $row["id"],
    "username" => $row["username"],
    "title" => $row["title"],
    "content" => $row["content"],
    "time" => $row["time"],
    "read" => $read
  );
  

  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
  // echo "<br>";
  // echo "==================================================";
  // echo "<br>";
  
  // print_r($row);

  // mysqli_close($conn);
}
