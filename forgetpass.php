<?php
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$mail = $_POST['forget_mail'];

if (empty($mail)) {
  echo "請輸入信箱";
  return;
} else {
  $mail = test_input($mail);
}

// 資料庫資料
$servername = "localhost";
$dbusername = "milk";
$dbpassword = "php3345678";

//資料庫名稱
$dbname = "test0624";
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
  die("連線失敗: " . $conn->connect_error);
}

//查詢語法
$query_sql = "SELECT * FROM users WHERE mail = '$mail'";
$query_result = mysqli_query($conn, $query_sql);
$query_row = mysqli_num_rows($query_result);
// print_r($query_sql);
if ($query_row === 0) {
  echo 'email error';
  return;
} else {
  $pass_sql = "UPDATE users SET password = 111111 WHERE mail = '$mail'";
  mysqli_query($conn, $pass_sql);
  echo '密碼更改成功';
}

// echo "ok";
