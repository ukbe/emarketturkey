/*
 * 
 * INITIALIZING
 * 
 */

$(document).ready(function() {

	/* 
	 * 
	 * 1st thing 1st:
	 * removing _noJS class on document ready:
	 *  
	 */
	var JS_STATE = 0;
	var body = document.getElementsByTagName("body")[0];
	body.className = body.className.replace(/\b_noJS\b/,'');
	JS_STATE = 1;




var src_key = $('#search_keywords');
var subScr = $('subscreens');
/*
src_key.parent().mouseover(function(){
	src_key.focus();
});
*/

src_key.bind('keydown click focus', function(){
	if (! (src_key.parent().hasClass('_long')) )
	{
		$('body > header > nav dt, #buttons').hide();
		vv = $('ul.btn_subscr:visible').index();
		if (vv > -1)
		{
			$('ul.btn_subscr:eq('+vv+')').toggleClass('_subscr_on');
			$('#buttons li:eq('+(vv+2)+')').removeClass('_btn_up');
		}
		src_key.parent().addClass('_long').animate({width:600},500);
	}
});

src_key.bind('blur', function(){
	if (src_key.parent().hasClass('_long'))
	{
		src_key.parent().css('border-color','transparent').removeClass('_long').animate({width:0});
		$('body > header > nav dt, #buttons').fadeIn();
		$('ul.btn_subscr:eq('+vv+')').addClass('_subscr_on');
		$('#buttons li:eq('+(vv+2)+')').addClass('_btn_up');
	}
});

$('body').bind('mousedown',function(e){
	if (src_key.parent().hasClass('_long'))
	{
		if (!($(e.target).closest('#search_field').length))
		{
			src_key.parent().css('border-color','transparent').removeClass('_long').animate({width:0});
			$('body > header > nav dt, #buttons').fadeIn();
			$('ul.btn_subscr:eq('+vv+')').addClass('_subscr_on');
			$('#buttons li:eq('+(vv+2)+')').addClass('_btn_up');
		}
	}
})


$('body').keypress(function(event) {
  if (event.keyCode == '27')
  {
 	src_key.attr('value','').val('');
  }
});


////////////////////////////////////////////////////////////////////////

if (!$('body').hasClass('_admin'))
{

	$('h1:eq(0) a').bind('mouseover', function(){
			$('#language_field').show();
			$('body > header > div > nav').hide();
	});

	$('header').bind('mouseleave', function(){
			$('#language_field').hide();
			$('body > header > div > nav').show();
	});
}

/*
	BUTTONIFY LINKS
*/
$("#search_option").buttonset();

$('#btn_messages, #btn_notifications').dynabox({clickerOpenClass: '_btn_up', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: true, autoUpdate: true, newTagSelector: '._ID_-newtag',
			beforeopen: function(){$('#buttons > li > b > a > span').hide();},
			closed: function(){$('#buttons > li > b > a > span:not(:empty)').show();}
			});

$('#btn_account').dynabox({clickerOpenClass: '_btn_up', clickerMethod: 'click', loadMethod: 'static', loadType: 'none'}); 

if (JS_STATE) {
	$('body > header > div > nav > dl > dt > a')
	.dynabox({clickerOpenClass: '_btn_up', clickerMethod: 'hover', clickerLetGo: true, loadMethod: 'static', loadType: 'none'});
	$('#btn_login')
	.dynabox({clickerOpenClass: '_btn_up', clickerMethod: 'click', clickerLetGo: true, loadMethod: 'static', loadType: 'none'});
}

/*
 * 
 * Scrollable (emt_carousel) init
 * 
 */

/*
var scrollable = $(".scrollable");
var divideUL = 0;
if (scrollable.length) {

	if (scrollable.parent().hasClass('col_948')) divideUL = 7;
	else if (scrollable.parent().hasClass('col_762')) divideUL = 6;
	else if (scrollable.parent().hasClass('col_576')) divideUL = 4;
	else if (scrollable.parent().hasClass('col_285')) divideUL = 2;
	else if (scrollable.parent().hasClass('col_188')) divideUL = 1;
	else if (scrollable.parent().hasClass('col_180')) divideUL = 1;
	else divideUL = 1;

	scrollable
	.contents().wrapAll("<div class='temp_items' />")
	.parent().parent().prepend("<div class=\"navi\"></div>")
	.append("<br class=\"clear\" />");

	$('div.temp_items').before('<div class="items" />');
	
	var num_UL = Math.ceil(($('div.temp_items li').length)/(divideUL));
	//alert(num_UL);

	for (i=0;i < num_UL;i++) {
		$('.items').append('<ul />');
	}
	for (i=0;i < divideUL;i++) {
		$('.items ul').append('<li />');
	}

/*
	var divident = num_UL * divideUL - $('div.temp_items li').length;
	var excess = $('div.temp_items li').length - divident;
	
	if (divident > 0)
	{
		for (i=0;i<divident;i++){
			$('div.items li:eq('+ excess +')').remove();
		}
	}
*/
/*

	$('div.temp_items li').each(function(index){
		$('.items li:eq('+index+')').prepend($(this).contents());
	})

	$('div.temp_items').remove();

	scrollable
	.scrollable({circular: true, mousewheel: true})
	.navigator()
	.autoscroll({ interval: 3000 });
}*/

    $('.frmhelp[title!=\"\"]').each(function(){$(this).attr('title', this.title.replace('\n', '<br />'))}).tooltip({offset: [10, 2],effect: 'slide'}).dynamic({ bottom: { direction: 'down', bounce: true } });
    $("span.btn_container").buttonset();

    $('.loginlink').click(function(){
    	var x = $('#btn_login');
    	x.data('dynabox')._dynaBox.find('input[type=hidden][name=_ref]').val(window.location);
		x.bind('dynaboxclosed', function(){x.data('dynabox')._dynaBox.find('input[type=hidden][name=_ref]').val('');});
		x.bind('dynaboxopened', function(){$('html, body').animate({scrollTop: 0}, 500, null, function(){x.data('dynabox')._dynaBox.find('input[name=email]').focus();}); });
    	x.data('dynabox').open();
		return false;
    });

    window.initElementsScript = function(scope){
    	$(scope).find('.ajax-enabled').dynabox({clickerOpenClass: '_btn_up', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    		loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, position: 'window'
    	});
    }
    
    window.initElementsScript('body');
});