<?php
header("content-type:text/html;charset=utf-8");
session_start();
$username = $_POST["username"];
$password = md5($_POST["password"]);
// $verify = trim(strtolower($_POST["verify"]));
$verifyCode = trim(strtolower($_SESSION['verifyCode']));

$statusLog = $_GET["statusLog"];

$conn = new mysqli("localhost", "chen", "chen123", "db");

if($conn->connect_error){
  $status = 0;
  $arr = [
    "status"=>$status
  ];
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
} else {
  $status = 1;

  switch ($statusLog) {
    case "login":
      // if ($verify !== $verifyCode) {
      //   $code = 0;
      // } else {
        $code = 1;
        $sql = "select * from user where username='{$username}' and password='{$password}'";
        $result = $conn->query($sql);
        $num = mysqli_num_rows($result);
        if ($num == 1) {
          $rows = mysqli_fetch_array($result);
          $_SESSION["username"] = $rows["username"];
          $_SESSION['isLogin'] = 1;
          $_SESSION["grade"] = $rows["grade"];
          $success = 1;
        } else {
          $success = 0;
        }
      // }

      $arr = [
        "status" => $status,
        // "code" => $code,
        "success" => $success,
        "grade"=> $_SESSION["grade"]
      ];
      print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
      break;
    case "logout":
      $_SESSION = [];
      if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 1, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
      }
      session_destroy();
      // header('location:../index.html');
      
  }

  

}







