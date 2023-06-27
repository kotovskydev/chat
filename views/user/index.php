
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/public/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	
	<script src="/js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/public/css/styles.css">
	<title><?= $user['name'] ?></title>
</head>
<body >
	<div style="position: fixed; top: 0px; left: 0px; padding: 20px;">
		<a href="/<?= $_SESSION['user']['uid']?>"><img src="/public/img/logo.svg" style="width: 50px; height: 50px;"></a>
	</div>
	<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
		<div class="d-flex col-md-5 justify-content-center align-items-center mainblock flex-column"  >
			<div class="avatar" style="background: url(/public/img/bSv3tl6te9Y.jpg); background-size: contain; background-position: center;">
			</div>
			<h1 class="pagename"><?= $user['name'] ?></h1>
			<div class="d-flex row col-12">
				<div class="col-6 d-flex ">
					<div class="d-flex likebutton align-items-center justify-content-center">
						<i class="bi bi-emoji-heart-eyes likes"></i>
						<p class="p1">200</p>
					</div>
				</div>

				<div class="col-6 d-flex">
					<div class="d-flex dislikebutton align-items-center justify-content-center">
						<i class="bi bi-emoji-angry dislikes"></i>
						<p class="p1">0</p>
					</div>
				</div>
			</div>
			<?
			if ($_SESSION['user']['uid'] == $user['uid']) {
			?>
			<div class="d-flex row col-12">
				<div class="col-12">
					<a href="/search"><button style="margin-top: 20px;">Найти собеседника</button></a>
					<div style="padding: 10px;" class="col-12 d-flex justify-content-center ">
						<a href="/logout" class="nnchat">Выйти</a>
					</div>	
				</div>
			</div>
			<?
			}
			?>
			
		</div>
	</div>
</body>
</html>