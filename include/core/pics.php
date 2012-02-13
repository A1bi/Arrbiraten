<?php

class pics {
	
	var $type;
	
	function __construct($type) {
		$this->type = $type;
	}
	
	function getAll($owner = "") {
		global $_db, $_user;
		
		if (empty($owner)) $owner = $_user->data['user_id'];
		
		// fetch pics
		$result = $_db->query('SELECT id, pic FROM pics WHERE owner = ? AND type = ?', array($owner, $this->type));
		return $_db->fetchAll($result);
	}
	
	function handleActions($uri, $owner = "") {
		global $_user;
		
		if (empty($owner)) $owner = $_user->data['user_id'];
		
		// uploaded photos ?
		if ($_POST['upload']) {
			$this->import($_FILES['file'], $owner);
			redirectTo();
		}

		// deleted photo ?
		if ($_GET['action'] == "delPic") {
			$this->del($_GET['id'], $owner);
			redirectTo("/".$uri);
		}
	}
	
	function del($id, $owner) {
		global $_db;
		
		$result = $_db->query('SELECT id, pic FROM pics WHERE id = ? AND owner = ? AND type = ?', array($id, $owner, $this->type));
		$row = $_db->fetchAssoc($result);

		// correct id ?
		if (!empty($row['pic'])) {
			$_db->query('DELETE FROM pics WHERE id = ?', array($row['id']));

			loadComponent("resize");
			$resize = new resize;
			$resize->del_pic("pics", "medium", $row['pic']);
		}
	}
	
	function import($file, $owner) {
		global $_base, $_db;
		
		loadComponent("resize");
		$resize = new resize;

		$id = createId(6, "pics", "pic");
		$filename = $_base."gfx/cache/pics/full/".$id.".jpg";

		if (move_uploaded_file($file['tmp_name'], $filename)) {
			chmod($filename, 0777);

			$_db->query('INSERT INTO pics VALUES (null, ?, ?, ?, ?)', array($this->type, $id, $owner, time()));
			$resize->resizepic($id, "pics", "medium");
		}
	}
}

?>
