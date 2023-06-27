
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/public/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	
	<script src="/js/jquery.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="/public/css/styles.css">
	<title>Вход</title>
</head>
<body >
	<div style="position: fixed; top: 0px; left: 0px; padding: 20px;">
	</div>
	<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
		<div class="d-flex col-md-5 justify-content-center align-items-center mainblock flex-column"  >
			<img src="/public/img/logo.svg" style="width: 100px; height: 100px; margin-bottom: 100px;">
			<h1 style="font-size: 24px;">Вход</h1>
			<div class="col-12">
			 	<form style="margin-bottom: 10px;" id="form">
			 		<input type="text" name="name" id="uname" placeholder="Введите логин"  readonly="readonly" onfocus="this.removeAttribute('readonly');" required>
			 		<div style="height: 20px;" class="formerror">
			 			<p  id="nameerror"></p>
			 		</div>
			 		<input type="password" name="password" id="password" placeholder="Введите пароль"  readonly="readonly" onfocus="this.removeAttribute('readonly');" required>
			 		<div style="height: 20px;" class="formerror">
			 			<p  id="passerror"></p>
			 		</div>
			 		<button>Продолжить</button>
			 	</form>
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center">
				<p></p>
				<a href="/newuser" class="nnchat">У меня нет аккаунта</a>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$("#form").on('submit', function (e) {   
		    e.preventDefault();
		    
		    // Сохраняем сслыку на форму
		    $.ajax({

	            url: "/loginuser",
	            type: "POST",
	            data: {
	                name: uname.value,
	                password: password.value
	            },
	            success: function(data) {
	            	if (data == 'wrong') {
	            		nameerror.innerHTML = '';
	            		passerror.innerHTML = 'Неверный пароль';
	            	}else if(data == 'notfound'){
	            		passerror.innerHTML = '';
	            		nameerror.innerHTML = 'Пользователь не найден';
	            	}else{
	            		self.location='/'+data;
	            	}
	            	
	            },
	            error: function(){
	                console.log('AJAX №1');
	            }
	        });
		});
	</script>
</body>
</html>