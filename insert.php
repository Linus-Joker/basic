<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Insert data</title>
</head>

<body>
	<?php

	function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	// 定義變量並設置為空值
	$name = $phone = $password = $mail = $web = $gender =  "";

	// $userpassword=md5($_POST['password']); 
	// 先不用md5，因為你存蝦小我不曉得。 
	// 使用者資料
	// from post 資料過來存進變數
	// 1.驗證變數資料是否為空值
	// 2.解析資料
	// 3.資料是否符合格式
	// 4.將資料和資料庫比對，若!=0則重複
	// 5.最後將資料丟進資料庫

	//使用者資料變數
	$username = $_POST['username'];
	$userphone = $_POST['userphone'];
	$userpassword = $_POST['userpassword'];
	$usermail = $_POST['usermail'];
	$usergender = $_POST['usergender'];

	// 資料解析判斷
	if (empty($username)) {
		echo "請輸入姓名";
		return;
	} else {
		$name = test_input($username);
		if (!preg_match("/^[0-9a-zA-Z\x7f-\xff]+$/", $name)) {
			echo "只允許數字、字母、中文和空格!!";
			return;
		}
	}

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

	$mail = test_input($usermail);
	// echo $mail . "<br>";

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

	// $readSQL = "SELECT * FROM test";
	$insert_sql = "INSERT INTO `users` (`name`, `gender`, `password`, `phone`, `mail`) VALUES ('$name','$usergender','$password','$phone','$mail')";

	// $result = mysqli_query($conn, $readSQL);
	$name_sql = "SELECT * FROM users WHERE `name` = '" . str_replace("\'", "''", "$name") . "'";
	$phone_sql = "SELECT * FROM users WHERE `phone` = '" . str_replace("\'", "''", "$phone") . "'";
	// $mail_sql = "SELECT * FROM test WHERE mail LIKE '" . str_replace("\'", "''", "$mail") . "'";
	$mail_sql = "SELECT * FROM users WHERE `mail` =  '" . str_replace("\'", "''", "$mail") . "'";

	$name_result = mysqli_query($conn, $name_sql);
	$phone_result = mysqli_query($conn, $phone_sql);
	$mail_result = mysqli_query($conn, $mail_sql);

	// $row = mysqli_fetch_row($result);
	$name_row = mysqli_num_rows($name_result);
	$phone_row = mysqli_num_rows($phone_result);
	$mail_row = mysqli_num_rows($mail_result);

	if ($name_row !== 0) {
		echo " 姓名重複註冊 ";
		return;
	}
	if ($phone_row !== 0) {
		echo " 電話重複註冊 ";
		return;
	}
	if ($mail_row !== 0) {
		echo " email重複註冊 !!";
		return;
	} else {
		mysqli_query($conn, $insert_sql);
		echo " 姓名、電話、Mail註冊成功 !!";
	}

	// if (mysqli_query($conn, $sql)) {
	// 	echo " 新紀錄插入成功 ";
	// } else {
	// 	echo " Error: " . $sql . " < br > " . mysqli_error($conn);
	// }

	?>

</body>

</html>