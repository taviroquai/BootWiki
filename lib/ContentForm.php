<?php

/**
 * Description of ContentForm
 * This class acts as a model and a viewmodel
 *
 * @author mafonso
 */
use RedBean_Facade as R;

class ContentForm extends Block {
    
    /**
     * List of idioms to display on the content form
     * @var array
     */
    public $idioms = array();
    
    public function __construct() {
        parent::__construct('content_form');
    }
    
    /**
     * Loads content to the form based on Content alias unique key
     * @param string $alias
     * @return \ContentForm
     */
    public function load($alias) {
        // Try to load content
        $content = R::findOne('content', 'alias = ?', array($alias));
        if (empty($content)) {
            $t = new Content($alias);
            $t->publish = 0;
            $t->author = BootWiki::getLoggedAccount()->displayname;
            $content = $t->exportToBean(R::dispense('content'));
        }
        $this->importBean($content);
        return $this;
    }
    
    /**
     * Saves form data. This method may be moved to elsewhere
     * @param array $post
     * @param array $upload_image
     */
    public function save($post, $upload_image) {
        
        // Import fields (ugly i know)
        $fields = 'title,alias,publish,featured,date,description,keywords,author,intro,html';
        // Find record
        $content = R::findOne('content', 'alias = ?', array($this->alias));
        if (empty($content)) {
            $content = R::dispense('content');
        }
        else {
            // Save last version
            $version = R::dispense('contentversion');
            $version->import($content->export(), $fields);
            $version->date = date('Y-m-d H:i:s');
            $version->content = $content;
            R::store($version);
        }

        // Import changes
        $content->import($post, $fields);
        $content->idiom = R::findOne('idiom', 'code = ?', array($post['idiom']));
        $new_image = Image::upload($upload_image);
        if ($new_image) $content->image = $new_image;

        // Save
        try {
            R::store($content);
        } catch (Exception $e) {
            BootWiki::setMessage($e->getMessage());
        }
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
     * Helper to load all idioms
     */
    public function loadIdioms() {
        $idioms = R::find('idiom');
        foreach ($idioms as $item) {
            $idiom = new Idiom();
            $idiom->importBean($item);
            $this->idioms[] = $idiom;
        }
    }
}

?>
