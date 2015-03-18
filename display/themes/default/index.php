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
    <div class="main-section row">
        <?php foreach(BlogArticle::_getArticles() as $v): ?>
            <div class="col m-range-6">
                <div class="article-preview">
                    <h1><?php echo $v['title'] ?></h1>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                        Consequatur distinctio accusantium ratione, eos similique 
                        odit eum, numquam, odio eligendi libero ipsam labore quod 
                        suscipit, hic aliquam praesentium quaerat repudiandae 
                        asperiores.
                    </p>
                    <a href="#" class="button info read">Lire l'article</a>
                </div>
            </div>
        <?php endforeach; ?>
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