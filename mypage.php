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
					<li class="menu">Mypage</li>
					<li class="menu">投稿</li>
					<li class="menu"><button type="submit" name="logout">Logout</li>
					<li class="menu"><?php echo $_SESSION['user_id'];?></li>
				</ul>
			</form>
		</div>
		<h1 class="mypage">Mypage</h1>
		<?
		$user_id = $_SESSION['user_id'];
		$i=1;
		$count=1;
		while($count == 1) {
			$log = "log".$i.".txt";
			$file = "./article/$user_id/$log";
			if(file_exists("./article/$user_id/$log")){/*もし$fileがあれば表示*/
			$log = "log".$i.".txt";
			$file = "./article/$user_id/$log";
			$fp = fopen($file,"r");
			$title = fgets($fp);
			$title = fgets($fp);
			fclose($fp);
			printf('
			<div class="article">
				<div class="part">
					<p class="title box">'.$title.'</p>
					<button type="submit" class="box">編集</button>
					<button type="submit" class="box">削除</button>
				</div>
			</div>
			');
			$i++;
			}else{
				$count=0;
				break;
			}
		}
		?>
	</body>
</html>