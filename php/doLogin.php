<?php
header('content-type:text/html;charset=utf-8;');
session_start();

if (isset($_GET['act']) && $_GET['act'] == 'layout') {
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 1, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
  }
  session_destroy();
  header('location:../login.php');
  exit;
}

$username=$_POST['username'];
$password=md5($_POST['password']);

$conn=new mysqli('localhost','chen','chen123','db');
if($conn->connect_error){
  exit("<script>
        alert('数据库连接失败，请重试');
        location.href='login.php';
      </script>");
}
$sql="select * from user where username='{$username}' and password='{$password}' ";
$result=$conn->query($sql);
$num = mysqli_num_rows($result);
// echo $num;
if($num==1){
  $rows=mysqli_fetch_assoc($result);
  $_SESSION['username']=$rows['username'];
  $_SESSION['isLogin']=1;
  exit("<script>
        alert('登录成功');
        location.href='../index.php';
      </script>");
} else {
  exit("<script>
        alert('登录失败，请重新登录！');
        location.href='../login.php';
      </script>");
}

