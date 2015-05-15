<?php

/**
 * Index page of Administration
 *
 * @package Ebrid
 */

require_once( dirname(__FILE__) . '/loader.php');

$uid = isset( $_GET['uid'] )?$_GET['uid']:0;
$userSelected = new User( $uid );

$message = null;
if( isset($_POST['modify-user']) && post('manage-user', $_POST) ){
    $user
        ->setFirstname( $_POST['modify-first-name'] )
        ->setLastname( $_POST['modify-last-name'] )
        ->update();
    $message = '<div class="message success">Utilisateur modifié<a class="close">&times</a></div>';
} else if( isset($_POST['modify-user']) ){
    $message = '<div class="message error">Erreur<a class="close">&times</a></div>';
}

get_header_admin("Gestion des utilisateurs");

?>

<div class="row">
    <div class="col s-range-12">   
        <?php intent( 'admin-head-up' ); ?>
        <?php if( $uid == 0): ?>
            <h1 class="heading">Gérer les utilisateurs</h1>
            <table class="dif">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="checkall" id="checkall" />
                        </th>
                        <th>Nom d'utilisateur</th>
                        <th>Adresse email</th>
                        <th>Niveau du compte</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (User::_getAll() as $user): ?>
                        <tr>
                            <td><input type="checkbox" name="check-<?php __( $user->getUid() ) ?>" /></td>
                            <td><?php __( $user->getNickname() )  ?></td>
                            <td><?php __( $user->getEmail() ) ?></td>
                            <td>
                                <?php if ( $user->getStatus() == 2 ): ?>
                                    Administrateur
                                <?php else: ?>
                                    Utilisateur
                                <?php endif ?>
                            </td>
                            <td>
                                <a href="?uid=<?php __( $user->getUid() ) ?>" class="button info">Modifier</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php else: ?>         
            <h1 class="heading">Modifier cet utilisateur</h1>
            <?php __( $message ) ?>
            <form class="row" method="post" action="">
                <div class="col m-range-6">
                    <label class="input-label">
                        <span class="info-label">Nom d'utilisateur</span>
                        <input type="text" 
                            name="modify-nickname" 
                            id="modify-nickname"
                            value="<?php __( $userSelected->getNickname() ) ?>" />                
                    </label>
                </div>
                <div class="col m-range-6">
                    <label class="input-label">
                        <span class="info-label">Adresse email</span>
                        <input type="text" 
                            name="modify-email" 
                            id="modify-email"
                            value="<?php __( $userSelected->getEmail() ) ?>" />                
                    </label>
                </div>
                <div class="col m-range-6">
                    <label class="input-label">
                        <span class="info-label">Nouveau mot de passe</span>
                        <input type="text" 
                            name="modify-password" 
                            id="modify-password" 
                            placeholder="Ne rien entrer pour garder l'ancien" />                
                    </label>
                </div>
                <div class="col m-range-6">
                    <label class="input-label">
                        <span class="info-label">Confirmer nouveau mot de passe</span>
                        <input type="text" name="modify-password-c" id="modify-password-c" />                
                    </label>
                </div>
                <div class="col m-range-6">
                    <label class="input-label">
                        <span class="info-label">Prénom</span>
                        <input type="text" 
                            name="modify-first-name" 
                            id="modify-first-name"
                            value="<?php __( $userSelected->getFirstName() ) ?>" />                
                    </label>
                </div>
                <div class="col m-range-6">
                    <label class="input-label">
                        <span class="info-label">Nom</span>
                        <input type="text" 
                            name="modify-last-name" 
                            id="modify-last-name"
                            value="<?php __( $userSelected->getLastName() ) ?>" />                
                    </label>
                </div>
                <div class="col s-range-12">
                    <input type="submit" name="modify-user" class="button info fat" value="Enregistrer" />
                    <a href="manage-user.php" class="right button error fat rounded">Annuler</a>
                </div>
            </form>
        <?php endif ?>    
    </div>
</div>

<?php

get_footer_admin();