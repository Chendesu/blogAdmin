<?php
header("content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
session_start();

if(!isset($_SESSION["isLogin"])||$_SESSION["isLogin"]!=1||!isset($_SESSION["username"])) {
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
      "username"=>$username,
      "grade" => $grade
    ];
    print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
  
  } else {
    $status = 1; // 数据库连接成功
  
    $path = "../../uploads/";
    if (!file_exists($path)) {
      mkdir($path, 0777, true);
    }
  
    if($act == "query") {
      $page = $_POST["page"];
      $pageSize = 5;
      // $sql_query = "select * from message order by id desc";
      $sql_query = "select * from message order by id desc limit ".($page - 1) * $pageSize.", {$pageSize}";
      $result_query = $conn->query($sql_query);
      $arr = array();
      while($row = mysqli_fetch_array($result_query)) {
        if(empty($row["image"])) {
          $image = "";
        } else {
          $image = "http://" . $_SERVER["SERVER_NAME"] . "/" . $row["image"];
        }
        $array = array(
          "id"=> $row["id"],
          "username"=>$row["username"],
          "time"=>$row["time"],
          "text"=>$row["text"],
          "image"=>$image
        );
        array_push($arr, $array);
      }
      $total_sql = "select count(*) from message";
      $total_result = mysqli_fetch_array($conn->query($total_sql));
      $total = $total_result[0];
      $total_pages = ceil($total / $pageSize);
      $arr_query = [
        "status"=>$status,
        "list"=>$arr,
        "maxPage"=>$total_pages,
        "username" =>$username,
        "grade" => $grade
      ];
      print_r(json_encode($arr_query, JSON_UNESCAPED_UNICODE));
    }
  
    if($act == "add") {
      $username = $_POST["username"];
      $text = $_POST["text"];
      $base64_img = trim($_POST["image"]);
      $time = date("Y-m-d H:i:s");
  
      if(preg_match("/^(data:\s*image\/(\w+);base64,)/",$base64_img,$result)){
        $fileType = 1; // 有选择图片
        $type = $result[2];
        if(in_array($type, array("pjpeg","jpeg","gif","png"))) {
          $imgType = 1;
          $uniName = uniqid("blog_".time()).".".$type;
          $new_file = $path . $uniName;
          if(file_put_contents($new_file, base64_decode(str_replace($result[1], "", $base64_img)))) {
            $img_path = str_replace("../../", "", $new_file);
            $upload = 1; // 上传成功
  
            $sql_insert = "insert into message (username,time,text,image) values('$username', '$time', '$text', '$img_path')";
            $result_insert = $conn->query($sql_insert);
            if ($result_insert) {
              $success = 1; //添加成功
            } else {
              $success = 0; // 添加失败
            }
  
          } else {
            $upload = 0; // 上传失败
          }
        } else {
          $imgType = 0; //非法文件类型
        }
        $arr_insert = [
          "status" => $status,
          "fileType" => $fileType,
          "imgType" => $imgType,
          "upload" => $upload,
          "success" => $success
        ];
      } else {
        $fileType = 0; // 没有选择图片
        $sql_insert = "insert into message (username,time,text,image) values('$username', '$time', '$text', '$img_path')";
        $result_insert = $conn->query($sql_insert);
        if ($result_insert) {
          $success = 1; //添加成功
        } else {
          $success = 0; // 添加失败
        }
        $arr_insert = [
          "status" => $status,
          "fileType" => $fileType,
          "success" => $success
        ];
      }
  
      print_r(json_encode($arr_insert, JSON_UNESCAPED_UNICODE));
  
    }
  
    if($act == "edit"){
      $id = $_POST["id"];
      $text = $_POST["text"];
      $image = trim($_POST["image"]);
  
      if(preg_match("/^(data:\s*image\/(\w+);base64,)/", $image, $result)) {
        $fileType = 1; //base64图片
        $type = $result[2];
        if(in_array($type, array("pjpeg","jpeg","gif","png"))){
          $imgType = 1; // 文件类型正确
          $uniName = uniqid("blog_".time()).".".$type;
          $new_file = $path . $uniName;
          if(file_put_contents($new_file, base64_decode(str_replace($result[1], "", $image)))){
            $upload = 1; // 上传成功
            $img_path = str_replace("../../","",$new_file);
  
            $sql_update = "update message set text='{$text}',image='{$img_path}'  where id='{$id}'";
            $result_update = $conn->query($sql_update);
            if ($result_update) {
              $success = 1; //更新成功
            } else {
              $success = 0; //更新失败
            }
  
          } else {
            $upload = 0; // 上传失败
          }
        } else {
          $imgType = 0; // 文件类型错误
        }
        $arr_update = [
          "status"=>$status,
          "fileType" => $fileType,
          "imgType"=> $imgType,
          "upload"=> $upload,
          "success"=>$success
        ];
  
      } else {
        $fileType = 0; // 图片路径
        $sql_update = "update message set text='{$text}' where id='{$id}'";
        $result_update = $conn->query($sql_update);
        if($result_update){
          $success = 1; //更新成功
        } else {
          $success = 0; //更新失败
        }
    
        $arr_update = [
          "status"=>$status,
          "fileType"=> $fileType,
          "success"=>$success
        ];
      
      }
      print_r(json_encode($arr_update, JSON_UNESCAPED_UNICODE));
      
    }
  
    if($act == "delete"){
      $id = $_POST["id"];
  
      $sql = "select * from message where id='{$id}'";
      $result = $conn->query($sql);
      while ($row = mysqli_fetch_array($result)) {
        $root = $_SERVER["DOCUMENT_ROOT"];
        $url = $row["image"];
        $sql_delete = "delete from message where id='{$id}'";
        $result_delete = $conn->query($sql_delete);
        if($result_delete){
          $success = 1;
          if(!empty($url)){
            unlink($root . "/" . $url);
          }
        } else {
          $success = 0;
        }
      }
      $arr_delete = [
        "status" => $status,
        "success" => $success
      ];
      print_r(json_encode($arr_delete, JSON_UNESCAPED_UNICODE));
    }
  
  }

}


