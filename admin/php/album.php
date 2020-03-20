<?php
header("content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
session_start();

if(!isset($_SESSION["isLogin"]) || $_SESSION["isLogin"]!=1 || !isset($_SESSION["username"])) {
  $arr = ["isLogin"=>0];
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
} else {

  $act = $_GET["act"];
  $username = $_SESSION["username"];
  $grade = $_SESSION["grade"];
  
  $conn = new mysqli("localhost", "chen", "chen123", "db");
  
  if ($conn->connect_error) {
    $status = 0; // 数据库连接失败
    $arr0 = [
      "status" => $status,
      "username" => $username,
      "grade" => $grade
    ];
    print_r(json_encode($arr0, JSON_UNESCAPED_UNICODE));
    
  } else {
    $status = 1; // 数据库连接成功
  
    $page = $_POST["page"];
    $pageSize = 5;
    
    if ($act == "query") {
      // $sql_query = "select * from album order by id desc";
      $sql_query = "select * from album order by id desc limit " . ($page - 1) * $pageSize . ", {$pageSize}";
  
      $result_query = $conn->query($sql_query);
      $arr = array();
      while($row = mysqli_fetch_array($result_query)) {
        $array = array(
          "id"=>$row["id"],
          "username"=>$row["username"],
          "time"=>$row["time"],
          "text"=>$row["text"],
          "url"=> "http://".$_SERVER['SERVER_NAME']."/".$row["images"],
          "recommend" => $row["recommend"],
          "classify" => $row["classify"]
        );
        array_push($arr, $array);
      }
      $total_sql = "select count(*) from album";
      $total_result = mysqli_fetch_array($conn->query($total_sql));
      $total = $total_result[0];
      $total_pages = ceil($total / $pageSize);
  
      $arr_query = [
        "status"=>$status,
        "list"=>$arr,
        "maxPage"=>$total_pages,
        "username" => $username,
        "grade" => $grade
      ];
      print_r(json_encode($arr_query, JSON_UNESCAPED_UNICODE));
    }
  
    if($act == "add") {
      $text = $_POST["text"];
      $base64_img = trim($_POST["image"]);
      $time = date("Y-m-d H:i:s");
  
      $path = "../../album/";
      if(!file_exists($path)) {
        mkdir($path, 0777, true);
        chmod($path, 0777);
      }
  
      if(preg_match("/^(data:\s*image\/(\w+);base64,)/",$base64_img, $result)) {
        $fileType = 1; // 文件成功
        $type = $result[2];
        if(in_array($type, array("pjpeg","jpeg","gif","png"))){
          $imgType = 1; // 文件类型正确
          $uniName = uniqid("blog_".time()).".".$type;
          $new_file = $path . $uniName;
          if(file_put_contents($new_file, base64_decode(str_replace($result[1], "", $base64_img)))){
            $img_path = str_replace("../../", "", $new_file);
            $upload = 1; //上传成功
  
            $sql_insert = "insert into album (username, time, text, images) values('$username', '$time', '$text', '$img_path')";
            $result_insert = $conn->query($sql_insert);
            if ($result_insert) {
              $success = 1; // 添加成功
            } else {
              $success = 0; // 添加失败
            }
  
          } else {
            $upload = 0; //上传失败
          }
        } else {
          $imgType = 0; // 文件类型错误
        }
      } else {
        $fileType = 0; // 文件错误
      }
  
      $arr_insert = [
        "status" => $status,
        "fileType" => $fileType,
        "imgType" => $imgType,
        "upload" => $upload,
        "success"=> $success
      ];
      print_r(json_encode($arr_insert, JSON_UNESCAPED_UNICODE));
    }
  
    if($act == "delete") {
      $id = $_POST["id"];
      // $url = $_POST["url"];
  
      $sql = "select * from album where id='{$id}'";
      $result = $conn->query($sql);
      while($row = mysqli_fetch_array($result)) {
        // echo $row["images"];
        $root = $_SERVER['DOCUMENT_ROOT'];
        $url = $row["images"];
  
        $sql_delete = "delete from album where id='{$id}'";
        $result_delete = $conn->query($sql_delete);
        if ($result_delete) {
          $success = 1; //删除成功
          unlink($root."/".$url);
        } else {
          $success = 0; //删除失败
        }
      }
  
      $arr_delete = [
        "status"=>$status,
        "success"=>$success
      ];
      print_r(json_encode($arr_delete, JSON_UNESCAPED_UNICODE));
  
  
    }
  
    if($act == "edit") {
      $id = $_POST["id"];
      $text = $_POST["text"];
  
      $sql_update = "update album set text='{$text}' where id='{$id}'";
      $result_update = $conn->query($sql_update);
      if($result_update) {
        $success = 1; // 更新成功
      } else {
        $success = 0; // 更新失败
      }
  
      $arr_update = [
        "status"=>$status,
        "success"=>$success
      ];
      print_r(json_encode($arr_update, JSON_UNESCAPED_UNICODE));
      
    }
    
    if($act == "updateRecommend") {
      $id_recommend = $_POST["id"];
      $rec = $_POST["recommend"];

      $sql_update_recommend = "update album set recommend='{$rec}' where id='{$id_recommend}'";
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

    if($act == "updateClassify") {
      $id_classify = $_POST["id"];
      $class = $_POST["classify"];
      $sql_update_classify = "update album set classify='{$class}' where id='{$id_classify}'";
      $result_update_classify = $conn->query($sql_update_classify);
      if($sql_update_classify) {
        $success = 1;
      } else {
        $success = 0;
      }
      $arr_classify = [
        "status"=>$status,
        "success"=>$success
      ];
      print_r(json_encode($arr_classify, JSON_UNESCAPED_UNICODE));
    }
  
  }
}

