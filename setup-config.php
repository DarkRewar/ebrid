<?php
if (isset($_POST['dbhost']) && isset($_POST['dbname']) && isset($_POST['dbuser']) && isset($_POST['dbpassword'])) {
    $dbhost = $_POST['dbhost'];
    $dbname = $_POST['dbname'];
    $dbuser = $_POST['dbuser'];
    $dbpassword = $_POST['dbpassword'];
}

function checkDB($dbhost, $dbname, $dbuser, $dbpassword)
{
    try {
        $bdd = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname . ';charset=utf8', '' . $dbuser . '', '' . $dbpassword . '');
    } catch (Exception $e) {
        return $e;
    }
    return true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Installation | Ebrid</title>
    <link rel="stylesheet" href="/admin/css/leaframe.min.css" />
    <link rel="stylesheet" href="/admin/css/modules.css" />
    <script src="/admin/js/jquery.js"></script>
    <script src="/admin/js/leaframe.min.js"></script>
</head>
<body>
<div class="row">
    <div class="col l-range-4 m-range-6 s-range-12 l-offset-4 m-offset-3">
        <div class="row box-login rounded">
            <div class="">
                        <?php
                        $step = isset($_GET['step']) ? (int)$_GET['step'] : 0;
                        switch ($step) {
                            case 0:
                                // Page d'accueil de l'installation
                                $step_1 = 'setup-config.php?step=1';
                                ?>
                                <h2 class="center">Installation</h2>
                                <p>Bienvenue dans Ebrid.</p>
                                <p>Vous aurez besoin de ces informations pour poursuivre l'installation :</p>
                                <ol>
                                    <li>Nom de la base de données</li>
                                    <li>Nom d’utilisateur MySQL</li>
                                    <li>Mot de passe de l’utilisateur</li>
                                    <li>Adresse de la base de données</li>
                                </ol>

                                <p>Vous devriez normalement avoir reçu ces informations de la part de votre hébergeur.
                                    Si vous ne les avez pas, il vous faudra contacter votre hébergeur afin de continuer.
                                </p>

                                <p class="step"><a href="<?php echo $step_1; ?>" class="button info">C'est parti !</a></p>
                                <?php
                                break;
                            case 1:
                                // Demande des infos de la DB
                                $step_2 = 'setup-config.php?step=2';
                                ?>
                                <h2 class="center">Base de données</h2>
                                <form method="post" action="<?php echo $step_2; ?>">
                                    <p>Vous devez saisir ci-dessous les détails de connexion à votre base de données. </p>
                                    <p>Si vous ne les connaissez pas, contactez votre hébergeur.</p>
                                    <table class="#">
                                        <tr>
                                            <input name="dbname" type="text" placeholder="Nom de la base de données"/>
                                        </tr>
                                        <tr>
                                            <input name="dbuser" type="text" placeholder="Nom d’utilisateur MySQL"/>
                                        </tr>
                                        <tr>
                                            <input name="dbpassword" type="text" placeholder="Mot de passe de l’utilisateur"/>
                                        </tr>
                                        <tr>
                                            <input name="dbhost" type="text" placeholder="Adresse de la base de données"/>
                                        </tr>
                                    </table>
                                    <input name="submit" type="submit" class="button info" value="Lancer l'installation" class="#"/></p>
                                </form>
                                <?php
                                break;
                            case 2:
                                // Vérification des infos
                                $checkDB = checkDB($dbhost, $dbname, $dbuser, $dbpassword);
                                if ($checkDB !== true) {
                                    ?>
                                    <h2 class="center">Erreur</h2>
                                    <p>Il y a eu une erreur lors de la connexion à la base de données.</p>
                                    <p>Vous trouverez le message d'erreur ci-dessous :</p>
                                    <p><?php echo $checkDB->getMessage(); ?></p>
                                <?php
                                } else {
                                    // Création des tables
                                    $bdd = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname . ';charset=utf8', '' . $dbuser . '', '' . $dbpassword . '');
                                    $creation = 'USE `' . $dbname . '`;' . file_get_contents("bdd.sql");
                                    $bdd->exec($creation);
                                    ?>
                                    <h2 class="center">Base de données créée</h2>
                                    <p>Vous pouvez dès à présent créer votre compte admin en cliquant ci-dessous.</p>
                                    <a href="/admin/signup.php" class="button info">Créer votre compte admin</a>
                                <?php
                                    // Création des constantes pour la connexion à la DB
                                    $file = 'settings.php';
                                    $current = file_get_contents($file);
                                    $current .= "\n".
                                                '/**'."\n".
                                                ' * The values that are used'."\n".
                                                ' * for the connection to the Database'."\n".
                                                ' *'."\n".
                                                ' * @since Version 0.2'."\n".
                                                ' */'."\n".
                                                'define(\'DBHOST\', \''.$dbhost.'\');'."\n".
                                                'define(\'DBNAME\', \''.$dbname.'\');'."\n".
                                                'define(\'DBUSER\', \''.$dbuser.'\');'."\n".
                                                'define(\'DBPASSWORD\', \''.$dbpassword.'\');'."\n";
                                    file_put_contents($file, $current);
                                }
                                break;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>