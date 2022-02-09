jQuery(document).ready(function ($) {
    jQuery(".where-is-my-id-inside-lb").bind('click',function(e){
        $('#oopsiewrongid').modal('hide');
        $('#whereIsMyId').modal();
    });

    function show_loader() {
        $(".poptin-overlay").fadeIn(500);
    }

    function hide_loader() {
        $(".poptin-overlay").fadeOut(500);
    }

    jQuery(".pp_signup_btn").on('click', function (e) {
        e.preventDefault();
        var email = $("#email").val();
        if (!isEmail(email)) {
            e.preventDefault();
            $("#oopsiewrongemailid").modal('show');
            return false;
        } else {
            show_loader();
            jQuery.ajax({
                url: jQuery("#registration_form").attr('action'),
                dataType: "JSON",
                method: "POST",
                data: jQuery("#registration_form").serialize(),
                success: function (data) {
                    hide_loader();
                    if (data.success == true) {
                        jQuery(".ppaccountmanager").fadeOut(300);
                        jQuery(".poptinLogged").fadeIn(300);
                        jQuery(".poptinLoggedBg").fadeIn(300);
                        $(".goto_dashboard_button_pp_updatable").attr('href',"poptin?page=Poptin&poptin_logmein=true&after_registration=concrete5");
                    } else {
                        jQuery("#lookfamiliar").modal();
                        console.log("Error", data.message, "error");
                    }
                }
            });
        }
    });

    jQuery('.goto_dashboard_button_pp_updatable').click(function(){
        link = $(this);
        href = link.attr('href');
        setTimeout(function(){
            link.attr('href', href.replace('&after_registration=concrete5',''));
        },1000);
    });

    jQuery(document).on('click','.deactivate-poptin-confirm-yes',function(){
        jQuery.post($('#poptin-deactivate').val(),{
            action: 'delete-id'
            }, function (response) {
                console.log(response);
                if (response.success == true) {
                    jQuery('#makingsure').modal('hide');
                    jQuery('#byebyeModal').modal('show');
                    $(".poptinLogged").hide();
                    $(".poptinLoggedBg").hide();
                    $(".ppaccountmanager").fadeIn('slow');
                    $(".popotinLogin").show();
                    $(".popotinRegister").hide();
                }
            }
        );
    });

    jQuery(".pplogout").click(function (e) {
        e.preventDefault();
        jQuery('#makingsure').modal('show');
    });

    $(".ppLogin").click(function (e) {
        e.preventDefault();
        $(".popotinLogin").fadeIn('slow');
        $(".popotinRegister").hide();
    });

    $(".ppRegister").click(function (e) {
        e.preventDefault();
        $(".popotinRegister").fadeIn('slow');
        $(".popotinLogin").hide();
    });

    $('.ppFormLogin').on('submit', function (e) {
        e.preventDefault();
        var id = $('.ppFormLogin input[type="text"]').val();
        if (id.length != 13) {
            e.preventDefault();
            $("#oopsiewrongid").modal('show');
            return false;
        } else {
            $.post(jQuery("#map_poptin_id_form").attr('action'), {
                    data: {'poptin_id': id},
                    action: 'add-id',
                }, function (response) {
                    if (response.success == true) {
                        jQuery(".poptinLogged").fadeIn('slow');
                        jQuery(".poptinLoggedBg").fadeIn('slow');
                        jQuery(".ppaccountmanager").hide();
                        jQuery(".popotinLogin").hide();
                        jQuery(".popotinRegister").hide();
                        $(".goto_dashboard_button_pp_updatable").attr('href',"https://app.popt.in/login");
                    } else {
                        $("#oopsiewrongid").modal('show');
                    }
                }
            );
        }
    });


});


function isEmail(email) {
    var regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    return regex.test(email);
}