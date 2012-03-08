<?php
include('include/main.php');
kickGuests(true);

loadComponent("pics");
$pics = new pics(0);

switch ($_GET['action']) {
	
	case "story":
		$result = $_db->query('SELECT id, file, filename, subject, teacher FROM stories WHERE id = ?', array($_GET['id']));
		$story = $result->fetch();
		
		$zip = new ZipArchive();
		
		if (!empty($story['id'])) {
			// create zip file
			$zipFile = "/media/".$story['id'].".zip";
			$zip->open($_base.$zipFile, ZIPARCHIVE::OVERWRITE);
			$root = $story['subject']." ".$story['teacher'];
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
		
	case "profiles":
		if ($_GET['pics']) {
			// create zip file
			$zip = new ZipArchive();
			$zipFile = "/media/profiles.zip";
			$zip->open($_base.$zipFile, ZIPARCHIVE::OVERWRITE);

			$root = "Steckbriefe";
			$zip->addEmptyDir($root);

			$photos = $root."/pics";
			$zip->addEmptyDir($photos);
		}
			
		$xml = new SimpleXMLElement("<people />");
		
		$result = $_db->query('SELECT * FROM people');
		while ($person = $result->fetch()) {
			// add basic info
			$personXML = $xml->addChild("person");
			$personXML->addChild("firstname", $person['firstname']);
			$personXML->addChild("lastname", $person['lastname']);
			
			// add photos
			$picsXML = $personXML->addChild("pics");
			$result2 = $_db->query('SELECT type, pic FROM pics WHERE (type = 1 OR type = 4) AND owner = ? ORDER BY type DESC', array($person['user']));
			while ($pic = $result2->fetch()) {
				$picsXML->addChild("pic", $pic['pic']);
				if ($_GET['pics']) {
					$zip->addFile($_base."gfx/cache/pics/full/".$pic['pic'].".jpg", $photos."/".$pic['pic'].".jpg");
				}
			}
			
			// add profile fields
			$profile = "";
			$fields = array(
				"nick" => array(
					"caption" => "Landratte"
				),
				"birthday" => array(
					"caption" => "Segelt seit"
				),
				"location" => array(
					"caption" => "Heimathafen"
				),
				"tutor" => array(
					"caption" => "Captain"
				),
				"lks" => array(
					"caption" => "Flagschiffe"
				),
				"goals" => array(
					"caption" => "Nehme Kurs auf"
				),
				"hobbies" => array(
					"caption" => "Rum und..."
				),
				"top" => array(
					"caption" => "Günstiger Wind"
				),
				"flop" => array(
					"caption" => "Flaute"
				),
				"saying" => array(
					"caption" => "Piratenweisheit"
				),
				"greetings" => array(
					"caption" => "Flaschenpost"
				)
			);
			$result2 = $_db->query('SELECT field, value FROM profile_fields WHERE user = ?', array($person['user']));
			$values = $_db->fetchAll($result2, "field");
			foreach ($fields as $field => $info) {
				$profile .= $info['caption'].":\t".$values[$field]['value']."\r";
			}
			$personXML->profile = $profile;
			
			// add about
			$about = "";
			$result2 = $_db->query('SELECT post_text AS text FROM phpbb_posts WHERE topic_id = ? ORDER BY post_id ASC LIMIT 1, 999', array($person['topic']));
			while ($post = $result2->fetch()) {
				$text = nl2br($post['text']);
				// remove double paragraphs
				$text = preg_replace("#\r( *)\r#isU", "\r", $text);
				// remove closing paragraph
				$text = preg_replace("#(\\r+)( *)$#isU", "", $text);
				// remove phpbb shit
				$text = preg_replace("#<!-- s([a-zA-Z:;-=]+) -->(.+)<!-- (.+) -->#isU", "$1", $text);
				$text = preg_replace("#<(.+) />#isU", "", $text);
				$text = preg_replace("#\[(.+)\](.+)\[/(.+)\]#isU", "", $text);
				$about .= $text."\r";
			}
			$personXML->about = substr($about, 0, -1);
			
		}
		
		if ($_GET['pics']) {
			// add xml file
			$zip->addFromString($root."/people.xml", $xml->asXML());
			$zip->close();
			
			// redirect to newly created file
			redirectTo($zipFile);
			
		} else {
			header("Content-type: text/xml");
			echo $xml->asXML();
		}
		
		break;
}
?>
