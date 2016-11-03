<?php session_start();?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="mypage.css">
		<title>blog</title>
	</head>
	<body>
		<div class="menu_list">
			<form action="post.php" method="post">
				<ul>
					<li class="menu"><button type="submit" name="TL">TL</li>
					<li class="menu"><button type="submit" name="mypage">Mypage</li>
					<li class="menu"><button type="submit" name="upPage">投稿</li>
					<li class="menu"><button type="submit" name="logout">Logout</li>
					<li class="menu"><?php echo $_SESSION['user_id'];?></li>
				</ul>
			</form>
		</div>
		<h1 class="mypage">Mypage</h1>
		<?
		$user_id = $_SESSION['user_id'];
		$blog = 1;
		$_SESSION["blog"] = $blog;
		$i=1;
		$count=0;
		$c = 0;
		$file_count = 0;
		$dir = "./article/$user_id/";
		$handle = opendir($dir);
		do{
			$c++;
			$file_count++;
			$entry[$c] = readdir($handle);
		}while($entry[$c] != false);/*ディレクトリに何個ファイルがあるのか*/
		$file_count = $file_count - 3;/*ディレクトリ内の正式な数にする為*/
		while($count != $file_count) {/*ディレクトリ内の個数分表示するようにwhileを回す*/
			$log = "log".$i.".txt";
			$file = "./article/$user_id/$log";
			if(file_exists("./article/$user_id/$log")){/*もし$fileがあれば表示*/
				$log = "log".$i.".txt";
				$file = "./article/$user_id/$log";
				$fp = fopen($file,"r");
				$title = fgets($fp);
				$title = fgets($fp);/*二回やっているのは二行目のtitleを取得するため*/
				fclose($fp);
				printf('
				<div class="article">
					<div class="part">
						<form action="post.php" method="post">
							<p class="title box">'.$title.'</p>
							<button type="submit" class="box" name="edit" value='.$i.'>編集</button>
							<button type="submit" class="box" name="delete" value='.$i.'>削除</button>
						</form>
					</div>
				</div>
				');/*後で日付を表示するように追加*/
				$i++;
				$count++;
			}else{
				$i++;
			}
		}
		$num=$i-1;/*userディレクトリ内のblog[i].txtの最大の数==$num*/
		$_SESSION['blog_num']=$num;
		echo $file_count;
		?>
	</body>
</html>