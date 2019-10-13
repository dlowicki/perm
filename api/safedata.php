<?php
function encrypt($text) {
  $password="password";
  $enc = openssl_encrypt($text,"AES-128-ECB",$password);
  return $enc;
}

function decrypt($encrypted){
  $password="password";
  $dec = openssl_decrypt($encrypted,"AES-128-ECB",$password);
  return $dec;
}
?>
