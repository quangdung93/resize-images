<?php 
@ini_set('display_errors', 1);
@ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
@ini_set('max_execution_time', 300);
require_once('../php_image_magician.php');

/*
* Hàm resize tất cả ảnh có trong folder
* $image_path : đường dẫn bao gồm tên ảnh
* $new_image_path : đường dẫn ảnh mới sau khi resize
* $width: chiều rộng ảnh muốn cắt
* $width : chiều cao ảnh muốn cắt
* $size_sort = 0 KB : kích thước ảnh muốn lọc ra từ folder - đơn vị tính KB (mặc định lọc ảnh lớn hơn 0 byte)
*/

function resizeAllImagesToPath($image_path, $new_image_path, $width, $height, $size_sort = 0){

	$directory = $image_path;
	$images = glob($directory . "/*.{jpg,png,jpeg,JPG,PNG,JPEG}", GLOB_BRACE);
	$number = 0;
	foreach($images as $image)
	{
		try{
			$magicianObj = new imageLib($image);
		  	$size = filesize($image); 
		  	$size = (int)$size/1024;//Convert to KB
		  	$size_kb = number_format($size,0) . " KB";

		  	if($size > $size_sort){
		  		$new_image = str_replace($image_path,$new_image_path,$image);
		  		$magicianObj->resizeImage($width, $height, 'portrait', true);
		  		$magicianObj->saveImage($new_image, 100);
		  		echo $new_image.'<br>';
		  		$number ++;
		  	}
		}
		catch (Exception $e) {
	        echo $e->getMessage();
		}
	  	
	  	
	}
	echo "Resize Completed!. ".$number." images";
}


// function imageRotateCompress($filename) {

// 	$image = imagecreatefromjpeg($filename);
// 	$exif = exif_read_data($filename);

// 	if (!empty($exif['Orientation'])) {
// 		switch ($exif['Orientation']) {
// 			case 3:
// 			$image = imagerotate($image, 180, 0);
// 			break;

// 			case 6:
// 			$image = imagerotate($image, -90, 0);
// 			break;

// 			case 8:
// 			$image = imagerotate($image, 90, 0);
// 			break;
// 		}
// 	}
// 	imagejpeg($image, $filename);
// }

resizeAllImagesToPath('sample_images/compress','sample_images/compress/output',360,360);
// imageRotateCompress('sample_images/compress/04-37-22-868-20190417_054423.jpg');


