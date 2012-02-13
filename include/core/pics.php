<?php

class pics {
	
	var $type;
	
	function __construct($type) {
		$this->type = $type;
	}
	
	function getAll() {
		global $_db, $_user;
		
		// fetch pics
		$result = $_db->query('SELECT id, pic FROM pics WHERE owner = ? AND type = ?', array($_user->data['user_id'], $this->type));
		return $_db->fetchAll($result);
	}
	
	function handleActions($uri) {
		global $_base, $_db, $_user;
		
		// uploaded photos ?
		if ($_POST['upload']) {

			loadComponent("resize");
			$resize = new resize;

			$id = createId(6);
			$filename = $_base."gfx/cache/pics/full/".$id.".jpg";

			if (move_uploaded_file($_FILES['file']['tmp_name'], $filename)) {
				chmod($filename, 0777);

				$_db->query('INSERT INTO pics VALUES (null, ?, ?, ?, ?)', array($this->type, $id, $_user->data['user_id'], time()));
				$resize->resizepic($id, "pics", "medium");
			}

			redirectTo();
		}

		// deleted photo ?
		if ($_GET['action'] == "del") {
			$result = $_db->query('SELECT id, pic FROM pics WHERE id = ? AND owner = ? AND type = ?', array($_GET['id'], $_user->data['user_id'], $this->type));
			$row = $_db->fetchAssoc($result);

			// correct id ?
			if (!empty($row['pic'])) {
				$_db->query('DELETE FROM pics WHERE id = ?', array($row['id']));

				loadComponent("resize");
				$resize = new resize;
				$resize->del_pic("pics", "medium", $row['pic']);
			}

			redirectTo($uri);
		}
	}
}

?>
