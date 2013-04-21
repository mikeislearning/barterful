$(document).ready(function(){
$('#tabs div').hide();
$('#tabs div:first').show();
$('#tabs ul li:first').addClass('active');
$('.active').css('background','#1E86B9');
$('.active a').css('color','white');
 
$('#tabs ul li a').click(function(){
$('#tabs ul li').removeClass('active');
$('#tabs ul li').css('background','white');
$('#tabs ul li a').css('color','#1E86B9');
$(this).parent().addClass('active');
$('.active').css('background','#1E86B9');
$('.active a').css('color','white');
var currentTab = $(this).attr('href');

$('#tabs div').hide();
$(currentTab).show();
return false;
});
});
