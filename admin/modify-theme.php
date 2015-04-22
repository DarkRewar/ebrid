<?php

/**
 * Index page of Administration
 *
 * @package Ebrid
 * @since Version 0.1
 * @version 0.2
 */

require_once( dirname(__FILE__) . '/loader.php');

get_header_admin('Selection du thème');

if(isset($_GET['active'])){
    if(EbridTheme::_exist($_GET['active'])){
        $theme = new EbridTheme($_GET['active']);
        $settings->setSettings('THEME', $_GET['active']);
        $settings->writeSettings();
    }
}

?>

<div class="row">
    <h1 class="heading">Changez de thème</h1>
    <div class="col s-range-12">
        <div class="row">
            <div class="col m-range-4">
                <div class="preview-theme">
                    <section>
                        <img src="<?php echo $theme->getScreenshot() ?>">
                    </section>
                    <footer>
                        <span class="name-theme">
                            <?php echo $theme->getInfos("Name") ?>
                        </span>
                        <a class="button right">Activé</a>
                    </footer>
                </div>
            </div>
            <?php foreach (EbridTheme::_getAll() as $folderName => $theTheme): ?>
                <?php if ($settings->getSettings("THEME") == $folderName){
                    continue;
                } ?>
                <div class="col m-range-4">
                    <div class="preview-theme">
                        <section>
                            <img src="<?php echo $theTheme->getScreenshot() ?>" />
                        </section>
                        <footer>
                            <span class="name-theme">
                                <?php echo $theTheme->getInfos("Name") ?>
                            </span>
                            <a href="?active=<?php echo $folderName ?>" class="right button info">
                                Activer
                            </a>
                        </footer>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>    
</div>

<?php

get_footer_admin();