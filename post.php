<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="refresh" content="3;URL=header.php">
		<title>blog</title>
	</head>
	<body>
		<?php
		session_start();
		/*register処理*/
		if(isset($_POST['save'])) {
			if(isset($_POST['user_id']) && isset($_POST['password'])) {
				$user_id = $_POST['user_id'];
				$password = $_POST['password'];
				$save = $_POST['save'];
				$person = $user_id . " " . $password . ",";
				echo $person;
				/*ファイルへ登録情報保存*/
				$fp = fopen("data.txt", "a");
				fwrite($fp, $person);
				fclose($fp);
				/*記録*/
				$_SESSION['user_id'] = $_POST['user_id'];
				$message = "ログイン情報を記録しました";
			} else {
				echo "IDかPasswordが入力されていません。\n";
				$message = "ログイン情報を記録しませんでした";
			}
			echo $message;
			echo "3秒後に移動します。";
		}
		?>
	</body>