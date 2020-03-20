<?php

  $id=$_POST['id'];
  $image=$_POST['url'];
  // echo $image;
  // exit;
  $conn=new mysqli('localhost','chen','chen123','db');
  if($conn->connect_error){
    $arr=array(
      'no'=> 0,
      'status'=>'数据库连接失败'
    );
    print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
    exit;
  }
  
  $sql_del="delete from message where id='{$id}'";
  $res_del = $conn->query($sql_del);
  if($res_del){

  $arr = array(
    'no'=> 1,
    'status' => '删除成功'
  );
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
  $res = unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $image);
  exit;
  } else {
  $arr = array(
    'no'=> -1,
    'status' => '系统繁忙'
  );
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
  exit;
  }
  mysqli_close($conn);


