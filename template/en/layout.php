<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$this->title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$this->description?>">
    <meta name="keywords" content="<?=$this->keywords?>">
    <meta name="author" content="<?=$this->author?>">
    <base href="<?=BASEURL?>/">

    <!-- Le styles -->
    <link rel="stylesheet" href="web/css/bootstrap.css" rel="stylesheet">
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
    
    <link rel="stylesheet" href="web/css/bootstrap-wysihtml5-0.0.2.css"></link>
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
            <span itemprop="logo" itemscope itemtype="schema.org/ImageObject">
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
                    Logged in as <a href="<?=BASEURL.'/mod/myaccount'?>" class="navbar-link"><?=$this->logged_username?></a>&nbsp;
                    <a href="<?=$this->logout_link->href?>" class="navbar-link">Logout</a>
                <? else: ?>
                    <a href="<?=$this->login_link->href?>" class="navbar-link">Login</a>
                    <? if (REGISTER_ALLOWED) { ?>
                        <a href="<?=$this->register_link->href?>" class="navbar-link">Register</a>
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
                    <div class="nav-header">Search...</div>
                    <form class="form-search" action="search">
                        <input type="text" name="q" value="<?=empty($this->query) ? '' : $this->query?>"class="input-medium search-query">
                        <button type="submit" class="btn">Go</button>
                    </form>
                </div>
            </div><!--/.well -->
            
            <? if (!empty($this->recent)) { ?>
                <div class="well sidebar-nav">
                  <ul class="nav nav-list">
                    <li class="nav-header">Recent...</li>
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
                    <li class="nav-header">Most popular...</li>
                    <? foreach ($this->popular as $item) { ?>
                      <li<? if (!empty($item->class)) {?> class="<?=$item->class?>"<? } ?>>
                          <a href="<?=$item->href?>"><?=$item?> <span class="badge badge-info wiki-visits-min"><?=$item->visits?></span></a>
                      </li>
                    <? } ?>
                  </ul>
                </div><!--/.well -->
            <? } ?>
                
            <? if (!empty($this->unpublished)) { ?>
                <div class="well sidebar-nav">
                  <ul id="wiki-unpublished" class="nav nav-list">
                    <li class="nav-header">Unpublished...</li>
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
                       src="<?=BASEURL?>/web/data/<?=$content->image->src?>" />
                  <div><?=$content->intro?></div>
                  <div class="clearfix"></div>
                  <p><a href="<?=BASEURL.'/'.$content->alias?>" 
                        class="btn btn-primary pull-right"><?=$content->more_link?></a></p>
                </div>
            <? } ?>
            <? if (!empty($this->featured) && count($this->featured) > 1) { ?>
            <div class="row-fluid">
                <? for ($i = 1; $i < count($this->featured); $i++) {
                    $content = $this->featured[$i];
                    ?>
                <div class="span<?=round(12/(count($this->featured)-1))?>">
                  <h2><a href="<?=BASEURL.'/'.$content->alias?>"><?=$content->title?></a></h2>
                  <img class="media-object wiki-media-object-img pull-left" 
                       src="<?=BASEURL?>/web/data/<?=$content->image->src?>" />
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

      <hr>

      <footer class="navbar navbar-inner">
        <p class="pull-right">BootWiki &copy; Marco Afonso 2013</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="web/js/wysihtml5-0.3.0_rc2.min.js"></script>
    <script src="web/js/bootstrap.min.js"></script>
    <script src="web/js/bootstrap-wysihtml5-0.0.2.min.js"></script>

  </body>
</html>