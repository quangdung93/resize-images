<?php 



function walkDir($path = null) {
    if(empty($path)) {
        $d = new DirectoryIterator(dirname(__FILE__));
    } else {
        $d = new DirectoryIterator($path);
    }

    foreach($d as $f) {
        if($f->isFile() &&  preg_match("/(\.gif|\.png|\.jpe?g)$/", $f->getFilename())){
            $name = $f->getFilename();
            //Get Width & Height
            list($w, $h) = getimagesize($f->getPathname());
            // echo $f->getFilename() . " / Dimensions: " . $w . ' x ' . $h . " / Size: ";
            // Get Size
            $size = filesize($f->getPathname())/1024;
            $size_kb = number_format($size,0) . " KB";

            $image_info = array($name,$w,$h,$size_kb);
            if($size > 1000){
                echo "<pre>";
                var_dump($image_info);
                echo "</pre>";
            }
            
            // echo $img."<br>";
        }elseif($f->isDir() && $f->getFilename() != '.' && $f->getFilename() != '..') {
            walkDir($f->getPathname());
        }
    }
}

walkDir('sample_images');