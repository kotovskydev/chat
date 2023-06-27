
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/public/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<script src="/js/jquery.min.js"></script>

	
	<link rel="stylesheet" type="text/css" href="/public/css/styles.css">
	<title>Поиск чата</title>
</head>
<body >
	<div style="position: fixed; top: 0px; left: 0px; padding: 20px;">
		<a href="/<?= $_SESSION['user']['uid']?>"><img src="/public/img/logo.svg" style="width: 50px; height: 50px;"></a>
	</div>
	<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
		<div class="d-flex col-12 col-md-6 justify-content-center align-items-center mainblock flex-column" style="padding: 0;">
			<div><img src="/public/img/load.gif" style="width: 250px;;"></div>
			
			<div>Ищем собеседника</div>
		</div>
	</div>

	<script type="text/javascript">
		window.onbeforeunload = function () {
			$.ajax({

			    url: "/user/closechat",
			    type: "POST",
			    data: {
			        cid: '<?= $_SESSION['chat']['cid']?>'
			    },
			    success: function(data) {
			    	console.log(data);
			    },
			    error: function(){
			        console.log('AJAX №1');
			    }
			});
		}
		

//		setTimeout(
//		  () => {
//		  	var audio = new Audio(['./public/mp3/chatsong.mp3']);
//		  	audio.play();
//		    window.location.href = '/randomchat';
//		  },
//		  4 * 1000
//		);
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
		    if (json.message == 'connection') {
		    	console.log(json);
		    	if (json.user != '<?= $_SESSION['user']['name']?>') {
		    		
		    		window.location.href = '/randomchat';
		    	}
		    	
		    }
		    else if(json.message == 'disconnect') {
		    	
		    	
		    	
		    }
		};
	</script>
</body>
</html>