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
    
    $main = new Detail();
    $result = $main->find($alias);
    if (!$result) {
        if (BootWiki::getLoggedAccount() == null) {
            $main->template_path = BootWiki::template('404');
        }
        else {
            $alias = Content::createAlias($alias);
            $app->redirect(BASEURL.'/edit/'.$alias);
        }
    }
    
    // Load layout
    $layout = new Layout($main);
    $layout->loadRecent();
    $layout->loadPopular();
    
    // Add SEO
    $layout->title = $main->title;
    $layout->description = $main->description;
    $layout->keywords = implode(',', explode(' ', $main->keywords));
    $layout->author = $main->author;
    
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
    $main = new ContentForm();
    $main->loadIdioms();
    if (!empty($version_id)) $main->loadVersion ($version_id);
    else $main->load($alias);
    
    // Load layout
    $layout = new Layout($main);
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

    // Process form
    $form = new ContentForm();
    $form->load($alias);
    $form->save($_POST['content'], $_FILES['upload_image']);
    
    // Redirect to edit
    $app->redirect(BASEURL.'/edit/'.$alias);
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
    
    // Load authentication form
    $main = new Account();
    
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

    // Apply redirects
    if (!$result) $app->redirect(BASEURL.'/mod/register');
    else {
        // Load register done template
        $main->template_path = BootWiki::template('register_done');
        
        // Load layout
        $layout = new Layout($main);
        $layout->loadRecent();
        $layout->loadPopular();

        // Print layout
        $app->response()->body((string)$layout);
    }
});

/*
 * Display my account page
 */
$app->get('/mod/myaccount', function () use ($app) {
    
    // redirect if not logged
    if (BootWiki::getLoggedAccount() == null) $app->redirect(BASEURL);
    
    // Load authentication form
    $main = new Account();
    $main->template_path = BootWiki::template('changepw_form');
    
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
 * Finally, run application
 */
$app->run();