<?php

/**
 * Description of Detail
 * This class acts as a model and a view model for Content Detail
 *
 * @author mafonso
 */
use RedBean_Facade as R;

class Detail extends Block {
    
    public function __construct() {
        parent::__construct('content');
    }
    
    /**
     * Loads Content based on unique alias
     * @param string $alias
     * @return boolean
     */
    public function find($alias) {
        
        // Try to load content
        $content = R::findOne('content', 'alias = ?', array($alias));
        if (empty($content)) return false;

        // Update visits
        $content->visits = $content->visits + 1;
        R::store($content);

        // load data
        $this->importBean($content);
        
        // Load versions
        $this->versions = R::find('contentversion', '1 AND content_id = ?', 
                array($content->id));
        return true;
    }
}

?>
