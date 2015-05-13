<?php

/**
 *  Index page of Administration
 *
 *  @package Ebrid
 */

require_once (dirname(__FILE__) . '/loader.php');

get_header_admin("Gestion des categories");

if (isset($_GET['trashed'])) 
{
    
    ForumCategory::_deleteCategory($_GET['category']);
    redirect("manage-category.php", true);
}
?>

<div class="row">
    <a href="testcategoryforum.php">Créer une nouvelle catégorie</a>
        <table class="dif">
            <thead>
                <tr>
                    <th>Categories</th>
                    <th>Modifications categories</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
            <?php
foreach (ForumCategory::_getCategories() as $v) 
{
    echo "
            <tr>
                <td>
                    <a style=\"color:#000\" href=\"testcategoryforum.php?category=" . $v['idc'] . "\">" . $v['name'] . "</a>
                </td>
                <td>
                    <a class=\"button info rounded\" href=\"modify-category.php?category=" . $v['idc'] . "\">Modifier</a>
                </td>
                <td>    <a id='supprimer_category_" . $v['idc'] . "' class=\"supprimerCategory button error rounded\" href=\"manage-category.php?category=" . $v['idc'] . "&trashed=true\">Supprimer
                        </a>
                    <br />
                </td>
            </tr>
                
                 ";
}
?>
            
            </tbody>
        </table>
    </div>