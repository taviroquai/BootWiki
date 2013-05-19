<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# blog: http://ogp.me/ns/blog#">
  <head>
    <meta charset="utf-8">
    <title><?=$this->title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$this->description?>">
    <meta name="keywords" content="<?=$this->keywords?>">
    <meta name="author" content="<?=$this->author?>">
    <meta property="og:type" content="article" /> 
    <meta property="og:site_name" content="<?=$this->title?>" />
    <meta property="og:title" content="<?=$this->title?>" />
    <meta property="og:description" content="<?=$this->description?>" />
    <meta property="article:author" content="<?=$this->author?>" />
    <? if (!empty($this->main_image)) { ?>
    <meta property="og:image" content="<?=$this->main_image?>" />
    <link href="<?=$this->main_image?>" rel="image_src">
    <? } ?>
    <base href="<?=BASEURL?>/">

    <!-- Le styles -->
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="web/css/bootstrap.css">
    <link rel="stylesheet" href="web/bootstrap-fileupload/bootstrap-fileupload.min.css">
    <link rel="stylesheet" href="web/css/wiki.css">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    
    <link rel="stylesheet" href="web/css/bootstrap-wysihtml5-0.0.2.css">
    <link rel="stylesheet" href="web/css/bootstrap-responsive.css">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="web/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="web/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="web/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="web/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="web/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="web/ico/favicon.png">
    
    <!-- Include the badass jQuery -->
    <script src="web/js/jquery-1.7.1.min.js"></script>
  </head>

  <body itemscope itemtype="http://schema.org/WebPage">

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" style="padding: 0" href="<?=BASEURL?>">
            <span itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
                <img itemprop="contentURL" src="<?=ORGANIZATION_LOGO?>" alt="<?=$this->organization_name?>" title="<?=$this->organization_name?>" />
            </span>
            <meta itemprop="name" content="<?=$this->organization_name?>">
          </a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
                
                <? if (!empty($this->idioms)) {?>
                    <? foreach ($this->idioms as $item) { ?>
                        <a class="navbar-link" href="<?=$item->href()?>">
                          <?=$item->html()?>
                        </a>
                    <? } ?>
                <? } ?>
                
                <? if (!empty($this->logged_username)) : ?>
                    Sessão de <a href="<?=BASEURL.'/mod/myaccount'?>" class="navbar-link"><?=$this->logged_username?></a>&nbsp;
                    <a href="<?=$this->logout_link->href?>" class="navbar-link">Terminar</a>
                <? else: ?>
                    <a href="<?=$this->login_link->href?>" class="navbar-link">Entrar</a>
                    <? if (REGISTER_ALLOWED) { ?>
                        <a href="<?=$this->register_link->href?>" class="navbar-link">Registar</a>
                    <? } ?>
                <? endif; ?>
                    
            </p>
            <ul class="nav">
                <? foreach ($this->top_menu as $item) { ?>
                <li<? if (!empty($item->class)) {?> class="<?=$item->class?>"<? } ?>>
                    <a href="<?=$item->href?>"><?=$item?></a>
                </li>
                <? } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
            
            <div class="well sidebar-nav">
                <div class="wiki-search">
                    <div class="nav-header">Pesquisar...</div>
                    <form class="form-search" action="search">
                        <div class="input-append">
                            <input class="span9" type="text" name="q"
                                   value="<?=empty($this->query) ? '' : $this->query?>">
                            <button class="btn" type="submit">Pesquisar</button>
                        </div>
                    </form>
                </div>
            </div><!--/.well -->
            
            <? if (!empty($this->recent)) { ?>
                <div class="well sidebar-nav">
                  <ul class="nav nav-list">
                    <li class="nav-header">Mais recentes...</li>
                    <? foreach ($this->recent as $item) { ?>
                      <li<? if (!empty($item->class)) {?> class="<?=$item->class?>"<? } ?>>
                          <a href="<?=$item->href?>"><?=$item?> <span class="label wiki-date-min"><?=$item->date?></span></a>
                      </li>
                    <? } ?>
                  </ul>
                </div><!--/.well -->
            <? } ?>
                
            <? if (!empty($this->popular)) { ?>
                <div class="well sidebar-nav">
                  <ul class="nav nav-list">
                    <li class="nav-header">Mais populares...</li>
                    <? foreach ($this->popular as $item) { ?>
                      <li<? if (!empty($item->class)) {?> class="<?=$item->class?>"<? } ?>>
                          <a href="<?=$item->href?>"><?=$item?> <span class="badge badge-info wiki-visits-min"><?=(int)$item->visits?></span></a>
                      </li>
                    <? } ?>
                  </ul>
                </div><!--/.well -->
            <? } ?>
            
            <? if (!empty($this->unpublished)) { ?>
                <div class="well sidebar-nav">
                  <ul id="wiki-unpublished" class="nav nav-list">
                    <li class="nav-header">Por publicar...</li>
                    <? foreach ($this->unpublished as $item) { ?>
                      <li<? if (!empty($item->class)) {?> class="<?=$item->class?>"<? } ?>>
                          <a href="<?=$item->href?>"><?=$item?></a>
                      </li>
                    <? } ?>
                  </ul>
                </div><!--/.well -->
            <? } ?>
                                
        </div><!--/span-->
        <div class="span9">
            <? if (!empty($this->featured)) { ?>
                <? $content = reset($this->featured); ?>
                <div class="hero-unit">
                  <h1><a href="<?=BASEURL.'/'.$content->alias?>"><?=$content->title?></a></h1>
                  <img class="media-object wiki-img-featured-big pull-left" 
                       src="<?=BASEURL?>/web/data/<?=$content->image->src?>" alt="<?=$content->title?>" />
                  <div><?=$content->intro?></div>
                  <div class="clearfix"></div>
                  <p><a href="<?=BASEURL.'/'.$content->alias?>" 
                        class="btn btn-primary pull-right"><?=$content->more_link?></a></p>
                </div>
            <? } ?>
            <? if (!empty($this->featured) && count($this->featured) > 3) { ?>
            <div class="row-fluid">
                <? for ($i = 1; $i < count($this->featured); $i++) {
                    $content = $this->featured[$i];
                    ?>
                <div class="span4">
                  <h2><a href="<?=BASEURL.'/'.$content->alias?>"><?=$content->title?></a></h2>
                  <img class="media-object wiki-media-object-img pull-left" 
                       src="<?=BASEURL?>/web/data/<?=$content->image->src?>" alt="<?=$content->title?>" />
                  <div><?=$content->intro?></div>
                  <div class="clearfix"></div>
                  <a href="<?=BASEURL.'/'.$content->alias?>" class="btn btn-mini pull-right"><?=$content->more_link?></a>
                </div><!--/span-->
              <? } ?>
            </div><!--/row-->
            <hr />
            <? } ?>
            <? if (!empty($this->html)) { ?>
                <div class="row-fluid">
                  <div class="span12">
                    <?=$this->html?>
                  </div><!--/span-->
                </div><!--/row-->
          <? } ?>
        </div><!--/span-->
      </div><!--/row-->
    </div><!--/.fluid-container-->
    
    <footer class="navbar navbar-fixed-bottom">
        <div class="navbar-inner">
            <div class="pull-right">BootWiki &copy; Marco Afonso 2013</div>
        </div>
    </footer>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="web/js/wysihtml5-0.3.0_rc2.min.js"></script>
    <script src="web/js/bootstrap.min.js"></script>
    <script src="web/js/bootstrap-wysihtml5-0.0.2.js"></script>
    
    <!-- Include google analytics if exists -->
    <? if (file_exists(TEMPLATEPATH.'/'.BootWiki::getIdiom().'/ga.php')) {
        include TEMPLATEPATH.'/'.BootWiki::getIdiom().'/ga.php';
    } ?>
    
  </body>
</html>