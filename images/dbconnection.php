<?php
$con=mysqli_connect("Localhost", "root", "", "webshoes");
if(!$con){
  echo "Connection Successful";
}else{
  die(mysqli_error($con));
}

?>
