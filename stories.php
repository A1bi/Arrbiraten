<?php
include('include/main.php');
kickGuests();

loadComponent("pics");
$pics = new pics(3);

if ($_POST['create']) {
	
	$id = createId(6, "stories", "file");
	$filename = $_base."media/".$id;
	if (move_uploaded_file($_FILES['file']['tmp_name'], $filename)) {
		$_db->query('INSERT INTO stories VALUES (null, ?, ?, ?, ?, ?, ?)', array($_POST['subject'], $_POST['teacher'], $id, $_FILES['file']['name'], $_user->data['user_id'], time()));
		
		redirectTo();
	}

} else if (!empty($_REQUEST['story'])) {
	$story = $_db->query('SELECT id, file FROM stories WHERE id = ? AND user = ?', array($_REQUEST['story'], $_user->data['user_id']))->fetch();
	if (!empty($story['id'])) {
		
		$filename = $_base."media/".$story['file'];
		if (!empty($_FILES['newFile']['name'])) {
			if (move_uploaded_file($_FILES['newFile']['tmp_name'], $filename)) {
				$_db->query('UPDATE stories SET filename = ? WHERE id = ?', array($_FILES['newFile']['name'], $story['id']));
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
	
	redirectTo("/stories");
}

$result = $_db->query('SELECT * FROM stories WHERE user = ? ORDER BY id DESC', array($_user->data['user_id']));
$stories = array();
while ($story = $result->fetch()) {
	$story['pics'] = $pics->getAll($story['id']);
	$stories[] = $story;
}

$_tpl->assign("stories", $stories);
$_tpl->display("stories.tpl");

?>