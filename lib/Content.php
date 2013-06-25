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
    
    /**
     * Main content image
     * @var Image
     */
    public $image = '';
    public $date = '';
    public $intro = '';
    public $featured = 0;
    public $visits = 0;
    public $category;
    
    /**
     * Content idiom
     * @var Idiom
     */
    public $idiom;
    
    /**
     *
     * @var Link
     */
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
        $this->image = new Image('collab.png');
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
     * Loads content to the form based on Content alias unique key
     * @param string $alias
     * @return \ContentForm
     */
    public function load($alias, $create = false) {
        // Try to load content
        $content = R::findOne('content', 'alias = ?', array($alias));
        if (empty($content) && $create) {
            $content = R::dispense('content');
            if (BootWiki::getLoggedAccount()) {
                $this->author = BootWiki::getLoggedAccount()->username;
            }
        }
        if (!$content) return false;
        $this->importBean($content);
        return $this;
    }
        
    /**
     * Loads content to the form based on a Content version
     * @param int $version_id
     * @return boolean|\ContentForm
     */
    public function loadVersion($version_id) {
        
        // Try to load content
        $version = R::findOne('contentversion', 'id = ?', array($version_id));
        if (empty($version)) return false;
            
        $this->importBean($version);
        $this->date = reset(explode(' ', $this->date));
        return $this;
    }
    
    /**
     * Adds visits to this content
     * @param int $quantity
     */
    public function addVisits($quantity = 1) {
        // Update visits
        $this->visits = $this->visits + $quantity;
    }
    
    /**
     * Load content versions
     * @return array
     */
    public function loadVersions() {
        $bean = R::findOne('content', 'alias = ?', array($this->alias));
        if (empty($bean)) return array();
        return R::find('contentversion', '1 AND content_id = ?', array($bean->id));
    }
    
    /**
     * Saves form data
     * @param array $post
     * @param array $upload_image
     */
    public function savePost($post, $upload_image) {
        
        // Import fields (ugly i know)
        $fields = 'title,alias,publish,featured,date,description,keywords,author,intro,html,visits';
        // Find record
        $bean = R::findOne('content', 'alias = ?', array($this->alias));
        if (empty($bean)) {
            $bean = R::dispense('content');
        }
        else {
            // Save last version
            $version = R::dispense('contentversion');
            $version->import($bean->export(), $fields);
            $version->date = date('Y-m-d H:i:s');
            $version->content = $bean;
            R::store($version);
        }

        // Import changes
        $bean->import($post, $fields);
        $bean->idiom = R::findOne('idiom', 'code = ?', array($post['idiom']));
        $new_image = Image::upload($upload_image);
        if ($new_image) $bean->image = $new_image;

        // Save
        try {
            R::store($bean);
            $this->importBean($bean);
        } catch (Exception $e) {
            BootWiki::setMessage($e->getMessage());
        }
    }
    
    /**
     * Uses database to save current data
     */
    public function save() {
        $bean = R::findOne('content', 'alias = ?', array($this->alias));
        $bean = $this->exportToBean($bean);
        return R::store($bean);
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
        
        // load author
        $result = R::findOne('account', 'username = ?', array($this->author));
        if (!empty($result)) {
            $author = new Account();
            $author->importBean($result);
            $this->author = $author;
        }
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
     * Return costumized keywords using a splitter
     * @param string $splitter
     * @return string
     */
    public function getKeywords($splitter = ',') {
        return implode($splitter, explode(' ', $this->keywords));
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
