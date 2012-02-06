<?php
class resize {
	var $sizes = array("medium" => array("w", 150));
	
	function resizepic($pic,$dir,$size) {
		global $_base;
		$format=array("", "gif", "jpeg", "png");
		$file=$_base."gfx/cache/".$dir."/full/".$pic.".jpg";
		$picinfo=getimagesize($file);
		$call="imagecreatefrom".$format[$picinfo[2]];
		if ($this->sizes[$size][0] == "w") {
			if ($picinfo[0]>$this->sizes[$size][1]) {
				$height=intval($picinfo[1]*$this->sizes[$size][1]/$picinfo[0]);
				$width=$this->sizes[$size][1];
			} else {
				$width=$picinfo[0];
				$height=$picinfo[1];
			}
		} else {
			if ($picinfo[1]>$this->sizes[$size][1]) {
				$height=$this->sizes[$size][1];
				$width=intval($picinfo[0]*$this->sizes[$size][1]/$picinfo[1]);
			} else {
				$width=$picinfo[0];
				$height=$picinfo[1];
			}
		}
		$image=$call($file);
		if ($size == "small") {
			if ($picinfo[1] > $picinfo[0]) {
				$picinfo[1]=$picinfo[0];
			} else {
				$picinfo[0]=$picinfo[1];
			}
			$newwidth=$height;
			$newheight=$height;
		} else {
			$newwidth=$width;
			$newheight=$height;
		}
		$newimage=imagecreatetruecolor($newwidth,$newheight);
		imagecopyresampled($newimage,$image,0,0,0,0,$newwidth,$newheight,$picinfo[0],$picinfo[1]);
		imagejpeg($newimage, $_base."gfx/cache/".$dir."/".(($size != "slide") ? $size : "")."/".$pic.".jpg", 100);
		imagedestroy($image);
		imagedestroy($newimage);
	}
	
	function del_pic($dir,$size,$id) {
		global $_base;
		$file=$_base."gfx/cache/".$dir."/".$size."/".$id.".jpg";
		if (file_exists($file)) {
			@unlink($file);
		}
	}
	
}
?>
