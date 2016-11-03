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
		<h1>投稿</h1>
		<div class="form">
			<form id="up" action="post.php" method="post">
				<div>
					<label for="title">title:</label>
					<input type="text" id="title"  name="title" />
				</div>
				<div>
					<label for="main">main:</label>
					<textarea id="main" name="main"></textarea>
				</div>
				<div class="day">
					<p>2016-10-23 3:51</p>
				</div>
				<div class="button">
					<button type="submit" name="up">UP</button>
				</div>
			</form>
		</div>
	</body>
</html>