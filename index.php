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
					<li class="menu">Mypage</li>
					<li class="menu">投稿</li>
					<li class="menu"><button type="submit" name="logout">Logout</li>
					<li class="menu"><?php echo $_SESSION['user_id'];?></li>
				</ul>
			</form>
		</div>
		<h1>blog</h1>
		<h2 class="desc">description</h2>
<!--php-->
		<div class="article">
			<p class="day">2016-10-22</p>
			<a class="title">初投稿</a>
			<div class="main">
				<h2 class="heading">ブログ始めました！！</h2>
				<p>こんにちは</p>
			</div>
		</div>

	</body>
</html>