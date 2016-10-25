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
		<div class="article">
			<div class="part">
				<p class="title box">初投稿</p>
				<button type="submit" class="box">編集</button>
				<button type="submit" class="box">削除</button>
			</div>
		</div>
	</body>
</html>