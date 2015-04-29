<!DOCTYPE html>
<html>
<head>
    <title><?php draw_site_name(); ?></title>
    <link rel="icon" type="image/png" href="/display/img/favicon.png">
    <?php 
    use_ebrid_css('leaframe'); 
    _draw('style', theme_style());

    _draw('script', '/display/js/leaframe/jquery.js');
    _draw('script', '/display/js/leaframe/leaframe.min.js');
    ?>
</head>
<body>
    <?php draw_admin_block(array('top' => '30px')); ?>
    <div class="header-blog">
        <div class="row">
            <img class="s-range-hide m-range-3 col main-logo" src="/display/img/ebrid-logo.png">
            <h1 class="s-range-hide m-range-9 col big-title">
                <?php draw_site_name() ?>
            </h1>
            <h3 class="hide-for-ml s-range-12 col text-center"><?php draw_site_name() ?></h3>
        </div>
    </div>
    <nav class="affix">
        <div class="row">
            <ul>
                <li><a href="/">Accueil</a></li>
                <li><a href="http://leaframe.lignusdev.com/">Leaframe</a></li>
                <li><a href="http://www.lignusdev.com/">LignusDev</a></li>
            </ul>
        </div>
    </nav>
    <div class="main-section">
        <div class="row">
            <div class="col m-range-12">
                <div class="row">
                    <?php foreach(articles() as $article): ?>

                        <?php if( only_one() ) : ?>
                            <a href="/" class="button info">&laquo;Retour à l'accueil</a>
                            <div class="col s-range-12">
                                <h1 class="article-title"><?php draw_title($article) ?></h1>                
                                <?php draw_content($article) ?>
                            </div>
                        <?php else: ?>
                            <div class="col m-range-12">
                                <div class="article-preview">
                                    <h1><?php draw_title($article) ?></h1>
                                    <h4><?php draw_date($article) ?></h4>
                                    <?php draw_content($article) ?>
                                    <a href="<?php draw_link($article); ?>" class="button info read">Lire l'article</a>
                                </div>
                            </div>
                        <?php endif ?>

                    <?php endforeach; ?>           
                </div>
            </div>
        </div>
    </div>
    <div class="footer-blog">
        <div class="row">
            <div class="col m-range-6">
                <h4>Proudly created by Ebrid &copy; 2015</h4>
                <p>Theme made by <a href="http://www.lignusdev.com">Curtis Pelissier</a>.</p>
            </div>
        </div>
    </div>
</body>
</html>