<!DOCTYPE html>
<html>
<head>
    <title><?php draw_site_name(); ?></title>
    <?php 
    use_ebrid_css('leaframe'); 
    _draw('style', theme_path().'/style.css');
    ?>
</head>
<body>
    <div class="header-blog">
        <div class="row">
            <h1 class="s-range-hide m-range-12 col big-title"><?php draw_site_name() ?></h1>
            <h3 class="hide-for-ml s-range-12 col text-center"><?php draw_site_name() ?></h3>
        </div>
    </div>
    <div class="main-section">
        <div class="row">
            <div class="col m-range-9">
                <div class="row">
                    <?php foreach(articles() as $v): ?>
                        <?php if(only_one()) : ?>
                            <div class="col s-range-12">
                                <h1 class="article-title"><?php echo $v['title'] ?></h1>                
                                <?php echo $v['content'] ?>
                            </div>
                        <?php else: ?>
                            <div class="col m-range-12">
                                <div class="article-preview">
                                    <h1><?php echo $v['title'] ?></h1>
                                    <?php echo $v['content'] ?>
                                    <a href="<?php draw_link_article($v); ?>" class="button info read">Lire l'article</a>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endforeach; ?>                    
                </div>
            </div>
            <div class="col m-range-3">
                    <h4>Category</h4>
                    <ul>
                        <li>Cat1</li>
                        <li>Cat2</li>
                        <li>Cat3</li>
                    </ul>
            </div>
        </div>
    </div>
    <div class="footer-blog">
        <div class="row">
            <div class="col m-range-6">
                <h4>Category</h4>
                <ul>
                    <li>Cat1</li>
                    <li>Cat2</li>
                    <li>Cat3</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>