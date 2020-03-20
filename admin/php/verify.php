<?php
/**
 * 产生验证码
 *
 * @param integer $type   类型 0：纯数字 1：字母 2：数字+字母
 * @param integer $length 长度
 * @param integer $width  宽度
 * @param integer $height 高度
 * @return string  真实验证码字符串
 */
function generateVerify($type=2,$length=4,$width=100,$height=30){
  $image = imagecreatetruecolor($width,$height);
  $white = imagecolorallocate($image,255,255,255);
  imagefilledrectangle($image,0,0,$width,$height,$white);
  function randColor($image){
    return imagecolorallocate($image,mt_rand(0,255), mt_rand(0, 255), mt_rand(0, 255));
  }
  switch($type){
    case 0:
      $str = join('',array_rand(range(0, 9), $length));
      break;
    case 1:
      $str = join('',array_rand(array_flip(array_merge(range('a','z'), range('A','Z'))),$length));
      break;
    case 2:
      $str = join('', array_rand(array_flip(array_merge(range(0,9),range('a', 'z'), range('A', 'Z'))), $length));
  }
  for($i = 0; $i<$length;$i++){
    // imagettftext($image,16,mt_rand(-30,30),$i*($width/$length),mt_rand($height-15,25),randColor($image), 'ttf/AllerDisplay.ttf',$str[$i]);
    imagestring($image, 16, $i * ($width / $length), mt_rand(0, 20), $str[$i], randColor($image));
  }
  for($i=1;$i<=100;$i++){
    imagesetpixel($image,mt_rand(0,$width),mt_rand(0,$height),randColor($image));
  }
  header('Content-Type:image/png');
  imagepng($image);
  imagedestroy($image);
  return $str;
}

?>