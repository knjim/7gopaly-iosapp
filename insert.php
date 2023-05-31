<?php
$link = mysqli_connect("localhost","batteruser","i3301user") or die("無法連接".mysql_error());  // 建立MySQL的資料庫連結
mysqli_select_db($link,"iosteam")or die ("無法選擇資料庫".mysql_error()); // 選擇資料庫

mysqli_query($link, 'SET CHARACTER SET utf8');

mysqli_query($link,  "SET collation_connection = 'utf8_general_ci'");

$sql ="INSERT INTO user (username,password,g_name,sex,age,phone,mail)  VALUES ('$_POST[username]','$_POST[password]','$_POST[name]','$_POST[sex]','$_POST[age]','$_POST[phone]','$_POST[mail]')";  //新增資料

mysqli_query($link,$sql); //執行sql語法

//mysql_close($link); //關閉資料庫連結

header("location:into.php"); //回index.php

?>