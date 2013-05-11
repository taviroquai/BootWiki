<?php

/**
 * Description of Results
 * This class acts like a model and a viewmodel
 *
 * @author mafonso
 */
use RedBean_Facade as R;

class Results extends Block {
    
    /**
     * Result items
     * @var type 
     */
    public $items = array();
    
    /**
     * Creates a new Result
     */
    public function __construct() {
        parent::__construct('search_results');
    }
    
    /**
     * Tries to find content that matches the input query
     * @param string $query
     */
    public function find($query) {
        $q = implode('%', explode(' ', $query));
        $sql = 'SELECT content.* FROM content JOIN idiom ON content.idiom_id = idiom.id
            WHERE idiom.code = ? AND content.publish = 1 
                AND (
                    content.alias like (?) 
                    OR content.title like (?)
                    OR content.description like (?)
                    OR content.intro like (?)
                    OR content.html like (?)
                    )
            ORDER BY visits DESC LIMIT 5';
        
        // Prepare values and run query
        $q = "%$q%";
        $rows = R::getAll($sql, array(BootWiki::getIdiom(), $q, $q, $q, $q, $q));
        $results = R::convertToBeans('content', $rows);
        if (!empty($results)) {
            foreach ($results as $item) {
                $content = new Content($item->alias);
                $content->importBean($item);
                $this->items[] = $content;
            }
        }
    }
}

?>
