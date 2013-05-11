<?php

/**
 * Description of Detail
 * This class acts as a view model for Content Detail
 *
 * @author mafonso
 */
class Detail extends Block {
    
    /**
     * This holds the content data
     * @var Content
     */
    public $content;
    
    public function __construct() {
        parent::__construct('content');
    }
    
    /**
     * Loads Content based on unique alias
     * @param string $alias
     * @return boolean
     */
    public function visit($content) {
        
        // Add visit
        $content->addVisits();
        $content->save();
        
        // Load versions
        $this->versions = $content->loadVersions();
        
        // set content
        $this->content = $content;
        
        return true;
    }
}

?>
