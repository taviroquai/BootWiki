<?php

/**
 * Description of Link
 *
 * @author mafonso
 */
class Link {
    
    public $href = '';
    public $html = '';
    public $class = '';
    public $title = '';
    public $publish = 1;
    
    /**
     * Creates a new Link
     * @param string $href
     * @param string $html
     * @param string $class
     * @param string $title
     */
    public function __construct($href = '#', $html = 'more...', $class = '', $title = '') {
        $this->href = $href;
        $this->html = $html;
        $this->class = $class;
        $this->title = $title;
    }
    
    /**
     * Helper to import RedBean_OODBBean objects
     * @param RebBean_OODBBean $bean
     */
    public function importBean($bean) {
        $vars = get_class_vars(get_class($this));
        foreach ($vars as $k => $item) {
            if (!is_object($this->$k) && isset($bean->$k)) {
                $this->$k = $bean->$k;
            }
        }
    }
    
    /**
     * Helper to export this Link to a bean
     * @param RedBean_OODBBean $bean
     * @return RedBean_OODBBean
     */
    public function exportToBean($bean) {
        $vars = get_class_vars(get_class($this));
        foreach ($vars as $k => $item) {
            if (!is_object($this->$k)) {
                $bean->$k = $this->$k;
            }
        }
        return $bean;
    }
    
    /**
     * Magic methid to return an HTML representation of this object
     * @return type
     */
    public function __toString() {
        if (is_string($this->html)) return $this->html;
        else return $this->html->html();
    }
    
}

?>
