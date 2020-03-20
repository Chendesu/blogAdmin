<?php
header("content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC"); // 设置时区
session_start();

if(!isset($_SESSION["isLogin"]) || $_SESSION["isLogin"]!=1 || !isset($_SESSION["username"])) {
  $arr = ["isLogin"=>0];
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
} else {

  $act = $_GET["act"];
  $username = $_SESSION["username"];
  $grade = $_SESSION["grade"];
  
  $conn = new mysqli("localhost", "chen", "chen123", "db");
  
  if($conn->connect_error) {
    $status = 0; // 数据库连接失败
    $arr = [
      "status"=>$status,
      "username"=> $username,
      "grade"=>$grade
    ];
    print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
  } else {
    $status = 1; // 数据库连接成功
  
    if($act == "query") {
      $page = $_POST["page"];
      $pageSize = 10;
  
      // $sql_query = "select * from daily order by id desc";
      $sql_query = "select * from daily order by id desc limit " . ($page - 1) * $pageSize . ", {$pageSize}";
      $result_query = $conn->query($sql_query);
      $listArr = array();
      while ($row = mysqli_fetch_array($result_query)) {
        $array = array(
          "id" => $row["id"],
          "username" => $row["username"],
          "title" => $row["title"],
          "content" => $row["content"],
          "time" => $row["time"],
          "read" => $row["read"],
          "recommend" => $row["recommend"]
        );
        array_push($listArr, $array);
      }
      $list = array("list" => $listArr);
      $total_sql = "select count(*) from daily";
      $total_result = mysqli_fetch_array($conn->query($total_sql));
      $total = $total_result[0];
      $total_pages = ceil($total / $pageSize);
      $arr_query = [
        "status" => $status,
        "list"  => $list,
        "maxPage" => $total_pages,
        "username" => $username,
        "grade" => $grade
      ];
      print_r(json_encode($arr_query, JSON_UNESCAPED_UNICODE));
    }
  
    if($act == "add") {
      $title = $_POST["title"]; // 标题
      $content = $_POST["content"]; // 日志
      $time = date("Y-m-d H:i:s");
      $read = 0; // 阅读量
  
      // $sql_insert = "insert into daily (username,title,content,time,read) values ('$username','$title','$content','$time','$read')";
      $sql_insert = "INSERT INTO `daily`( `username`, `title`, `content`, `time`, `read`) VALUES ('$username','$title','$content','$time','$read')";
      $result_insert = $conn->query($sql_insert);
      if ($result_insert) {
        $success = 1; // 添加成功
      } else {
        $success = 0; // 添加失败
      }
  
      $arr_insert = [
        "status"  => $status,
        "success" => $success
      ];
      print_r(json_encode($arr_insert, JSON_UNESCAPED_UNICODE));
  
    }
  
    if($act == "update") {
      $id = $_POST["id"];
      $title = $_POST["title"];
      $content = $_POST["content"];
  
      $sql_update = "update daily set title='$title',content='$content' where id='$id'";
      $result_update = $conn->query($sql_update);
      if ($result_update) {
        $success = 1; // 更新成功
      } else {
        $success = 0; // 更新失败
      }
  
      $arr_update = [
        "status"  => $status,
        "success" => $success
      ];
      print_r(json_encode($arr_update, JSON_UNESCAPED_UNICODE));
    }
  
    if($act == "delete") {
      $id = $_POST["id"];
      $sql_delete = "delete from daily where id='{$id}'";
      $result_del = $conn->query($sql_delete);
      if ($result_del) {
        $success = 1; //删除成功
      } else {
        $success = 0; // 删除失败
      }
      $arr_delete = [
        "status" => $status,
        "success" => $success
      ];
      print_r(json_encode($arr_delete, JSON_UNESCAPED_UNICODE));
    }

    if($act == "updateRecommend") {
      $id_recommend = $_POST["id"];
      $rec = $_POST["recommend"];

      $sql_update_recommend = "update daily set recommend='{$rec}' where id='{$id_recommend}'";
      $result_update_recommend = $conn->query($sql_update_recommend);
      if($result_update_recommend) {
        $success = 1;
      } else {
        $success = 0;
      }
      $arr_recommend = [
        "status" => $status,
        "success" => $success
      ];
      print_r(json_encode($arr_recommend, JSON_UNESCAPED_UNICODE));
    }
  
  }
}


