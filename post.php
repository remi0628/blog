<?php
	session_start();
?>
<?php
function file_num(){/*ディレクトリ内のblog記事がいくつ入っているか調べる*/
		$user_id=$_POST['user_id'];
		$blog=1;/*userフォルダの中にいくつまでの番号の記事が入っているか調べる42行目辺りまで*/
		$_SESSION["blog"]=$blog;
		$i=1;
		$count=0;
		$c=0;
		$file_count=0;
		$dir="./article/$user_id/";
		$handle=opendir($dir);
		do{
			$c++;
			$file_count++;
			$entry[$c]=readdir($handle);
		}while($entry[$c]!=false);/*ディレクトリに何個ファイルがあるのか*/
		$file_count=$file_count-3;/*ディレクトリ内の正式な数にする為*/
		while($count!=$file_count) {/*ディレクトリ内の個数分表示するようにwhileを回す*/
			$log="log".$i.".txt";
			$file="./article/$user_id/$log";
			if(file_exists("./article/$user_id/$log")){/*もし$fileがあれば*/
				$i++;
				$count++;
			}else{
				$i++;
			}
		}
		$num=$i-2;/*userディレクトリ内のblog[i].txtの最大の数==$num*/
		$_SESSION['blog_num']=$num;
}
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
		file_num();
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
			file_num();
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
	ini_set('error_reporting',E_ALL);
	ini_set('display_errors','1');
	$title=$_POST['title']."\n";
	$main=str_replace(array("\r", "\n"), '', $_POST['main'])."\n";/*main文にある改行コードを抜き取る*/
	$day=date('Y-m-d')."\n";/*day*/
	$string=$day.$title.$main;/*投稿内容を一つに*/
	$user_id=($_SESSION['user_id']);
	$num=$_SESSION['blog_num'];
	$file2="./img/$user_id/img1.jpg";
	$num++;/*最大番号+1にする事で常に最新の記事番号をつけて保存*/
		$log="log".$num.".txt";
		$file="./article/$user_id/$log";
		$fp=fopen($file,"a");/*ファイルを作成し書き込み*/
		fwrite($fp,$string);
		fclose($fp);
		if($_FILES['upload']['size']>1000000){
			header('Location: register.html');
		}
		if(!$ext=array_search(mime_content_type($_FILES['upload']['tmp_name']),
				array('gif' => 'image/gif',
					  'jpg' => 'image/jpg',
					  'png' => 'image/png'
				),true
			)){
			header('Location: login.html');
		}
		if(is_uploaded_file($_FILES["upload"]["tmp_name"])){
			if(move_uploaded_file($_FILES["upload"]["tmp_name"],$file2)){
				chmod($file2,0644);
			}
		}

		header('Location: mypage.php');
		exit();
}
if(isset($_POST['delete'])){
	$num=$_POST['delete'];
	$user_id=($_SESSION['user_id']);
	$log="log".$num.".txt";
	$file="./article/$user_id/$log";
	unlink("$file");
	header('Location: mypage.php');
	exit();
}
if(isset($_POST['edit'])){
	$_SESSION['num']=$_POST['edit'];
	header('Location: edit.php');
	exit();
}
if(isset($_POST['edit_up'])){
	$user_id=($_SESSION['user_id']);
	$num=$_SESSION['num'];
	$log="log".$num.".txt";
	$file="./article/$user_id/$log";/*ファイル*/
	$title=$_POST['title']."\n";
	$main=str_replace(array("\r", "\n"), '', $_POST['main'])."\n";/*main文にある改行コードを抜き取る*/
	$day=date('Y-m-d')."\n";/*day*/
	$string=$day.$title.$main;/*投稿内容を一つに*/
	$fp=fopen($file,"w");/*ファイルを作成し書き込み*/
	fwrite($fp,$string);
	fclose($fp);
	header('Location: mypage.php');
	exit();
}
?>