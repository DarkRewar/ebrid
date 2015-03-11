<?php

/**
 *  Index page of Administration
 *
 *  @package Ebrid
 */

require_once( dirname(__FILE__) . '/loader.php');

$infos = array('_nick' => null,'_mail' => null);

if(form_signup($_POST)){
    $user = new User();
    if($_POST['signup_pass'] != $_POST['signup_pass_check']){
        $infos['_nick'] = $_POST['signup_nick'];
        $infos['_mail'] = $_POST['signup_mail'];
        add_error($_messages, 'Les mots de passes ne correspondent pas.');
    }else{
        $user->create($_POST);
        add_success($_messages, 'Votre compte a bien été créé.');
        redirect('admin-panel');
    }
}

extract($infos);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inscription | Ebrid</title>
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
                    <h2 class="center">Inscrivez-vous</h2>
                    <?php if(have_log()):
                        foreach ($_messages as $k => $m) {
                            ?><div class="message <?php echo $m['type'] ?>">
                                <?php echo $m['message'] ?>
                                <a class="close">&times;</a>
                            </div><?php
                        }
                    endif; ?>
                    <form action="" method="post">
                        <input type="text" name="signup_nick" id="" class="" placeholder="Identifant de connexion" value="<?php echo $_nick ?>">
                        <input type="email" name="signup_mail" id="" class="" placeholder="Votre email" value="<?php echo $_mail ?>">
                        <input type="password" name="signup_pass" placeholder="Mot de passe">
                        <input type="password" name="signup_pass_check" placeholder="Confirmation de mot de passe">
                        <input type="submit" name="signup_btn" class="button info" value="Inscription">
                        <a href="login.php" class="button right">J'ai un compte</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>