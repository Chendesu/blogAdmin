<?php
header('content-type:text/html;charset=utf-8;');
date_default_timezone_set("PRC");
  

$conn = new mysqli("localhost", "chen", "chen123", "db");
if($conn->connect_error) {
  $status = 0;
  $arr = [
    "status"=>$status
  ];
  print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
} else {
  $status = 1;

  $username = "test";
  $content = $_POST['content']; // 内容
  $base64_img = trim($_POST["image"]);
  $time = date('Y-m-d H:i:s'); // 时间
  $path = "../uploads/";
  if(!file_exists($path)) {
    mkdir($path, 0777, true);
    chmod($path, 0777);
  }
  if(preg_match("/^(data:\s*image\/(\w+);base64,)/",$base64_img, $result)){
    $fileType = 1;
    $type = $result[2];
    if(in_array($type, array("pjpeg","jpeg","gif","png"))){
      $imgType = 1;
      $uniName = uniqid("blog_".time()).".".$type;
      $new_file = $path.$uniName;
      if(file_put_contents($new_file, base64_decode(str_replace($result[1],"",$base64_img)))){
        $img_path = str_replace("../","",$new_file);
        $upload = 1;

        $sql_insert = "insert into message (username, time, text, image) values('$username','$time','$content','$img_path')";
        $result_insert = $conn->query($sql_insert);
        if($result_insert){
          $success = 1;
        } else {
          $success = 0;
        }
      } else {
        $upload = 0;
      }
    } else {
      $imgType = 0;
    }
  } else {
    $fileType = 0;
  }

  $arr_insert = [
    "status" => $status,
    "fileType" => $fileType,
    "imgType" => $imgType,
    "upload" => $upload,
    "success" => $success
  ];
  print_r(json_encode($arr_insert, JSON_UNESCAPED_UNICODE));

}


