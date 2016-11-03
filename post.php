<?php
	session_start();
?>
<?php
if(isset($_POST['save'])){/*register処理*/
	if(isset($_POST['user_id'])&&isset($_POST['password'])){
		$user_id=$_POST['user_id'];
		$password=$_POST['password'];
		$string=$user_id.",".$password."\n";
		$_SESSION['user_id']=$user_id;
		$register_id=file_get_contents('./data.txt',true);/*data.txt内のデータを文字列に読み込む*/
		if(strpos($register_id,$string)===false){
			$fp=fopen("data.txt","a");/*ファイルへ登録情報保存*/
			fwrite($fp,$string);
			fclose($fp);
		}
		$file="./article/$user_id";/*ユーザーファイルがなければファイルを作成する*/
		if(file_exists($file)){
		}else{
			if(mkdir($file,'0777')){
				chmod($file,'0777');
			}
		}
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
if(isset($_POST['logout'])){/*logout処理*/
	setcookie("$login_cookie",1,time() - 1800);
	header('Location: login.html');
	exit();
}
if(isset($_POST['upPage'])){
	header('Location: up.php');
	exit();
}
if(isset($_POST['mypage'])){
	header('Location: mypage.php');
	exit();
}
if(isset($_POST['TL'])){
	header('Location: index.php');
	exit();
}
if(isset($_POST['up'])){
	$title=$_POST['title']."\n";
	$main=str_replace(array("\r", "\n"), '', $_POST['main'])."\n";/*main文にある改行コードを抜き取る*/
	$day=date('Y-m-d')."\n";/*day*/
	$string=$day.$title.$main;/*投稿内容を一つに*/
	$user_id=($_SESSION['user_id']);
	$count=1;
	while(1){
		$log="log".$count.".txt";
		$file="./article/$user_id/$log";
		if(file_exists("./article/$user_id/$log")){/*もし$fileがなければ*/
			$count++;
		}else{
			$fp=fopen($file,"a");/*ファイルを作成し書き込み*/
			fwrite($fp,$string);
			fclose($fp);
			header('Location: mypage.php');
			break;
		}
	}
}
?>