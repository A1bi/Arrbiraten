<?php

class pics {
	
	var $table, $uri; 
	
	function __construct($uri, $table) {
		$this->table = $table;
		$this->uri = $uri;
	}
	
	function getAll() {
		global $_db, $_user;
		
		// fetch pics
		$result = $_db->query('SELECT id, pic FROM '. $this->table .' WHERE user = ?', array($_user->data['user_id']));
		return $_db->fetchAll($result);
	}
	
	function handleActions() {
		global $_base, $_db, $_user;
		
		// uploaded photos ?
		if ($_POST['upload']) {

			loadComponent("resize");
			$resize = new resize;

			$id = createId(6);
			$filename = $_base."gfx/cache/pics/full/".$id.".jpg";

			if (move_uploaded_file($_FILES['file']['tmp_name'], $filename)) {
				chmod($filename, 0777);

				$_db->query('INSERT INTO '. $this->table .' VALUES (null, ?, ?, ?)', array($id, $_user->data['user_id'], time()));
				$resize->resizepic($id, "pics", "medium");
			}

			redirectTo();
		}

		// deleted photo ?
		if ($_GET['action'] == "del") {
			$result = $_db->query('SELECT id, pic FROM '. $this->table .' WHERE id = ? AND user = ?', array($_GET['id'], $_user->data['user_id']));
			$row = $_db->fetchAssoc($result);

			// correct id ?
			if (!empty($row['pic'])) {
				$_db->query('DELETE FROM '. $this->table .' WHERE id = ?', array($row['id']));

				loadComponent("resize");
				$resize = new resize;
				$resize->del_pic("pics", "medium", $row['pic']);
			}

			redirectTo($this->uri);
		}
	}
}

?>
