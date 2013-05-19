<?php

/*
 * Load configuration
 */
require_once 'config.php';

/*
 * Load libraries
 */
require 'vendor/autoload.php';
require_once 'lib/Link.php';
require_once 'lib/BootWiki.php';
require_once 'lib/Idiom.php';
require_once 'lib/Image.php';
require_once 'lib/Content.php';
require_once 'lib/Block.php';
require_once 'lib/Gallery.php';
require_once 'lib/Account.php';
require_once 'lib/Results.php';
require_once 'lib/Detail.php';
require_once 'lib/ContentForm.php';
require_once 'lib/Layout.php';

/*
 * Initialize application
 */
BootWiki::init();
$app = new \Slim\Slim();

/*
 * Install demo data
 */
$app->get('/install', function () use ($app) {
    BootWiki::install();
    $app->redirect(BASEURL);
});

/*
 * Homepage
 */
$app->get('/', function () use ($app) {
    
    // Define content
    $main = new Content('', '');
    
    // Load layout
    $layout = new Layout($main);
    $layout->loadRecent();
    $layout->loadPopular();
    $layout->loadFeatured();
    
    // Output layout
    $app->response()->body((string)$layout);
});

/*
 * Change idiom
 */
$app->get('/idiom/:idiom', function ($idiom) use ($app) {
    BootWiki::setIdiom($idiom);
    $app->redirect(BASEURL);
});

/*
 * Display search results
 */
$app->get('/search', function () use ($app) {
    
    // load query
    $q = $app->request()->get('q');
    
    // Process results
    $main = new Results();
    $main->find($q);
    
    // Load layout
    $layout = new Layout($main);
    $layout->loadRecent();
    $layout->loadPopular();
    $layout->query = $q;
    
    // Print layout
    $app->response()->body((string)$layout);
});

/*
 * Display content
 */
$app->get('/:alias', function ($alias) use ($app) {
    
    $content = new Content();
    $content = $content->load($alias);
    if (!$content) {
        if (BootWiki::getLoggedAccount() == null) {
            $app->redirect(BASEURL.'/mod/404');
        }
        else {
            $alias = Content::createAlias($alias);
            $app->redirect(BASEURL.'/edit/'.$alias);
        }
    }
    
    // Load content
    $main = new Detail();
    $main->visit($content); 
    
    // Load layout
    $layout = new Layout($main);
    $layout->loadRecent();
    $layout->loadPopular();
    
    // Add SEO
    $layout->title = $main->content->title;
    $layout->description = $main->content->description;
    $layout->keywords = implode(',', explode(' ', $main->content->keywords));
    $layout->author = $main->content->author;
    
    // Print layout
    $app->response()->body((string)$layout);
});

/*
 * Display 404 not found content
 */
$app->get('/mod/404', function () use ($app) {
    
    // Load content
    $main = new Block('404');
    
    // Load layout
    $layout = new Layout($main);
    $layout->loadRecent();
    $layout->loadPopular();
    
    // Print layout
    $app->response()->body((string)$layout);
});

/*
 * Display content form
 */
$app->get('/edit/:alias(/:version)', function ($alias, $version_id = null) use ($app) {
    
    // redirect if not logged
    if (BootWiki::getLoggedAccount() == null) $app->redirect(BASEURL);
    
    // Define content
    $content = new Content($alias);
    if (!empty($version_id)) $content->loadVersion ($version_id);
    else $content->load($alias, true);
    
    // Set up form
    $form = new ContentForm();
    $form->edit($content);
    
    // Load layout
    $layout = new Layout($form);
    $layout->loadRecent();
    $layout->loadPopular();
    $layout->loadUnpublished();
    
    // Print layout
    $app->response()->body((string)$layout);
});

/*
 * Save content edition
 */
$app->post('/edit/:alias', function ($alias) use ($app) {
    
    // redirect if not logged
    if (BootWiki::getLoggedAccount() == null) $app->redirect(BASEURL);

    // load content to edit
    $content = new Content();
    $content->load($alias, TRUE);
    $content->savePost($_POST['content'], $_FILES['upload_image']);
    
    // Load form
    $form = new ContentForm();
    $form->edit($content);
    
    // Load layout
    $layout = new Layout($form);
    $layout->loadRecent();
    $layout->loadPopular();
    $layout->loadUnpublished();
    
    // Print layout
    $app->response()->body((string)$layout);
});

/*
 * Display login form
 */
$app->get('/mod/auth', function () use ($app) {
    
    // Load authentication form
    $main = new Block('auth_form');
    
    // Load layout
    $layout = new Layout($main);
    $layout->loadRecent();
    $layout->loadPopular();
    $layout->title = TITLE . ' - ' . 'Login';
    
    // Print layout
    $app->response()->body((string)$layout);
});

/*
 * Process login
 */
$app->post('/mod/auth', function () use ($app) {
    
    // Process login
    $post = $app->request()->post();
    $result = BootWiki::login($post['username'], $post['password']);
    
    // Apply redirects
    if ($result) $app->redirect(BASEURL);
    else $app->redirect(BASEURL.'/mod/auth');
});

/*
 * Display register form
 */
$app->get('/mod/register', function () use ($app) {
    
    // Redirect unauthorized
    if (!REGISTER_ALLOWED || BootWiki::getLoggedAccount() != null) {
        $app->redirect(BASEURL);
    }
    
    // Load registration form
    $main = new Block('register_form');
    
    // Load layout
    $layout = new Layout($main);
    $layout->loadRecent();
    $layout->loadPopular();
    $layout->title = TITLE . ' - ' . 'Register';
    
    // Print layout
    $app->response()->body((string)$layout);
});

/*
 * Process register
 */
$app->post('/mod/register', function () use ($app) {
    
    // Redirect unauthorized
    if (!REGISTER_ALLOWED || BootWiki::getLoggedAccount() != null) {
        $app->redirect(BASEURL);
    }
    
    // Process login
    $main = new Account();
    $result = $main->create($app->request()->post());
    if (!$result) {
        // Load registration form
        $main = new Block('register_form');
    }
    else {
        // Load register done template
        $main = new Block('register_done');
    }
    
    // Load layout
    $layout = new Layout($main);
    $layout->loadRecent();
    $layout->loadPopular();

    // Print layout
    $app->response()->body((string)$layout);

});

/*
 * Display my account page
 */
$app->get('/mod/myaccount', function () use ($app) {
    
    // redirect if not logged
    if (BootWiki::getLoggedAccount() == null) $app->redirect(BASEURL);
    
    // Load authentication form
    $main = new Block('changepw_form');
    
    // Load layout
    $layout = new Layout($main);
    $layout->loadRecent();
    $layout->loadPopular();
    
    // Print layout
    $app->response()->body((string)$layout);
});

/*
 * Process change password
 */
$app->post('/mod/myaccount', function () use ($app) {
    
    // redirect if not logged
    if (BootWiki::getLoggedAccount() == null) $app->redirect(BASEURL);
    
    // Process login
    $main = new Account();
    $main->changePassword($app->request()->post());
    
    // Apply redirects
    $app->redirect(BASEURL.'/mod/myaccount');
    
});

/*
 * Process logout
 */
$app->get('/mod/auth/logout', function () use ($app) {
    
    // Process logout
    BootWiki::logout();
    $app->redirect(BASEURL);
});

/*
 * Load image gallery
 */
$app->get('/mod/gallery', function () use ($app) {
    
    // Create Gallery
    $gallery = new Gallery();
    $gallery->load();
    
    // Print layout
    $app->response()->body((string)$gallery);
});

/*
 * File downloader
 */
$app->get('/mod/download/:ref', function ($ref) use ($app) {
    
    // Transform reference to path
    $filename = str_replace('-', '/', $ref);
    
    // Validate file path; should be in DATAPATH directory
    $real = realpath(DATAPATH.'/'.$filename);
    if (empty($real)) {
        $app->redirect(BASEURL.'/mod/404');
    }
    if (substr($real, 0, count(DATAPATH)) != DATAPATH) {
        $app->redirect(BASEURL);
    }
    
    // Create file download block
    $main = new Block('download');
    $main->href = DATAURL.'/'.$filename;
    
    // Load layout
    $layout = new Layout($main);
    $layout->loadRecent();
    $layout->loadPopular();
    
    // Print layout
    $app->response()->body((string)$layout);
});

/*
 * Finally, run application
 */
$app->run();