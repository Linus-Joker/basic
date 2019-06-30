<?php

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//使用者資料變數
// $username = $_POST['username'];
$userphone = $_POST['userphone'];
$userpassword = $_POST['userpassword'];
// $usermail = $_POST['usermail'];
// $usergender = $_POST['usergender'];

// 資料解析判斷
/* if (empty($username)) {
  echo "請輸入姓名";
  return;
} else {
  $name = test_input($username);
  if (!preg_match("/^[0-9a-zA-Z\x7f-\xff]+$/", $name)) {
    echo "只允許數字、字母、中文和空格!!";
    return;
  }
} */

if (empty($userphone)) {
  echo "請輸入電話";
  return;
} else {
  $phone = test_input($userphone);
  if (!preg_match("/09[0-9]{8}/", $phone)) {
    echo "請輸入09開頭之10位數字!!";
    return;
  }
}

if (empty($userpassword)) {
  echo "請輸入密碼";
  return;
} else {
  $password = test_input($userpassword);
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
$query_sql = "SELECT * FROM users WHERE phone = $phone AND password = $password";
$query_result = mysqli_query($conn, $query_sql);
$query_row = mysqli_num_rows($query_result);
if ($query_row === 0) {
  echo '電話或密碼錯誤';
  return;
} else {
  echo "登入成功";
}


// $mail = test_input($usermail);
// echo "hello login";
