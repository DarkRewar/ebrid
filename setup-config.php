<?php
if (isset($_POST)) {
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
    <title>Installation d'Ebrid</title>
</head>
<body>
<div class="main-section">
    <div class="row">
        <div class="col m-range-9">
            <div class="row">
                <div class="col m-range-12">
                    <div class="article-preview">
                        <?php
                        $step = isset($_GET['step']) ? (int)$_GET['step'] : 0;
                        switch ($step) {
                            case 0:
                                $step_1 = 'setup-config.php?step=1';
                                ?>
                                <h1>Installation</h1>
                                <p>Bienvenue dans WordPress. Avant de nous lancer, nous avons besoin de certaines
                                    informations sur votre base de données. Il va vous falloir réunir les informations
                                    suivantes pour continuer.</p>
                                <ol>
                                    <li>Nom de la base de données</li>
                                    <li>Nom d’utilisateur MySQL</li>
                                    <li>Mot de passe de l’utilisateur</li>
                                    <li>Adresse de la base de données</li>
                                    <li>Préfixe de table (si vous souhaitez avoir plusieurs Ebrid sur une même base de
                                        données)
                                    </li>
                                </ol>
                                <p>
                                    <strong>Nous allons utiliser cette information pour créer le fichier wp-config.php.
                                        Si, pour quelque raison que ce soit, la création automatique du fichier ne
                                        fonctionne pas, pas de panique. Tout ce qu’elle fait, c’est de compléter le
                                        fichier de configuration avec les informations de connexion à la base de
                                        données. Vous pouvez tout aussi bien ouvrir le fichier wp-config-sample.php dans
                                        un éditeur de texte, y saisir les informations en question, et enregistrer le
                                        fichier sous le nom wp-config.php.</strong>
                                </p>

                                <p>Vous devriez normalement avoir reçu ces informations de la part de votre hébergeur.
                                    Si vous ne les avez pas, il vous faudra contacter votre hébergeur afin de continuer.
                                    Si vous êtes prêt…</p>

                                <p class="step"><a href="<?php echo $step_1; ?>" class="button button-large">Let's
                                        Go!</a></p>
                                <?php
                                break;
                            case 1:
                                $step_2 = 'setup-config.php?step=2';
                                ?>
                                <h1>Installation : Etape 1</h1>
                                <form method="post" action="<?php echo $step_2; ?>">
                                    <p>Vous devez saisir ci-dessous les détails de connexion à votre base de données. Si
                                        vous ne les connaissez pas, contactez votre hébergeur.</p>
                                    <table class="#">
                                        <tr>
                                            <th scope="row"><label for="bdname">Nom de la base de données</label></th>
                                            <td><input name="bdname" id="bdname" type="text" size="25" value="Ebrid"/>
                                            </td>
                                            <td>Le nom de la base de données dans laquelle vous souhaitez installer
                                                WordPress.
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><label for="dbuser  ">Identifiant</label></th>
                                            <td><input name="dbuser" id="dbuser " type="text" size="25"
                                                       value="Utilisateur"/></td>
                                            <td>Votre identifiant MySQL</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><label for="dbpassword">Mot de passe</label></th>
                                            <td><input name="dbpassword" id="dbpassword" type="text" size="25"
                                                       value="Mot de passe"></td>
                                            <td>…et son mot de passe MySQL.</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><label for="dbhost">Adresse de la base de données</label>
                                            </th>
                                            <td><input name="dbhost" id="dbhost" type="text" size="25"
                                                       value="localhost"/></td>
                                            <td>Si localhost ne fonctionne pas, votre hébergeur doit pouvoir vous donner
                                                la bonne information.
                                            </td>
                                        </tr>
                                        <tr>
                                    </table>
                                    <input name="submit" type="submit" value="Envoyer" class="#"/></p>
                                </form>
                                <?php
                                break;
                            case 2:
                                $step_3 = 'setup-config.php?step=3';
                                $checkDB = checkDB($dbhost, $dbname, $dbuser, $dbpassword);
                                if ($checkDB !== true) {
                                    ?>
                                    <p>Erreur lors de la connexion à la base de données :
                                        <br/>
                                        <?php echo $checkDB->getMessage(); ?>
                                    </p>
                                <?php
                                } else {
                                    ?>
                                    <p>La connexion à la base de données s'est bien passée.</p>
                                    <p class="step"><a href="<?php echo $step_3; ?>" class="button button-large">
                                            Passons à la suite</a></p>
                                <?php
                                }
                                break;
                            case 3:
                                //  CREATE DATABASE IF NOT EXISTS DBName;
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