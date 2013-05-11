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
    
    /**
     * This holds the content data
     * @var Content
     */
    public $content;
    
    public function __construct() {
        parent::__construct('content_form');
        
        // Load idioms
        $this->loadIdioms();
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
    
    /**
     * Load content to be edit
     * @param Content $content
     */
    public function edit($content) {
        if (is_object($content->author)) $content->author = $content->author->username;
        $this->content = $content;
    }
}

?>
