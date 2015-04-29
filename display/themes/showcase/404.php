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
        <h1>Erreur 404</h1>
        <h2>La page que vous recherchez n'existe pas</h2>
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