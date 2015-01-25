<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# blog: http://ogp.me/ns/blog#">
  <head>
    <meta charset="utf-8">
    <title><?=$this->title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:description" name="description" content="<?=$this->description?>">
    <meta name="twitter:description" content="<?=$this->description?>">
    <meta name="keywords" content="<?=$this->keywords?>">
    <?php if (is_object($this->author)) : ?>
    <meta property="article:author" name="author" content="<?=$this->author->username?>">
    <?php else: ?>
    <meta property="article:author" name="author" content="<?=$this->author?>">
    <?php endif; ?>
    <meta name="twitter:creator" content="<?=$this->author?>">
    <meta name="twitter:card" content="summary">
    <meta property="og:type" content="article" /> 
    <meta property="og:title" name="twitter:title" content="<?=$this->title?>" />
    <?php if (!empty($this->main_image)) { ?>
    <meta property="og:image" name="twitter:image" content="<?=implode('', BootWiki::parseRoute())?><?=$this->main_image?>" />
    <link href="<?=$this->main_image?>" rel="image_src">
    <?php } ?>
    <base href="<?=BASEURL?>/">

    <!-- Bootstrap core CSS -->
    <link href="web/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="web/css/dashboard.css" rel="stylesheet">
    <link href="web/bootstrap-fileupload/bootstrap-fileupload.min.css" rel="stylesheet">

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="web/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="web/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="web/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="web/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="web/ico/favicon.png">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Badass jQuery -->
    <script src="web/js/jquery.min.js"></script>
  </head>

  <body itemscope itemtype="http://schema.org/WebPage">

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?=BASEURL?>">
            <span itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
                <img itemprop="contentURL" src="<?=ORGANIZATION_LOGO?>" alt="<?=$this->organization_name?>" title="<?=$this->organization_name?>" />
            </span>
            <meta itemprop="name" content="<?=$this->organization_name?>">
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <p class="navbar-text pull-right">
              <?php if (!empty($this->idioms)) {?>
                  <?php foreach ($this->idioms as $item) { ?>
                      <a class="navbar-link" href="<?=$item->href()?>">
                        <?=$item->html()?>
                      </a>
                  <?php } ?>
              <?php } ?>
              
              <?php if (!empty($this->logged_username)) : ?>
                  Logged in as <a href="<?=BASEURL.'/mod/myaccount'?>" class="navbar-link"><?=$this->logged_username?></a>&nbsp;
                  <a href="<?=$this->logout_link->href?>" class="navbar-link">Logout</a>
              <?php else: ?>
                  <a href="<?=$this->login_link->href?>" class="navbar-link">Login</a>
                  <?php if (REGISTER_ALLOWED) { ?>
                      <a href="<?=$this->register_link->href?>" class="navbar-link">Register</a>
                  <?php } ?>
              <?php endif; ?>
              
          </p>
          <ul class="nav navbar-nav navbar-right">
            <?php foreach ($this->top_menu as $item) { ?>
            <li<?php if (!empty($item->class)) {?> class="<?=$item->class?>"<?php } ?>>
                <a href="<?=$item->href?>"><?=$item?></a>
            </li>
            <?php } ?>
          </ul>
          <form class="navbar-form navbar-right" action="search">
            <input type="text" class="form-control" name="q" placeholder="Search..."
              value="<?=empty($this->query) ? '' : $this->query?>">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-3 sidebar">

          <?php if (!empty($this->recent)) { ?>
          <ul class="nav nav-sidebar">
            <li class="nav-header">Recent...</li>
            <?php foreach ($this->recent as $item) { ?>
              <li<?php if (!empty($item->class)) {?> class="<?=$item->class?>"<?php } ?>>
                  <a href="<?=$item->href?>"><?=$item?> <span class="label label-warning"><?=date(DATE_FORMAT, strtotime($item->date))?></span></a>
              </li>
            <?php } ?>
          </ul>
          <?php } ?>

          <?php if (!empty($this->popular)) { ?>
          <ul class="nav nav-sidebar">
            <li class="nav-header">Most popular...</li>
            <?php foreach ($this->popular as $item) { ?>
              <li<?php if (!empty($item->class)) {?> class="<?=$item->class?>"<?php } ?>>
                  <a href="<?=$item->href?>"><?=$item?> <span class="badge badge-info"><?=(int)$item->visits?></span></a>
              </li>
            <?php } ?>
          </ul>
          <?php } ?>

          <?php if (!empty($this->unpublished)) { ?>
          <ul class="nav nav-sidebar">
            <li class="nav-header">Unpublished...</li>
            <?php foreach ($this->unpublished as $item) { ?>
              <li<?php if (!empty($item->class)) {?> class="<?=$item->class?>"<?php } ?>>
                  <a href="<?=$item->href?>"><?=$item?></a>
              </li>
            <?php } ?>
          </ul>
          <?php } ?>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 main">

          <?php if (!empty($this->featured)) { ?>
                <?php $content = reset($this->featured); ?>
          <div class="jumbotron">
            <div class="container">
              <h1><a href="<?=BASEURL.'/'.$content->alias?>"><?=$content->title?></a></h1>
              <img class="media-object wiki-img-featured-big" 
                      src="<?=$content->image->getUrl()?>" alt="<?=$content->title?>" />
              <p><?=$content->intro?></p>

              <div class="clearfix"></div>
              <p>
                  <a href="<?=BASEURL.'/'.$content->alias?>" 
                    class="btn btn-primary btn-lg pull-right"><?=$content->more_link?></a>
                    <?php if (is_object($content->author) && !empty($content->author->profile)) : ?>
                        <a class="pull-right" rel="author" href="<?=$content->author->profile?>" title="<?=$content->author?>">by <?=$content->author?>&nbsp;</a>
                    <?php else: ?>
                        <span class="pull-right"> by <?=$content->author?>&nbsp;</span>
                    <?php endif; ?>
              </p>
            </div>
          </div>
          <?php } ?>

          <?php if (!empty($this->featured) && count($this->featured) > 1) { ?>
          <div class="row">
            <?php for ($i = 1; $i < count($this->featured); $i++) {
              $content = $this->featured[$i];
            ?>
            <div class="col-md-<?=round(12/(count($this->featured)-1))?>">
              <div class="media">
                <div class="media-left">
                  <a href="<?=BASEURL.'/'.$content->alias?>">
                    <img class="media-object" style="max-width:64px;height:auto" src="<?=$content->image->getThumbUrl()?>" alt="<?=$content->title?>">
                  </a>
                </div>
                <div class="media-body">
                  <h4 class="media-heading"><a href="<?=BASEURL.'/'.$content->alias?>"><?=$content->title?></a></h4>
                  <div><?=$content->intro?></div>
                  <p><a class="btn btn-default" href="<?=BASEURL.'/'.$content->alias?>" role="button"><?=$content->more_link?></a></p>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>

          <hr>
          <?php } ?>

          <?php if (!empty($this->html)) { ?>
          <div class="row-fluid">
            <div class="col-md-12">
              <?=$this->html?>
            </div><!--/span-->
          </div><!--/row-->
          <?php } ?>

          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="web/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="web/js/ie10-viewport-bug-workaround.js"></script>
    
    <!-- Include google analytics if exists -->
    <?php if (file_exists(TEMPLATEPATH.'/'.BootWiki::getIdiom().'/ga.php')) {
        include TEMPLATEPATH.'/'.BootWiki::getIdiom().'/ga.php';
    } ?>
  </body>
</html>
