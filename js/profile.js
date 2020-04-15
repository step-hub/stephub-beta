// Javascript to enable link to tab
$(document).ready(() => {
    let url = location.href.replace(/\/$/, "");
    
    if (location.hash) {
        const hash = url.split("#");
        $('#v-pills-tab a[href="#'+hash[1]+'"]').tab("show");
        url = location.href.replace(/\/#/, "#");
        history.replaceState(null, null, url);
        setTimeout(() => {
        $(window).scrollTop(0);
        }, 400);
    } 
    
    $('a[data-toggle="pill"]').on("click", function() {
        let newUrl;
        const hash = $(this).attr("href");
        if(hash == "#profile") {
        newUrl = url.split("#")[0];
        } else {
        newUrl = url.split("#")[0] + hash;
        }
        
        history.replaceState(null, null, newUrl);
    });
});