<?php
include('include/main.php');
kickGuests(true);

set_time_limit(0);
loadComponent("curl");

switch ($_GET['step']) {

	case "download":		
		// prepare raw files
		$result = $_db->query('SELECT id, url FROM lists_song WHERE method = 1 AND file = ""');
		while ($song = $result->fetch()) {
			if (preg_match("#youtube.com/watch\?v=([a-zA-Z0-9-_]+)(&|$)#iU", $song['url'], $matches)) {
				// get video info
				$curl = new curl("http://www.youtube.com/watch?v=".$matches[1]);
				$info = $curl->response();
				$curl->close();

				// filter video url and download it
				if (preg_match("#\"url_encoded_fmt_stream_map\": \"(.+)\", \"#isU", $info, $map)) {
					$map[1] = urldecode(urldecode($map[1]));
					$map[1] = str_replace("\u0026", "&", $map[1]);
					$formats = explode("url=", $map[1]);
					$highest = 0;
					foreach ($formats as $format) {
						$format = preg_replace("#&itag=([0-9]+)(,|$)#isU", "", $format);
						preg_match("#&itag=(18|22)#isU", $format, $fmt);
						if ($fmt[1] > $highest) {
							$highest = $fmt[1];
							$url = $format;
						}
					}
					
					if (!$url) continue;
					$url = str_replace(" ", "%20", $url);
					$curl = new curl($url);

					$id = createId(4, "lists_song", "rawfile");
					$file = fopen($_base."/media/".$id, "w+");
					$curl->downloadToFile($file);
					$curl->close();
					fclose($file);

					$_db->query('UPDATE lists_song SET file = ? WHERE id = ?', array($id, $song['id']));
				}
			}	
		}
	
	break;
	
	case "convert":
		$result = $_db->query('SELECT id, file, start FROM lists_song WHERE file != "" AND processed = ""');
		while ($song = $result->fetch()) {
			// convert
			$id = createId(6, "lists_song", "processed").".mp3";
			exec("ffmpeg -i \"".$_base."/media/".$song['file']."\" -y -ab 192k -t 35 -ss 00:".$song['start']." ".$_base."/media/".$id);
			
			$_db->query('UPDATE lists_song SET processed = ? WHERE id = ?', array($id, $song['id']));
		}
		
	break;
}

?>