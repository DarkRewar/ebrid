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
            <h1 class="big-title"><?php draw_site_name() ?></h1>
        </div>
    </div>
    <div class="row">
        <?php foreach(BlogArticle::_getArticles() as $v): ?>
            <div class="col m-range-6">
                <h1><?php echo $v['title'] ?></h1>
                <p><?php var_dump($v) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>