<?php

/**
 * Index page of Administration
 *
 * @package Ebrid
 */

require_once( dirname(__FILE__) . '/loader.php');

get_header_admin('Selection du thème');

?>

<div class="row">
    <h1 class="heading">Changez de thème</h1>
    <div class="col s-range-12">
        <div class="row">
            <?php foreach (EbridTheme::_getAll() as $folderName => $theme): ?>
                <div class="col m-range-4">
                    <div class="preview-theme">
                        <section>
                            <img src="<?php echo $theme->getScreenshot() ?>">
                        </section>
                        <footer>
                            <span class="name-theme">
                                <?php echo $theme->getInfos("Name") ?>
                            </span>
                            <?php if ($settings->getSettings("THEME") == $folderName): ?>
                                <a class="button right">Activé</a>
                            <?php else: ?>
                                <a href="?active=<?php echo $folderName ?>" class="right button info">
                                    Activer
                                </a>
                            <?php endif ?>
                        </footer>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>    
</div>

<?php

get_footer_admin();