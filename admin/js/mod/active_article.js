//ici nous allons récupérer l'id de l'article puis le traiter
$(".activeArticle").on('click', function(e) {
    event.preventDefault();
    var dis = $(this);
    var idArticle = dis.attr('id');
    idArticle = idArticle.replace('active_article_', '');
    $.post(getPathAJAX(), {
        requested: "activeArticle",
        id: idArticle
    }, function(data) {
        dis.html('Desactiver');
    });
});