<?php

/**
 * Index page of Administration
 *
 * @package Ebrid
 */

require_once( dirname(__FILE__) . '/loader.php');

get_header_admin("Paramètrage du site");

if(isset($_POST['send_settings'])){
    foreach ($_POST as $k => $v) {
        $settings->setSettings(strtoupper($k), $v);
    }
    
    $settings->writeSettings();
}

?>

<div class="row">
    <h1 class="heading">Changez vos paramètres</h1>
    <div class="col s-range-12">
        <form action="" method="post">
            <?php foreach ($settings->getSettings() as $k => $v): ?>
                <label class="">
                    <?php echo $k ?>
                    <input type="text" name="<?php echo strtolower($k) ?>" id="" class="" placeholder="" value="<?php echo $v ?>" />
                </label>
            <?php endforeach ?>
            <input class="button info right" type="submit" name="send_settings" value="Enregistrer vos paramètres">
        </form>
    </div>    
</div>

<?php

get_footer_admin();