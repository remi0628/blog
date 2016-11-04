<?php session_start();?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="up.css">
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
		<h1>編集</h1>
		<?php
			$user_id=$_SESSION['user_id'];
			$num=$_SESSION['num'];
			$log="log".$num.".txt";
			$file="./article/$user_id/$log";
			$fp=fopen($file, "r");
			$day=fgets($fp);
			$title=fgets($fp);
			$main=fgets($fp);
			fclose($fp);
		?>
		<div class="form">
			<form id="up" action="post.php" method="post">
				<div>
					<label for="title">title:</label>
					<input type="text" id="title"  name="title" value="<?php echo $title;?>" />
				</div>
				<div>
					<label for="main">main:</label>
					<textarea id="main" name="main"><?php echo $main;?></textarea>
				</div>
				<div class="day">
					<p><?php echo date('Y-m-d H:i')."\n"; ?></p>
				</div>
				<div class="button">
					<button type="submit" name="edit_up">UP</button>
				</div>
			</form>
		</div>
	</body>
</html>