<?php

/**
 * Description of Idiom
 * This class wraps an idiom string representation
 * Also allows to easily creates links to change idiom
 *
 * @author mafonso
 */
class Idiom extends Link {
    
    public $code = '';
    public $name = '';
    public $flag_image = '';
    
    /**
     * Creates a new idiom link
     * @param string $code
     * @param string $name
     * @param string $flag_image
     */
    public function __construct($code = 'en', $name = 'English', $flag_image = '') {
        $this->code = $code;
        $this->name = $name;
        $this->flag_image = $flag_image;
    }
    
    /**
     * Returns html image representation of the idiom
     * @return string
     */
    public function html() {
        $img = new Image(BASEURL.'/'.$this->flag_image, false, $this->name);
        return $img->html();
    }
    
    /**
     * Returns this idiom hiperlink reference
     * @return string
     */
    public function href() {
        return BASEURL.'/idiom/'.$this->code;
    }
    
    /**
     * Magic method to convert this object to string
     * @return string
     */
    public function __toString() {
        return $this->name;
    }
    
}

?>
