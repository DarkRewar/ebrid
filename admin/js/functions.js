if (typeof jQuery !== 'undefined') {
    function loadScripts(scripts){
        if(typeof scripts === "object"){
            for(var script in scripts){
                $.getScript(scripts[script], function(){
                    // console.log(scripts[script]+" loaded");
                });
            }
        }else if(typeof scripts === "string"){
            $.getScript(scripts);
        }
    }

    function getPathAJAX(){
        var href = document.location.pathname;
        var regex = new RegExp("admin/(.*)", "i");
        if(href.match(regex)){
            href = href.replace(regex, "admin/ajax_requests.php");
        }else{
            regex = new RegExp("(.*)", "i");
            href = href.replace(regex, "/admin/ajax_requests.php");
        }
        return href;
    }
}