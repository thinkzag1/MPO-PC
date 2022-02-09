$(document).ready(function() {
    //select all checkbox
    $('#ccm-list-cb-all').click(function(){
            $("input[type='checkbox']").prop('checked', this.checked);
    });

    //remove button
    //$("a.remove-slide").click(function (e) {
    $('body').on('click', 'a.remove-slide', function(e) {
        e.preventDefault();
		if(confirm("Do you want to remove this slide?")){
			$(this).closest("div.ccm-image-slider-entry").fadeOut(300, function(){ $(this).remove();});
		}
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

   //template buttons:
   $('.csstemplate').click(function(ev){
    css = $(this).attr('data');
    target = $(this).attr('target');
    $('textarea[name="'+target+'"]').val(css);
   });

   //tab checkbox enable/disable
   $('#lightbox').click(function(e){
        var area_to_disable = $(this).attr('target');
        $(area_to_disable).find('input, textarea, button, select').attr("readonly", $(this).is(':not(:checked)'));
        $(area_to_disable).find('button').attr("disabled", $(this).is(':not(:checked)'));
        $(area_to_disable).toggleClass('stripe-1');

        e.stopPropagation();
        $(this).parent().click();
        return;
    }).each(function(){
        if($(this).is(':not(:checked)')){
            //var area_to_disable = '#ccm-tab-content-'+$(this).parent().attr('data-tab');
            var area_to_disable = $(this).attr('target');
            $(area_to_disable).find('input, textarea, button, select').attr("readonly", $(this).is(':not(:checked)'));
            $(area_to_disable).find('button').attr("disabled", $(this).is(':not(:checked)'));
            //console.log($(area_to_disable));
            if(!$(this).is(':checked')){
                $(area_to_disable).addClass('stripe-1');
            }
        }
    });

   //active item enable/disable
   $("input[name='itemActive[]']").click(function(e){
        var area_to_disable = $(this).closest('.ccm-image-slider-entry');
        $(area_to_disable).find('input, textarea, button, select').attr("readonly", $(this).is(':not(:checked)'));
        $(area_to_disable).find('button').attr("disabled", $(this).is(':not(:checked)'));
        $(area_to_disable).toggleClass('stripe-1');
        e.stopPropagation();
        return;
    }).each(function(){
        if($(this).is(':not(:checked)')){
            var area_to_disable = $(this).closest('.ccm-image-slider-entry');
            $(area_to_disable).find('input, textarea, button, select').attr("readonly", $(this).is(':not(:checked)'));
            $(area_to_disable).find('button').attr("disabled", $(this).is(':not(:checked)'));
            if(!$(this).is(':checked')){
                $(area_to_disable).addClass('stripe-1');
            }
        }
    });

    //for items with opposite effect
   $('#singleItem').add('#animationDisable').click(function(e){
        var area_to_disable = $(this).attr('target');
        $(area_to_disable).find('input, textarea, button, select').attr("readonly", $(this).is(':checked'));
        $(area_to_disable).find('button').attr("disabled", $(this).is(':checked'));
        $(area_to_disable).toggleClass('stripe-1');

        e.stopPropagation();
        $(this).parent().click();
        //e.preventDefault();
        return;
    }).each(function(){
        if($(this).is(':checked')){
            var area_to_disable = $(this).attr('target');
            $(area_to_disable).find('input, textarea, button, select').attr("readonly", $(this).is(':checked'));
            $(area_to_disable).find('button').attr("disabled", $(this).is(':checked'));
            if($(this).is(':checked')) $(area_to_disable).addClass('stripe-1');
        }
    });

   sortableSlides()

   //T|D buttons
   $('#fill-titles').click(function(e){
    items = $('.ccm-image-slider-entries .ccm-image-slider-entry');
    if(items.length==0){
        alert('First add some slides!');
    }else{
        items.each( function( index, el ) {
            $(el).find('input[name="itemHeader[]"]').val($(el).find('input.image-itemImageID').attr('data-title'));
        });
    };
   });
   $('#fill-descriptions').click(function(e){
    items = $('.ccm-image-slider-entries .ccm-image-slider-entry');
    if(items.length==0){
        alert('First add some slides!');
    }else{
        items.each( function( index, el ) {
            $(el).find('textarea[name="itemDescription[]"]').val($(el).find('input.image-itemImageID').attr('data-description'));
        });
    };
   });

   //animation
   $("select[name='animationEffect']").change(function(e){
        displayAnimation();
   });
   $("#animate-repeat").click(function(e){
        displayAnimation();
   });

   $("select[name='itemUrlWrapper[]']").each(function(){
        toggleUrlWrapper.call(this);
   });

});

function toggleUrlWrapper(){
    var thisItem = $(this).closest("div.ccm-image-slider-entry");
    if($(this).val()=='button'){tmp=false;}else{tmp=true;};
    thisItem.find(".itemUrlLabel").attr("readonly", tmp);
}

function displayAnimation() {
    var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
    var container = $('.animation-display');
    //-webkit-animation-duration: 4s;animation-duration: 3s;
    var anim = 'animated '+$("select[name='animationEffect']").val(); //console.log(anim);
    var animationDuration = $("#animationDuration").val();
    var animationDelay = $("#animationDelay").val();
    var css = "-webkit-animation-duration: "+animationDuration+"ms;animation-duration:"+animationDuration+"ms;"+
              "-webkit-animation-delay: "+animationDelay+"ms;animation-delay:"+animationDelay+"ms;";
    container.attr("style", css);
    container.addClass(anim).one(animationEnd, function() {
        container.removeClass(anim);
    });
}

function sortableSlides() {
	$('div.ccm-image-slider-entries').sortable({
		handle: 'a.move-slide',
		cursor: 'move',
		tolerance: 'pointer',
        update : function(event,ui){ reindexItems(); }
	});
}
//re-index items after sort (for active checkbox sake)
function reindexItems() { 
    $('div.ccm-image-slider-entry').each(function( index ) {
        $( this ).attr("id", "item-"+index);
        $( this ).find("input[name='itemID[]']").val(index);
        $( this ).find("input[name='itemActive[]']").val(index);
    });
}