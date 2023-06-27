
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/public/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
	<script src="/js/jquery.min.js"></script>

	<script src="/public/js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="/public/css/styles.css">
	<title>Анонимный чат</title>
</head>
<body >
	<div style="position: fixed; top: 0px; left: 0px; padding: 20px;">
		<a href="/<?= $_SESSION['user']['uid']?>"><img src="/public/img/logo.svg" style="width: 50px; height: 50px;"></a>
	</div>
	<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
		<div class="d-flex col-12 col-md-6 justify-content-center align-items-center mainblock flex-column" style="padding: 0;">
			<div class="col-12" style="position: relative;">
				<div>Закрыть чат</div>
				<div class="chat" style="margin-bottom: 70px; position: relative;">
					<div class="rev" style="position: absolute; bottom: 0px;" id="chat">
						
					</div>
				</div>
				<div style="position: absolute; bottom:0; background: #e6e8eb; width: 100%; " >
					<form  id="form">
						<input style="margin: 0;" type="text" name="message" placeholder="Введите сообщение"  id="msgi">
					</form>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
	var conn = new WebSocket('ws://127.0.0.1:8777');
	conn.onopen = function(e) {

		conn.send('{"message": "new room", "value": "two", "user": "<?= $user['name']?>", "link": "<?= $user['uid']?>"}');	
		var chat = document.getElementById('chat');
		let pConn = document.createElement('p');
		pConn.innerHTML = 'Вы подключились к чату';
		chat.prepend(pConn);
	    console.log("Connection established!");
	};

	conn.onmessage = function(e) {
	    var json = JSON.parse(e.data);
	    if (json.message == 'message') {
	    	if (json.link != '<?= $_SESSION['user']['uid']?>') {
	    		var audio = new Audio(['./public/mp3/chatsong.mp3']);
	    		audio.play();

	    	}

	    		        
	    	var chat = document.getElementById('chat');
	    	let pFirst = document.createElement('p');
	    	if (json.link != '<?= $_SESSION['user']['uid']?>') {
	    		pFirst.innerHTML = "<b>Анон</b>: "+json.text;

	    	}else{
	    		pFirst.innerHTML = "<b>Вы</b>: "+json.text;
	    	}
	    	
	    	chat.prepend(pFirst);
	    }
	    else if(json.message == 'disconnect') {
	    	console.log(json);
	    	var chat = document.getElementById('chat');
	    	let pConn = document.createElement('p');
	    	pConn.innerHTML = 'Собеседник покинул чат';
	    	chat.prepend(pConn);
	    	
	    }
	};
	$('#form').submit(function(){
	  	event.preventDefault();
	 	var msg = msgi.value;
		conn.send(`{"message": "new message", "value": "${msg}"}`);
		msgi.value = '';
	
	});
</script>
</body>
</html>