<?php

/**
 *  Index page of Administration
 *
 *  @package Ebrid
 */
require_once( dirname(__FILE__) . '/loader.php');
session_unset();

if(isset($_POST['login_btn'])){
    unset($_POST['login_btn']);
    $user = new User($_POST['login_nick']);
    if($user->checkPassword($_POST['login_pass'])){
        set_session('uid', $user->getUid());
        redirect('admin-panel');
    }else{
        add_error($_messages, 'Mot de passe incorrect.');
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Title of the document</title>
    <link rel="stylesheet" href="css/leaframe.min.css" />
    <link rel="stylesheet" href="css/modules.css" />
    <script src="js/jquery.js"></script>
    <script src="js/leaframe.min.js"></script>
</head>

<body>
    <div class="row">
        <div class="col l-range-4 m-range-6 s-range-12 l-offset-4 m-offset-3">
            <div class="row box-login rounded">
                <div class="">
                    <h2 class="center">Connectez-vous</h2>
                    <?php if(have_log()):
                        foreach ($_messages as $k => $m) {
                            ?><div class="message <?php echo $m['type'] ?>">
                                <?php echo $m['message'] ?>
                                <a class="close">&times;</a>
                            </div><?php
                        }
                    endif; ?>
                    <form action="" method="post">
                        <input type="text" name="login_nick" id="" class="" placeholder="Identifant de connexion">
                        <input type="password" name="login_pass" placeholder="Mot de passe">
                        <input type="submit" name="login_btn"class="button info" value="Connexion">
                        <a href="./signup.php" class="button right">Créer un compte</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>