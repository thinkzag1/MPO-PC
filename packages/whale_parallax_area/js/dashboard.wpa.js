$(document).ready(function() {

    //select all checkbox
    $('#ccm-list-cb-all').click(function(){
        $("input[type='checkbox']").prop('checked', this.checked);
    });

    //expand/collapse
    //$("a.show-hide").click(function (e) {
    $('body').on('click', 'a.show-hide', function(e) {
        e.preventDefault();
        var ref = $(this).attr("href");
        //var target = $(ref);
        var target = $(this).closest("div.well").find(ref);
        //console.log("==>");
        //console.log(target);
        if (target.is(":visible")) {
            $(this).find("i").attr("class", "fa fa-chevron-down");
            target.stop(true, true).slideUp();
        } else {
            $(this).find("i").attr("class", "fa fa-chevron-up");
            target.stop(true, true).slideDown();
        }
        return false
    });

   //tab
   $('#tabset a').click(function(ev){

    var tab_to_show = $(this).attr('href');
    if(tab_to_show=='#scroll-down') {
        $('html, body').animate({ scrollTop: $(document).height() }, "slow");
        return;
    }
    $('#tabset li').
      removeClass('ccm-nav-active').
      find('a').
      each(function(ix, elem){
        var tab_to_hide = $(elem).attr('href');
        $(tab_to_hide).hide();
      });
    $(tab_to_show).show();
    $(this).parent('li').addClass('ccm-nav-active');
    return false;
    }).first().click();
    //}).last().click();
	//}).eq(2).click();

    //Block Editing UI Popover Help
    //$('.ccm-block-type-help').mouseover(function(){
    //    $(this).popover('show');
    //});

    //Block Editing UI Popover Help
    $('[data-toggle="popover"]').popover();

});