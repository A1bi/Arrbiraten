<?php

class pics {
	
	protected $type, $size;
	
	function __construct($type, $size = "medium") {
		$this->type = $type;
		$this->size = $size;
	}
	
	function setType($type) {
		$this->type = $type;
	}
	
	
	function getAll($owner = "") {
		global $_db, $_user;
		
		if (!isset($owner)) $owner = $_user->data['user_id'];
		
		// fetch pics
		$result = $_db->query('SELECT id, pic FROM pics WHERE owner = ? AND type = ?', array($owner, $this->type));
		return $_db->fetchAll($result);
	}
	
	function handleActions($uri, $owner = "") {
		global $_user;
		
		if (empty($owner)) $owner = $_user->data['user_id'];
		
		// uploaded photos ?
		if ($_POST['upload']) {
			$this->importUpload($_FILES['file'], $owner);
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
	
	protected function createId() {
		return createId(6, "pics", "pic");
	}
	
	protected function getFilename($id) {
		global $_base;
		
		return $_base."gfx/cache/pics/full/".$id.".jpg";
	}

	function importUpload($file, $owner) {
		$id = $this->createId();
		
		if (move_uploaded_file($file['tmp_name'], $this->getFilename($id))) {
			$this->import($id, $owner);
		}
	}
	
	function importFile($file, $owner) {
		$id = $this->createId();
		
		if (rename($file, $this->getFilename($id))) {
			$this->import($id, $owner);
		}
	}
	
	protected function import($id, $owner) {
		global $_db;
		
		loadComponent("resize");
		$resize = new resize;
		
		chmod($this->getFilename($id), 0777);

		$_db->query('INSERT INTO pics VALUES (null, ?, ?, ?, ?)', array($this->type, $id, $owner, time()));
		$resize->resizepic($id, "pics", $this->size);
	}
	
	function updateOwner($id, $owner) {
		global $_db;
		
		$_db->query('UPDATE pics SET owner = ? WHERE id = ?', array($owner, $id));
	}
}

?>
