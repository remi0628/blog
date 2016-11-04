<?php session_start();?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="main.css">
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
		<h1>blog</h1>
		<h2 class="desc">description</h2>
<!--php-->
		<?
		$user_id = $_SESSION['user_id'];
		$blog_num = $_SESSION['blog_num'];
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
				$day = fgets($fp);
				$title = fgets($fp);
				$main = fgets($fp);
				fclose($fp);
				printf('
					<div class="article">
						<p class="day">'.$day.'</p>
						<a class="title">'.$title.'</a>
						<div class="main">
							<h2 class="heading"></h2>
							<p>'.$main.'</p>
						</div>
					</div>
				');
				$i++;
				$count++;
			}else{
				$i++;
			}
		}
		echo $blog_num;
		?>
	</body>
</html>