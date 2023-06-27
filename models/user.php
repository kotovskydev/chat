<?php


/**
 * 
 */
class User
{
	public static function createUser($data){

		$db = Db::Connection();
			$uid = 'u'.rand(100000,999999);
			$checkName = $db->prepare("SELECT * FROM users WHERE users.name = :name");
			$checkName->bindParam(':name',$data['name']);
			$checkName->execute();
			$cuser = $checkName->fetch(PDO::FETCH_BOTH);
			if (empty($cuser['uid'])) {
				$getUser = $db->prepare("SELECT * FROM users WHERE users.uid = :uid");
				$getUser->bindParam(':uid',$userid);
				$getUser->execute();
				$guser = $getUser->fetch(PDO::FETCH_BOTH);
				if (empty($guser['uid'])) {
					$getUser = $db->prepare("INSERT INTO users (`name`,`uid`,`password`) VALUES (:name,:uid, :password)");
					$getUser->bindParam(':name',$data['name']);
					$getUser->bindParam(':uid',$uid);
					$getUser->bindParam(':password',$data['password']);
					$getUser->execute();
					$user = $getUser->fetch(PDO::FETCH_BOTH);
				}else{
					$uid = 'u'.rand(100000,999999);
					$getUser = $db->prepare("INSERT INTO users (`name`,`uid`,`password`) VALUES (:name,:uid, :password)");
					$getUser->bindParam(':name',$data['name']);
					$getUser->bindParam(':uid',$uid);
					$getUser->bindParam(':password',$data['password']);
					$getUser->execute();
					$user = $getUser->fetch(PDO::FETCH_BOTH);
				}
				$result = 'success';

				$_SESSION['user']['uid'] = $uid;
				$_SESSION['user']['name'] = $data['name'];
			}else{
				$result = 'engaged';
			}



			return $result;
	}
	public static function loginUser($data){

		$db = Db::Connection();

			$getUser = $db->prepare("SELECT * FROM users WHERE users.name = :name");
			$getUser->bindParam(':name',$data['name']);
			$getUser->execute();
			$user = $getUser->fetch(PDO::FETCH_BOTH);
			if (!empty($user)) {
				if ($user['password'] == $data['password']) {
					$_SESSION['user']['uid'] = $user['uid'];
					$_SESSION['user']['name'] = $user['name'];
					$result = 'success';
				}else{
					$result = 'Pass wrong';
				}
			}else{
				$result = 'user not found';
			}
			

			return $result;
	}

	public static function getUser($userid){

		$db = Db::Connection();

			$getUser = $db->prepare("SELECT * FROM users WHERE users.uid = :uid");
			$getUser->bindParam(':uid',$userid);
			$getUser->execute();
			$user = $getUser->fetch(PDO::FETCH_BOTH);

			return $user;
	}

	public static function setChatStatus($cid){

		$db = Db::Connection();

			$setStatus = $db->prepare("UPDATE chats SET chats.status = 1 WHERE chats.cid = :cid");
			$setStatus->bindParam(':cid',$cid);
			$setStatus->execute();
			$result = $setStatus->fetch(PDO::FETCH_BOTH);

			return $result;
	}

	public static function getOpenChats(){

		$db = Db::Connection();

			$getChats = $db->prepare("SELECT * FROM chats WHERE chats.status = 0 LIMIT 1");
			$getChats->execute();
			$chats = $getChats->fetch(PDO::FETCH_BOTH);
			if (isset($chats['cid'])) {
				return $chats['cid'];
			}else{
				return 'notfound';
			}
			
	}

	public static function createChat(){

		$db = Db::Connection();
			$status = '0';
			$chatnum = 'chat'.rand(10000000,99999999);
			$createChat = $db->prepare("INSERT INTO chats (`cid`,`status`) VALUES (:cid, :status)");
			$createChat->bindParam(':cid', $chatnum);
			$createChat->bindParam(':status', $status);
			$createChat->execute();
			$result = $createChat->fetchAll(PDO::FETCH_BOTH);

			return $chatnum;
	}

	public static function closeChat($cid){

		$db = Db::Connection();

			$setStatus = $db->prepare("UPDATE chats SET chats.status = 2 WHERE chats.cid = :cid");
			$setStatus->bindParam(':cid',$cid);
			$setStatus->execute();
			$result = $setStatus->fetch(PDO::FETCH_BOTH);

			return $result;
	}
	

	public static function Logout(){

		
		session_destroy();

		echo "<script>self.location='/login';</script>";
		exit;
	}

}