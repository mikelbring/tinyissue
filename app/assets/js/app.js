$(function(){

   if($('.global-notice').html().length > 0){

   	$('.global-notice').slideDown();

   	setTimeout(function(){
   		$('.global-notice').slideUp();
   	}, 15000);

   	$('.global-notice').live('click', function(){
   		$('.global-notice').slideUp();
   	});
   }
});

var saving = false;

function saving_toggle(){
	if(saving){
		$('.global-saving').hide();
		saving = false;
	}else{
		$('.global-saving').show();
		saving = true;
	}
}