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
    public function html() {
        $src = (string) $this;
        return "<img itemprop=\"contentURL\" src=\"$src\" title=\"$this->title\" alt=\"$this->alt\" />";
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
            return $file['name'];
        }
        return false;
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
