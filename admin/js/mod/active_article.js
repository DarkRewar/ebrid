//ici nous allons récupérer l'id de l'article puis le traiter
$("body").on('click', ".activeArticle", function(e) {
    event.preventDefault();
    var dis = $(this);
    var idArticle = dis.attr('id');
    idArticle = idArticle.replace('active_article_', '');
    $.post(getPathAJAX(), {
        requested: "activeArticle",
        id: idArticle
    }, function(data) {
        dis.html('Desactiver').removeClass('activeArticle success rounded').addClass('desactiveArticle classic rounded');
    });
}).on('click', ".desactiveArticle", function(e) {
    event.preventDefault();
    var dis = $(this);
    var idArticle = dis.attr('id');
    idArticle = idArticle.replace('active_article_', '');
    $.post(getPathAJAX(), {
        requested: "desactiveArticle",
        id: idArticle
    }, function(data) {
        dis.html('Activer').removeClass('desactiveArticle classic rounded').addClass('activeArticle success rounded');
    });
});