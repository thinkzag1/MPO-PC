ccm_enableUserProfileMenu=function(){var a=$("#ccm-account-menu-container"),b=$("#ccm-account-menu");if(b.length){if(0==a.length)var a=$("<div />").appendTo(document.body);a.addClass("ccm-ui").attr("id","ccm-account-menu-container"),$("#ccm-account-menu").appendTo(a);var c=$(document).height(),d=$("#ccm-account-menu").offset().top;c>200&&c-d<200&&$("#ccm-account-menu").addClass("dropup")}};;

