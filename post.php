<?php
	session_start();
?>
<?php
if(isset($_POST['save'])){/*register処理*/
	if(isset($_POST['user_id'])&&isset($_POST['password'])){
		$user_id=$_POST['user_id'];
		$password=$_POST['password'];
		$string=$user_id.",".$password."\n";
		$fp=fopen("data.txt","a");/*ファイルへ登録情報保存*/
		fwrite($fp,$string);
		fclose($fp);
		header('Location: mypage.php');/*mypage.htmlへ*/
		exit();
	}
}
if(isset($_POST['login'])){/*login処理*/
	if(isset($_POST['user_id'])&&isset($_POST['password'])){
		$user_id=$_POST['user_id'];
		$password=$_POST['password'];
		$string=$user_id.",".$password;
		$register_id=file_get_contents('./data.txt',true);/*data.txt内のデータを文字列に読み込む*/
		if(strpos($register_id,$string)!==false){/*register_idの中身とloginフォームで入力した情報を照らし合わせる*/
			$login_cookie=$user_id;
			setcookie("$login_cookie",1);/*クッキーの保存*/
			$_SESSION['user_id']=$user_id;
			header('Location: mypage.php');/*登録情報の中に同じ情報が保存されいたらmypageへ*/
			exit();
		}else{
			header('Location: login.html');
			exit();
		}
	}
}
if(isset($_POST['logout'])){
	setcookie("$login_cookie",1,time() - 1800);
	header('Location: login.html');
	exit();
}
if(isset($_POST['up'])){
	$title=$_POST['title']."\n";
	$main=str_replace(array("\r", "\n"), '', $_POST['main'])."\n";
	$day=date('Y-m-d')."\n";
	$string=$day.$title.$main;
	$user_id=strval($_POST['user_id']);
	$file='./article/log.txt';
	$fp=fopen($file,"a");
	fwrite($fp,$string);
	fclose($fp);
}
?>