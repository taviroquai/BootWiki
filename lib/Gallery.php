<?php

/**
 * Description of Gallery
 * This class acts like a model and a viewmodel
 *
 * @author mafonso
 */
class Gallery extends Block {
    
    /**
     * Result items
     * @var type 
     */
    public $items = array();
    
    /**
     * Creates a new Result
     */
    public function __construct() {
        parent::__construct('gallery');
    }
    
    /**
     * Returns all available imagens in data folder
     */
    public function loadFolder($path) {
        
        $result = glob($path.'/{*.jpg,*.gif,*.png}', GLOB_BRACE);
        if (!empty($result)) {
            foreach ($result as $item) {
                $image = new Image($item);
                $this->items[] = $image;
            }
        }
    }
}

?>
