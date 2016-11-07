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
	$title=$_POST['title']."\n";
	$main=str_replace(array("\r", "\n"), '', $_POST['main'])."\n";/*main文にある改行コードを抜き取る*/
	$day=date('Y-m-d')."\n";/*day*/
	$string=$day.$title.$main;/*投稿内容を一つに*/
	$user_id=($_SESSION['user_id']);
	$num=$_SESSION['blog_num'];
	$num++;/*最大番号+1にする事で常に最新の記事番号をつけて保存*/
	$log="log".$num.".txt";
	$file="./article/$user_id/$log";
	$fp=fopen($file,"a");/*ファイルを作成し書き込み*/
	fwrite($fp,$string);
	fclose($fp);
	ini_set('error_reporting',E_ALL);
	ini_set('display_errors','1');
	ini_set('open_basedir','none');
	$file_name=$_FILES['upload'];
	$tmp_name=$file_name['tmp_name']['0'];//一時ファイルのパス
	$tmp_size=getimagesize($tmp_name);//ファイルのサイズ取得
	$img=$extension=null;
	switch($tmp_size[2]){
		case 1:
			$img=imageCreateFromGIF($tmp_name);
			$extension='gif';
			break;
		case 2:
			$img=imageCreateFromJPEG($tmp_name);
			$extension='jpg';
			break;
		case 3:
			$img=imageCreateFromPNG($tmp_name);
			$extension='png';
			break;
		default: break;
	}
	$nu500=500;
	$false=false;
	$dir='./img/$user_id/';
	$save_name=$num.'.'.$extension;//blog番号.ファイル形式
	$path=$_SERVER["DOCUMENT_ROOT"].$dir.$save_name;
	$img_size=getimagesize($img,$nu500);//最大500px
	$out=imagecreatetruecolor($image_size['w1'],$image_size['h1']);//新しい画像データ
	function getImageSize($img=null,$maxsize=300){//画像サイズを変更
		if(!$img)return false;
		$w0=$w1=imageSx($img);//画像幅
		$h0=$h1=imageSy($img);//画像の高さ
		if($w0>$maxsize){//maxsize以下の大きさに変更
			$w1=$maxsize;
			$h1=(int)$h0*($maxsize/$w0);
		}
		if($h1>$maxsize){
			$w1=(int)$w1*($maxsize/$h1);
			$h1=$maxsize;
		}
		return array(
			'w0'=>$w0,//元の幅
			'h0'=>$h0,//高さ
			'w1'=>$w1,//保存の幅
			'h1'=>$h1//高さ
		);
	}
	$color=imagecolorallocate($out,255,255,255);//色
	imagefill($out,0,0,$color);//背景を白に
	imagecopyresampled($out,$img,0,0,0,0,$img_size['w1'],$img_size['h1'],$image_size['w0'],$image_size['h0']);//コピー先,コピー元,コピー先x,コピー先y,コピー元x,コピー元y,コピー先：幅,コピー先：高さ,コピー元：幅,コピー元：高さ
	saveImage($out,$path,$extension);
	function saveImage($img=null,$file=null,$ext=null){//画像を保存する
		if(!$img || !$file || !$ext)return false;
		switch($ext){
			case "jpg":
				$result=imagejpeg($img,$file);
				break;
			case "gif":
				$result=imagegif($img,$file);
				break;
			case "png":
				$result=imagepng($img,$file);
				break;
			default: return false; break;
		}
		chmod($file,0644);
		return $result;
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