<?php
header("content-type:text/html;charset=utf-8");
session_start();

if(!isset($_SESSION["isLogin"])||$_SESSION["isLogin"]!=1||!isset($_SESSION["username"])) {
  $arr = ["isLogin"=>0];
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
} else {

  $act = $_GET["act"];
  $username = $_SESSION["username"];
  $grade = $_SESSION["grade"];
  
  $conn = new mysqli("localhost", "chen", "chen123", "db");
  
  if ($conn->connect_error) {
    $status = 0;
    $arr0 = [
      "status" => $status,
      "username"=>$username,
      "grade"=>$grade
    ];
    print_r(json_encode($arr0, JSON_UNESCAPED_UNICODE));
    
  } else {
    $status = 1;
  
    if($act == "query") {
      $page = $_POST["page"];
      $pageSize = 15;
      // $sql = "select * from user order by id desc";
      $sql = "select * from user order by id desc limit " . ($page - 1) * $pageSize . ", {$pageSize}";
      $result = $conn->query($sql);
      $listArr = array();
      while ($row = mysqli_fetch_array($result)) {
        $array = array(
          "id" => $row["id"],
          "username" => $row["username"],
          "grade"=> $row["grade"]
        );
        array_push($listArr, $array);
      }
      $list = array("list" => $listArr);
      $total_sql = "select count(*) from user";
      $total_result = mysqli_fetch_array($conn->query($total_sql));
      $total = $total_result[0];
      $total_pages = ceil($total / $pageSize);
      $arr = [
        "status" => $status,
        "list" => $list,
        "maxPage" => $total_pages,
        "username" => $username,
        "grade" => $grade
      ];
      print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }
  
    if($act == "add") {
      $username = $_POST["username"];
      $password = $_POST["password"];
      $sql_add = "select username from user where username='{$username}'";
      $result_add = $conn->query($sql_add);
      $num = mysqli_num_rows($result_add);
      if ($num > 0) {
        $error = 1; // 用户名已存在
      } else {
        $error = 0; // 用户名
  
        $password = md5($password);
        $sql_insert = "insert into user (username, password, grade) values('{$username}','{$password}', '2')";
        $result_insert = $conn->query($sql_insert);
        if ($result_insert) {
          $success = 1; // 注册成功
        } else {
          $success = 0; // 注册失败
        }
      }
      $arr1 = [
        "status" => $status,
        "error"  => $error,
        "success" => $success
      ];
      print_r(json_encode($arr1, JSON_UNESCAPED_UNICODE));
    }
  
    if($act == "delete") {
      $id = $_POST["id"];
      $sql_del = "delete from user where id='{$id}'";
      $result_del = $conn->query($sql_del);
      if ($result_del) {
        $success = 1; // 删除成功
      } else {
        $success = 0; // 删除失败
      }
      $arr2 = [
        "status" => $status,
        "success" =>  $success
      ];
      print_r(json_encode($arr2, JSON_UNESCAPED_UNICODE));
    }
  
    if($act == "update") {
      $id = $_POST["id"];
      $password = md5($_POST["password"]);
      $sql_update = "update user set password='{$password}' where id='{$id}'";
      $result_update = $conn->query($sql_update);
      if ($result_update) {
        $success = 1; // 修改成功
      } else {
        $success = 0; // 修改失败
      }
      $arr3 = [
        "status" => $status,
        "success" =>  $success
      ];
      print_r(json_encode($arr3, JSON_UNESCAPED_UNICODE));
    }
  
    if($act == "updateGrade") {
      $id_grade = $_POST["id"];
      $gra = $_POST["grade"];
      
      $sql_update_grade = "update user set grade='{$gra}' where id='{$id_grade}'";
      $result_update_grade = $conn->query($sql_update_grade);
      if($result_update_grade) {
        $success = 1; 
      } else {
        $success = 0;
      }
      $arr_grade = [
        "status" => $status,
        "success" => $success
      ];
      print_r(json_encode($arr_grade, JSON_UNESCAPED_UNICODE));
    }
}

  

}



