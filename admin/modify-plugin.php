<?php

/**
 * Modification page for Plugins
 *
 * @package Ebrid
 * @since Version 0.2
 * @version 0.2
 */

require_once( dirname(__FILE__) . '/loader.php');

get_header_admin('Modifier des plugins');

if(isset($_GET['active'])){
    if(EbridTheme::_exist($_GET['active'])){
        $theme = new EbridTheme($_GET['active']);
        $settings->setSettings('THEME', $_GET['active']);
        $settings->writeSettings();
    }
}

?>

<div class="row">
    <div class="col s-range-12">
        <h1 class="heading">Modifier des plugins</h1>
        <table class="dif">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" name="checkall" id="checkall" class="" />
                    </th>
                    <th>Nom du plugin</th>
                    <th>Description</th>
                    <th>Auteur</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (EbridPlugin::_getAll() as $plugin): ?>
                    <tr>
                        <td><input type="checkbox" name="check-<?php __( $plugin->getName() ) ?>"></td>
                        <td><?php __( $plugin->getName() ) ?></td>
                        <td><?php __( $plugin->getInfos('description') ) ?></td>
                        <td><?php __( $plugin->getInfos('author') ) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>    
</div>

<?php

get_footer_admin();