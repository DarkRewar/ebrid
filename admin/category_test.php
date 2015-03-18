<?php
require (dirname(__FILE__) . '/loader.php');
get_header_admin('Test Cats');
?>
<div class="row">
    <article class="special-block">
    <header>
        <h4>Liste des catégories</h4>
    </header>
    <section>
        <?php draw_tree_category(); ?>
    </section>
    <footer>
        <button class="info" data-modal="add-category">Ajouter une catégorie</button>
        <div id="add-category" class="modal">
            <a class="close">×</a>
            ...
        </div>
    </footer>
    </article>
</div>
<?php
get_footer_admin();