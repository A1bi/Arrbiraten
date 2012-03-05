<?php
include('include/main.php');
kickGuests();

loadComponent("pics");
$pics = new pics(3);

if ($_POST['create']) {
	
	$id = createId(6, "stories", "file");
	$filename = $_base."media/".$id;
	if (move_uploaded_file($_FILES['file']['tmp_name'], $filename)) {
		$_db->query('INSERT INTO stories VALUES (null, ?, ?, ?, ?, ?, ?, 0)', array($_POST['subject'], $_POST['teacher'], $id, $_FILES['file']['name'], $_user->data['user_id'], time()));
		
		redirectTo();
	}

} else if (!empty($_REQUEST['story'])) {
	if ($_vars['admin']) {
		$result = $_db->query('SELECT id, file FROM stories WHERE id = ?', array($_REQUEST['story']));
	} else {
		$result = $_db->query('SELECT id, file FROM stories WHERE id = ? AND user = ?', array($_REQUEST['story'], $_user->data['user_id']));
	}
	$story = $result->fetch();
	
	if (!empty($story['id'])) {
		
		if ($_GET['action'] == "resetDownloaded" && $_vars['admin']) {
			$_db->query('UPDATE stories SET downloaded = 0 WHERE id = ?', array($story['id']));
			
		} else {
		
			$filename = $_base."media/".$story['file'];
			if (!empty($_FILES['newFile']['name'])) {
				if (move_uploaded_file($_FILES['newFile']['tmp_name'], $filename)) {
					$_db->query('UPDATE stories SET filename = ?, updated = ? WHERE id = ?', array($_FILES['newFile']['name'], time(), $story['id']));
				}

			} elseif ($_GET['action'] == "del") {
				// delete all pics associated with this story
				$allPics = $pics->getAll($story['id']);
				foreach ($allPics as $pic) {
					$pics->del($pic['id'], $story['id']);
				}

				// delete document
				unlink($filename);

				$_db->query('DELETE FROM stories WHERE id = ?', array($story['id']));

			} else {
				$pics->handleActions("stories", $story['id']);
			}
		
		}	
	}
	
	redirectTo("/stories");
}

if ($_vars['admin']) {
	$result = $_db->query('	SELECT		s.*,
										p.*
							FROM		stories AS s,
										people AS p
							WHERE		s.user = p.user
							ORDER BY	id DESC
							');
} else {
	$result = $_db->query('SELECT * FROM stories WHERE user = ? ORDER BY id DESC', array($_user->data['user_id']));
}
$stories = array();
while ($story = $result->fetch()) {
	$story['pics'] = $pics->getAll($story['id']);
	$stories[] = $story;
}

$_tpl->assign("stories", $stories);
$_tpl->display("stories.tpl");

?>