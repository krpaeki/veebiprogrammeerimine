<?php
	class Test{
		private $tempName;
		private $imageFileType;
		private $myTempImage;
		private $myImage;
	
	
		function __construct($tmpPic, $type){
			$this->tempName = $tmpPic;
			$this->imageFileType = $type;
			$this->createImageFromFile;
		}
		
		function __destruct(){
			$this->tempName = $tmpPic;
			$this->imageFileType = $type;
			$this->createImageFromFile;
		}
	
		private function createImageFromFile(){
			if($this->imageFileType == "jpg" or $imageFileType == "jpeg"){
				$this->myTempImage = imagecreatefromjpeg($this->tempName);
			}
			if($this->imageFileType == "png"){
				$this->$myTempImage = imagecreatefrompng($this->tempName);
			}
			if($this->imageFileType == "gif"){
				$this->$myTempImage = imagecreatefromgif($this->tempName);
			}
		}
		
		public function resizeImage($width, $height){
			//vaatame pildi originaalsuuruse
			$imageWidth = imagesx($this->myTempImage);
			$imageHeight = imagesy($this->$myTempImage);
			//leian vajaliku suurendusfaktori
			if($imageWidth > $imageHeight){
				$sizeRatio = $imageWidth / 600;
			} else {
				$sizeRatio = $imageHeight / 400;
			}
				
			$newWidth = round($imageWidth / $sizeRatio);
			$newHeight = round($imageHeight / $sizeRatio);
			$this->myImage = $this->changePicSize($this->myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);
		}
		
		private function changePicSize($image, $ow, $oh, $w, $h){
			$newImage = imagecreatetruecolor($w, $h);
			imagecopyresampled($newImage, $image, 0, 0 , 0, 0, $w, $h, $ow, $oh);
			return $newImage;
		}
		
		public function addWatermark(){
			//lisame vesimärgi
			$waterMark = imagecreatefrompng("../vp_picfiles/vp_logo_color_w100_overlay.png");
			$waterMarkWidth = imagesx($waterMark);
			$waterMarkHeight = imagesy($waterMark);
			$waterMarkPosX = imagesx($this->newWidth) - $waterMarkWidth - 10;
			$waterMarkPosY = imagesy($this->newHeight) - $waterMarkHeight - 10;
			//kopeerin vesimärgi pikslid pildile
			imagecopy($this->myImage, $waterMark, $waterMarkPosX, $waterMarkPosY, 0, 0, $waterMarkWidth, $waterMarkHeight);
		}
		
		public function addText(){
			//filename to tekst
			$textToImage = "Veebiprogrammeerimine";
			$textColor = imagecolorallocatealpha($myImage, 255,255,255, 60);
			//alpha 0 ... 127
			imagettftext($this->myImage, 20, 0, 10, 25, $textColor, "../vp_picfiles/ALGER.TTF", $textToImage);
		}
		
		public function savePhoto($targetDir){
			$notice = "";
			//muudetud suurusega pilt kirjutatakse pildifailiks
			if($this->imageFileType == "jpg" or $imageFileType == "jpeg"){
			  if(imagejpeg($this->myImage, $targetFile, 90)){
				$notice = 1;
			  } else {
				$notice = 0;
			  }
			}
			
			if($imageFileType == "png"){
			  if(imagepng($this->myImage, $targetFile, 6)){
				$notice = 1;
				//kui pilt salvestati siis lisame andmebaasi
				//addPhotoData($target_file_name, $_POST["altText"], $_POST["privacy"]);
			  } else {
				$notice = 0;
			  }
			}
			
			if($imageFileType == "gif"){
			  if(imagegif($this->myImage, $targetFile)){
				$notice = 1;
				//kui pilt salvestati siis lisame andmebaasi
				//addPhotoData($target_file_name, $_POST["altText"], $_POST["privacy"]);
			  } else {
				$notice = 0;
			  }
			}
		}
		
	}
?>