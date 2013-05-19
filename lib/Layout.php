<?php

/**
 * Description of Layout
 * This class acts like a model and viewmodel
 * It helps loading this especific layout
 * For other custom template, you may need to create a completely new Layout class
 *
 * @author mafonso
 */
use RedBean_Facade as R;

class Layout extends Block {
    
    public $logo = 'Wiki';
    public $logged_username = '';
    public $login_link;
    public $logout_link;
    public $idioms = array();
    public $top_menu = array();
    public $categories = array();
    public $recent = array();
    public $popular = array();
    public $unpublished = array();
    public $featured = array();
    
    /**
     * Creates a new Layout
     * @param string $html Sub content
     */
    public function __construct($html = '') {
        parent::__construct('layout', $html);
        
        $this->loadSession();
        $this->addMicrodata();
        $this->loadIdioms();
    }
    
    /**
     * This load session information and creates session links
     */
    public function loadSession() {
        $this->register_link = new Link(BASEURL.'/mod/register', 'Register');
        $this->login_link = new Link(BASEURL.'/mod/auth', 'Login');
        $this->logout_link = new Link(BASEURL.'/mod/auth/logout', 'Logout');
        
        $this->logged_username = BootWiki::getLoggedAccount() == null ? 
                NULL : BootWiki::getLoggedAccount()->username;
    }
    
    /**
     * Adds SEO configuration as default document data
     */
    public function addMicrodata() {
        // Add SEO and Microdata
        $this->title = TITLE;
        $this->description = DESCRIPTION;
        $this->keywords = KEYWORDS;
        $this->author = AUTHOR;
        $this->organization_name = ORGANIZATION_NAME;
        $this->organization_logo = ORGANIZATION_LOGO;
        $this->organization_founder = ORGANIZATION_FOUNDER;
    }
    
    /**
     * This loads idions
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
     * This loads the recent content items
     */
    public function loadRecent() {
        // Load recent
        $sql = 'SELECT content.* FROM content 
            LEFT JOIN idiom ON content.idiom_id = idiom.id
            WHERE idiom.code = ? AND content.publish = 1
            ORDER BY content.date DESC LIMIT 5';
        $rows = R::getAll($sql, array(BootWiki::getIdiom()));
        $beans = R::convertToBeans('content', $rows);
        $recent = array();
        foreach ($beans as $item) {
            $link = new Link(BASEURL.'/'.$item->alias, $item->title);
            $link->date = $item->date;
            $recent[] = $link;
        }
        $this->recent = $recent;
    }
    
    /**
     * This loads the popular content items
     */
    public function loadPopular() {
        // Load popular
        $sql = 'SELECT content.* FROM content 
            LEFT JOIN idiom ON content.idiom_id = idiom.id
            WHERE idiom.code = ? AND content.publish = 1
            ORDER BY visits DESC';
        $rows = R::getAll($sql, array(BootWiki::getIdiom()));
        $beans = R::convertToBeans('content', $rows);
        $items = array();
        foreach ($beans as $item) {
            $link = new Link(BASEURL.'/'.$item->alias, $item->title);
            $link->visits = $item->visits;
            $items[] = $link;
        }
        $this->popular = $items;
    }
    
    /**
     * This loads the featured content items
     */
    public function loadFeatured() {
        // Load featured
        $sql = 'SELECT content.* FROM content 
            LEFT JOIN idiom ON content.idiom_id = idiom.id
            WHERE idiom.code = ? AND content.featured = 1 AND content.publish = 1
            ORDER BY visits DESC LIMIT 4';
        $rows = R::getAll($sql, array(BootWiki::getIdiom()));
        $beans = R::convertToBeans('content', $rows);
        $items = array();
        foreach ($beans as $item) {
            $content = new Content();
            $content->importBean($item);
            $items[] = $content;
        }
        $this->featured = $items;
    }
    
    /**
     * This loads the unpublished content items
     */
    public function loadUnpublished() {
        // Load featured
        $sql = 'SELECT content.* FROM content 
            LEFT JOIN idiom ON content.idiom_id = idiom.id
            WHERE idiom.code = ? AND content.publish = 0';
        $rows = R::getAll($sql, array(BootWiki::getIdiom()));
        $beans = R::convertToBeans('content', $rows);
        $items = array();
        foreach ($beans as $item) {
            $link = new Link(BASEURL.'/'.$item->alias, $item->title);
            $items[] = $link;
        }
        $this->unpublished = $items;
    }
    
    /**
     * This loads all content items
     */
    public function loadAll() {
        // Load featured
        $sql = '
        SELECT content.* FROM content 
        LEFT JOIN idiom ON content.idiom_id = idiom.id
        WHERE idiom.code = ? AND content.featured = 1 AND content.publish = 1';
        
        $rows = R::getAll($sql, array(BootWiki::getIdiom()));
        $beans = R::convertToBeans('content', $rows);
        $featured = array();
        foreach ($beans as $item) {
            $content = new Content();
            $content->importBean($item);
            $featured[] = $content;
        }
        $this->featured = $featured;
    }
    
}

?>
