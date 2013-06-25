<?php

/**
 * Description of Image
 * This class acts as a model and a viewmodel
 *
 * @author mafonso
 */
class Image extends Link {
    
    /**
     * Image source path (only the basename)
     * @var string
     */
    public $src = '';
    
    /**
     * Text representation of the image
     * @var string
     */
    public $alt = '';
    
    /**
     * This tells if the $src path is relative or not
     * @var boolean
     */
    public $rel_path;
    
    /**
     * Creates a new image
     * @param string $src
     * @param boolean $rel_path
     * @param string $alt
     */
    public function __construct($src = '#', $rel_path = true, $alt = '') {
        parent::__construct();
        $this->src = $src;
        $this->rel_path = $rel_path;
        $this->alt = $alt;
    }
    
    /**
     * Helper to convert this image to an HTML img tag
     * @return type
     */
    public function html($alt = '', $title = '') {
        $alt = !empty($alt) ? $alt : $this->alt;
        $title = !empty($title) ? $title : empty($this->title) ? $alt : $this->title;
        $src = (string) $this;
        return "<img itemprop=\"contentURL\" src=\"$src\" title=\"$title\" alt=\"$alt\" />";
    }
    
    /**
     * Helper to upload this image
     * @param array $file Collected server upload information
     * @return boolean
     */
    static function upload($file) {
        if ($file['error']) return false;
        $destination = DATAPATH.'/'.$file['name'];
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            self::createThumb($destination);
            self::createThumb($destination, 280);
            return $file['name'];
        }
        return false;
    }
    
    static function createThumb($filename, $thumbSize = 60) {

        // Get image information
        list($width, $height, $type) = getimagesize($filename);
        
        // Choose image type
        switch ($type) {
            case 1: $imgcreatefrom = "ImageCreateFromGIF"; break;
            case 3: $imgcreatefrom = "ImageCreateFromPNG"; break;
            default: $imgcreatefrom = "ImageCreateFromJPEG";
        }

        // Load image
        $myImage = $imgcreatefrom($filename) or die("Error: Cannot find image!"); 

        // Find purpotion
        if ($width > $height) {
            $biggestSide = $width;
            $cropPercent = $width > 560 ? 0.5 : $height / $width;
        }
        else {
            $biggestSide = $height; 
            $cropPercent = $height > 560 ? 0.5 : $width / $height;
        }
        $cropWidth   = $biggestSide*$cropPercent; 
        $cropHeight  = $biggestSide*$cropPercent; 

        // Getting the top left coordinate
        $x = ($width-$cropWidth)/2;
        $y = ($height-$cropHeight)/2;
        
        // Create new image
        $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
        
        // replace alpha with color
        $white = imagecolorallocate($thumb,  255, 255, 255);
        imagefilledrectangle($thumb, 0, 0, $thumbSize, $thumbSize, $white);

        // Copy into new image
        imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $cropWidth, $cropHeight); 

        // generate thumb name and save image
        imagejpeg($thumb, self::generateThumbPath(basename($filename), $thumbSize), 90);
    }
    
    /**
     * Generate and save thumb image
     * @param string $filename
     * @param int $size
     * @param string $ext
     * @return string
     */
    static function generateThumbPath($filename, $size = 60, $ext = 'jpg') {
        $filename = str_replace(array('png', 'jpeg'), 'jpg', $filename);
        return DATAPATH.'/thumb_'.$size.'_'.$filename;
    }
    
    /**
     * Return image URL
     * @return string
     */
    public function getUrl() {
        return DATAURL.'/'.$this->src;
    }
    
    /**
     * Return thumb url
     * @param int $size
     * @return string
     */
    public function getThumbUrl($size = 60) {
        $filename = str_replace(array('png', 'jpeg'), 'jpg', $this->src);
        if (!file_exists(DATAPATH.'/thumb_'.$size.'_'.$filename)) return $this->getUrl();
        return DATAURL.'/thumb_'.$size.'_'.$filename;
    }
    
    /**
     * Magic method to return a string representation of this image path
     * @return string
     */
    public function __toString() {
        if (!$this->rel_path) return $this->src;
        return DATAURL.'/'.$this->src;
    }
    
}

?>
