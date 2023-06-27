<?php

include_once ROOT.'/models/user.php';


class UserController
{
	
	public function actionSearchChat() {
		$openchats = array(); 
		$openchats = User::getOpenChats();
		if ($openchats == 'notfound') {
			$createChat = array(); 
			$createChat = User::createChat();
			$chatid = $createChat;
			$_SESSION['chat']['cid'] = $createChat;
		}else{
			$chatid = $openchats;
			$setstatus = array(); 
			$setstatus = User::setChatStatus($openchats);
			$_SESSION['chat']['cid'] = $openchats;

		}
		$user = array();
		$user = User::getUser($_SESSION['user']['uid']);
		require_once(ROOT.'/views/user/search.php');

		return true;
	}
	public function actionCloseChat() {
		
		$closechat = array(); 
		$closechat = User::closeChat($_POST['cid']);

		return true;
	}
	public function actionRandomChat() {


		$user = array();
		$user = User::getUser($_SESSION['user']['uid']);
		require_once(ROOT.'/views/user/randchat.php');

		return true;
	}
	public function actionIndex($userid) {

		
		$user = array();
		$user = User::getUser($userid);
		require_once(ROOT.'/views/user/index.php');

		return true;
	}

	public function actionCreateUser() {

		$result = array();
		$result = User::createUser($_POST);
		if ($result == 'success') {
			$resp = $_SESSION['user']['uid'];

		}else{
			$resp = 'busy';
		}
		print_r($resp);
		return true;
	}
	public function actionLoginUser() {

		$result = array();
		$result = User::loginUser($_POST);

		if ($result == 'success') {
			
			print_r($_SESSION['user']['uid']);
		}elseif($result == "Pass wrong"){
			print_r('wrong');
		}elseif($result == "user not found"){
			print_r('notfound');
		}
		return true;
	}
	public function actionNewUser() {

		
		
		if (empty($_SESSION['user']['uid'])) {
			require_once(ROOT.'/views/user/newuser.php');
		}else{
			echo "<script>self.location='/".$_SESSION['user']['uid']."';</script>";
		}
		return true;
	}
	public function actionLogin() {

		
		if (empty($_SESSION['user']['uid'])) {
			require_once(ROOT.'/views/user/login.php');
		}else{
			echo "<script>self.location='/".$_SESSION['user']['uid']."';</script>";
		}
		
		return true;
	}
	public function actionLogout() {

		
		$result = array();
		$result = User::Logout();
		
		return true;
	}
	
}