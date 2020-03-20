<?php
header('content-type:text/html;charset=utf-8');
$username=$_POST['username'];
$password=$_POST['password'];
$repassword=$_POST['repassword'];

if($username==''||$password==''){
  exit("<script>
    alert('用户名或密码不为空');
    location.href=../'register.php';
  </script>");
}
if($password!=$repassword){
  exit("<script>
    alert('密码不一致');
    location.href='../register.php';
  </script>");
}


$conn = new mysqli('localhost', 'chen', 'chen123', 'db');
if ($conn->connect_error) {
  exit("<script>
    alert('数据库连接失败');
    location.href='index.php';
  </script>");
}
$sql="select username from user where username='{$username}'";
$result=$conn->query($sql);
$num=mysqli_num_rows($result);
if($num>0){
  exit("<script>
    alert('用户名已存在');
    location.href='../register.php';
  </script>");
} else {
  $pwd = md5($password);
  // echo $pwd; exit;
  $sql_insert="insert into user (username,password) values('{$username}','{$pwd}')";
  $res_insert=$conn->query($sql_insert);
  if($res_insert){
    exit("<script>
      alert('注册成功');
      location.href='../login.php';
    </script>");
  } else {
    exit("<script>
      alert('系统繁忙');
      location.href='../register.php';
    </script>");
  }
}

