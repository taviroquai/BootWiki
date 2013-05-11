<?php

/**
 * Description of Block
 *
 * @author mafonso
 */

class Block extends Content {
    
    /**
     * This will hold the full path to template file
     * @var string
     */
    public $template_path;
    
    /**
     * Creates a new Block
     * @param string $template_name
     * @param string $html It may hold a sub-content
     */
    public function __construct($template_name, $html = '') {
        $this->template_path = BootWiki::template($template_name);
        $this->html = $html;
    }
    
    /**
     * Magic method to convert to an HTML string
     * @return string
     */
    public function __toString() {
        try {
            ob_start();
            include_once $this->template_path;
            return ob_get_clean();
        } catch (Exception $e) {
            return 'UNEXPECTED ERROR: '.$e->getMessage();
        }
    }
}

?>
