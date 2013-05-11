<?php

/**
 * Description of Content
 * This class acts as a model and a viewmodel
 * It deals with database operations and UI transformations
 *
 * @author mafonso
 */
use RedBean_Facade as R;

class Content extends Link {
    
    public $alias = '';
    public $description = 'Description';
    public $keywords = 'keyword';
    public $author = '';
    public $image = '';
    public $date = '';
    public $intro = '';
    public $featured = 0;
    public $visits = 0;
    public $category;
    public $idiom;
    public $more_link;
    
    /**
     * Creates a new Content
     * @param string $title
     * @param string $html
     */
    public function __construct($title = 'Title', $html = '<p>Hello world!</p>') {
        $this->title = $title;
        $this->alias = self::createAlias($title);
        $this->html = $html;
        $this->date = date('Y-m-d');
        $this->more_link = new Link();
        $this->image = new Image('logo.png');
        $this->idiom = new Idiom();
        $this->intro = '<p>Intro...</p>';
    }
    
    /**
     * This static class only creates an alias based on a string
     * It transforms a string or frase into an usable URI string
     * 
     * @param string $str
     * @param array $replace
     * @param string $delimiter
     * @return string
     */
    public static function createAlias($str, $replace=array(), $delimiter='-') {
        setlocale(LC_ALL, 'en_US.UTF8');
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        return $clean;
    }
    
    /**
     * This will allow to import RedBean OODBBean objects
     * @param RedBean_OODBBean $bean
     */
    public function importBean($bean) {
        parent::importBean($bean);
        if ($bean->image) $this->image = new Image($bean->image);
        $idiom = $bean->idiom;
        $this->idiom = new Idiom();
        $this->idiom->importBean($idiom);
    }
    
    /**
     * This will do the inverse operation
     * It receives a bean and returns the bean with the current data
     * 
     * @param RedBean_OODBBean $bean
     * @return RedBean_OODBBean
     */
    public function exportToBean($bean) {
        $bean = parent::exportToBean($bean);
        $bean->image = $this->image->src;
        $bean->idiom = R::findOne('idiom', 'code = ?', array($this->idiom->code));
        return $bean;
    }
    
    /**
     * Converts the keywords splited by spaces to a string of keywords ready to
     * serve the html meta tag for keywords
     * @return string
     */
    public function keywordsToLabels() {
        $keywords = explode(' ', $this->keywords);
        $out = array();
        foreach ($keywords as $item) {
            $out[] = '<span class="label label-important">'.$item.'</span>';
        }
        return implode(' ', $out);
    }
    
    /**
     * Magic method to convert to string
     * @return string
     */
    public function __toString() {
        return $this->title;
    }
    
}

?>
