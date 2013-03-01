<?php
/*
+------------------------------------------------------------------------------+
|     CoreBeat SyStem Manager
|
|     Creator: Gabu
|
|     Revision: v003
|     Date: 2013. 01. 30.
+------------------------------------------------------------------------------+
*/
if ( !defined('H-KEI') ) { exit; }

class session {
	
	public $sessUid = 0;
	public $sessLevel = 0;
	public $sessLang = LANGTYPE;

	function session() {
		$this->sessionStart();
		$this->sessionCheck();
	}
	
	private function sessionStart() {
		session_start();
		$this->sessionId();
	}

	private function sessionId() {
		if ( !isset($_SESSION['SID']) OR empty($_SESSION['SID']) ) {
			$_SESSION['SID'] = generateCode(30);
		}
	}
	
	private function sessionDestroy() {
		global $database;
		$database->doQuery(" DELETE FROM `".SQLPREF."session` WHERE `session` = '".$_SESSION['SID']."' ");
		unset($_SESSION['SID']);
		session_destroy();
	}
	
	public function sessionSave( $userID = 0, $level = 0 ) {
		global $database;
		
		$sessionVal = SESSIONVALUE;
		
		$exitTime = time()+$sessionVal;
		
		$sess = Array();
		$sess['session'] = $_SESSION['SID'];
		$sess['uid'] = $userID;
		$sess['grouplevel'] = $level;
		$sess['lang'] = LANGTYPE;
		$sess['ip'] = $_SERVER['REMOTE_ADDR'];
		$sess['exit'] = $exitTime;
		
		$database->doQuery("DELETE FROM `".SQLPREF."session` WHERE `session` = '".$_SESSION['SID']."' ");
		$database->doQuery("INSERT INTO `".SQLPREF."session` (`session`,`uid`,`grouplevel`,`lang`,`ip`,`exit`) VALUES ('".$sess['session']."','".$sess['uid']."','".$sess['grouplevel']."','".$sess['lang']."','".$sess['ip']."','".$sess['exit']."') ");
		
		return $sess;
	}
	
	private function sessionUpdate($sess) {
		global $database;
		
		$sessionVal = SESSIONVALUE;
		
		$exitTime = time()+$sessionVal;
		
		$database->doQuery(" UPDATE `".SQLPREF."session` SET `exit` = '".$exitTime."' WHERE `session` = '".$sess['session']."' ");
		
		$sess['exit'] = $exitTime;
		
		return $sess;
	}
	
	private function sessionCheck() {
		global $database, $user;
		
		$now = time();
		$database->doQuery(" DELETE FROM `".SQLPREF."session` WHERE `exit` < ".$now." OR ( `session` = '".$_SESSION['SID']."' AND `ip` != '".$_SERVER['REMOTE_ADDR']."' ) ");
		
		$sess = $database->getRow(" SELECT * FROM `".SQLPREF."session` WHERE `session` = '".$_SESSION['SID']."' ");
		
		if ( !empty($sess) ) {
			$sess = $this->sessionUpdate($sess);
		}
		
		if ( empty($sess) ) {
			$this->sessionDestroy();
			$this->sessionStart();
			$this->sessionSave();
		}
		
		$this->sessLang = $sess['lang'];
		$this->sessUid = $sess['uid'];
		$this->sessLevel = $sess['grouplevel'];
	}
	
}

return; ?>