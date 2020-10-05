function formatStateNew (opt) {
    if (!opt.id) {
       return opt.text;
    } 

    var optimage = jQuery(opt.element).attr('data-image'); 
    if(!optimage){
       return opt.text;
    } else {                    
        var $opt = jQuery(
           '<span><img class="country-flg-img" src="' + optimage + '" width="16" height="16" /> ' + opt.text + '</span>'
        );
        return $opt;
    }    
};

window.onload = function(){
    
    jQuery(".phone-code-auto-search").select2({
        minimumResultsForSearch: 5,
        width: '100%',
        templateResult: formatStateNew,
        templateSelection: formatStateNew
    });
}