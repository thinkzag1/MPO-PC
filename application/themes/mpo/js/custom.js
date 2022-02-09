$('.ccm-responsive-navigation ul li:nth-child(5) a').addClass("no-link");
$('.ccm-responsive-navigation ul li:nth-child(5) ul li a').removeClass("no-link");
$(document).ready(function(){
html=''; i=1; $('.nav-tabs').each(function(){  html+=($(this).html()); $(this).addClass('tabbing' +i); i++;  }); $('.tabbing1').html(html); $('.tabbing2').hide(); $('.tabbing3').hide();  $('.jl_magic_tabs_gix_1 a').trigger('click')
});
