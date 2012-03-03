<?php
include('include/main.php');
kickGuests(true);

loadComponent("pics");
$pics = new pics(0);

$zip = new ZipArchive();

switch ($_GET['action']) {
	
	case "story":
		$result = $_db->query('SELECT id, file, filename, subject, teacher FROM stories WHERE id = ?', array($_GET['id']));
		$story = $result->fetch();
		
		if (!empty($story['id'])) {
			// create zip file
			$zipFile = "/media/".$story['id'].".zip";
			$zip->open($_base.$zipFile, ZIPARCHIVE::OVERWRITE);
			$root = "Kursbericht - ".$story['subject']." ".$story['teacher'];
			$zip->addEmptyDir($root);
			
			// add story document
			$parts = explode(".", $story['filename']);
			$zip->addFile($_base."media/".$story['file'], $root."/bericht.".end($parts));
			
			// add all photos
			$photos = $root."/pics";
			$zip->addEmptyDir($photos);
			$pics->setType(3);
			$allPics = $pics->getAll($story['id']);
			
			$i = 0;
			foreach ($allPics as $pic) {
				$zip->addFile($_base."gfx/cache/pics/full/".$pic['pic'].".jpg", $photos."/".$i.".jpg");
				$i++;
			}
			
			$zip->close();
			
			$_db->query('UPDATE stories SET downloaded = ? WHERE id = ?', array(time(), $story['id']));
			
			// redirect to newly created file
			redirectTo($zipFile);
		}
		
		echo "Fehler!";
		break;
}
?>
