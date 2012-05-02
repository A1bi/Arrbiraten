<?php
include('include/main.php');
loadComponent("pics");

function correctForumPost($text) {
	// remove phpbb shit
	$text = preg_replace("#<!-- s([a-zA-Z:;-=()]+) -->(.+)<!-- (.+) -->#isU", "$1", $text);
	//$text = preg_replace("#<(.+) />#isU", "", $text);
	$text = preg_replace("#\[(.+)\](.+)\[/(.+)\]#isU", "", $text);
	return $text;
}

function correctText($text) {
	// special characters
	$text = preg_replace("#&quot;(.+)&quot;#isU", "„$1“", $text);
	// remove double paragraphs
	$text = preg_replace("#(\r\n)++#isU", "\r\n", $text);
	// remove closing paragraph
	$text = preg_replace("#([\r|\n])+ *$#isU", "", $text);
	return $text;
}

if ($_GET['action'] == "file") {
	kickGuests();
	if (!empty($_GET['id'])) {
		$result = $_db->query('SELECT file FROM downloads WHERE id = ?', array($_GET['id']));
		$file = $result->fetch();
		$_db->query('UPDATE downloads SET downloads = downloads + 1 WHERE id = ?', array($_GET['id']));
		
		redirectTo($file['file']);
	}
			
} else {
	kickGuests(true);
	
	switch ($_GET['action']) {

		case "story":
			$pics = new pics(0);

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
			$pics = new pics(4);

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

			$result = $_db->query('SELECT * FROM people ORDER BY firstname ASC');
			while ($person = $result->fetch()) {
				// add basic info
				$personXML = $xml->addChild("person");
				$personXML->addChild("firstname", $person['firstname']);
				$personXML->addChild("lastname", $person['lastname']);

				// add photos
				$picsXML = $personXML->addChild("pics");
				$pics->setType(4);
				$allPics = $pics->getAll($person['user']);
				$pics->setType(1);
				$allPics = array_merge_recursive($allPics, $pics->getAll($person['user']));
				foreach ($allPics as $pic) {
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
				$fieldsXML = $personXML->addChild("fields");
				foreach ($fields as $field => $info) {
					$value = correctText($values[$field]['value']);
					if (empty($value) || $value == "-") continue;

					if ($field == "birthday") {
						$date = explode(".", $value);
						for ($i = 0; $i < 2; $i++) {
							if (strlen($date[$i])<2) $date[$i] = "0".$date[$i];
						}
						if (strlen($date[2])<3) $date[2] = "19".$date[$i];
						$value = implode(".", $date);
					}

					$fieldXML = $fieldsXML->addChild("field");
					$fieldXML->addChild("caption", $info['caption']);
					$fieldXML->value = $value;
				}

				// add about
				$about = "";
				$result2 = $_db->query('SELECT post_text AS text FROM phpbb_posts WHERE topic_id = ? ORDER BY post_id ASC LIMIT 1, 999', array($person['topic']));
				while ($post = $result2->fetch()) {
					$text = correctText(correctForumPost($post['text']));
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

		case "topic":
			header("Content-Type: text/html; charset=UTF-8");
			$result = $_db->query('SELECT post_text AS text FROM phpbb_posts WHERE topic_id = ?', array($_GET['id']));
			while ($post = $result->fetch()) {
				$text = correctText(correctForumPost($post['text']));
				echo $text."\r";
			}

			break;

		case "names":
			header("Content-Type: text/html; charset=UTF-8");
			$result = $_db->query('SELECT firstname, lastname FROM people ORDER BY firstname ASC');
			while ($person = $result->fetch()) {
				echo $person['firstname'] . " " . $person['lastname'] . " - ";
			}

			break;

		case "pics":	
			$zip = new ZipArchive();

			// create zip file
			$zipFile = "/media/pics.zip";
			$zip->open($_base.$zipFile, ZIPARCHIVE::OVERWRITE);
			$root = "Collagenfotos";
			$zip->addEmptyDir($root);

			// add all photos
			$result = $_db->query('SELECT pic FROM pics WHERE type = 2');
			while ($pic = $result->fetch()) {
				$zip->addFile($_base."gfx/cache/pics/full/".$pic['pic'].".jpg", $root."/".$pic['pic'].".jpg");
			}

			$zip->close();

			// redirect to newly created file
			redirectTo($zipFile);

			break;
			
	}
	
}
?>
