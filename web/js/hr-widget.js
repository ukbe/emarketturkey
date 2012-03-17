var GM_JQ = document.createElement('script'); 
GM_JQ.src = 'http://jquery.com/src/jquery-latest.js';
GM_JQ.type = 'text/javascript'; 
document.getElementsByTagName('head')[0].appendChild(GM_JQ); 

// Check if jQuery's loaded 
function GM_wait() { 
    if(typeof window.jQuery == 'undefined') 
{ window.setTimeout(GM_wait,100); } 
        else { $ = window.jQuery; letsJQuery(); } 
} 
GM_wait();

function letsJQuery(){
    frame=document.createElement('iframe');
    frame.id='pholder';
    frame.src='http://geek.emt/tr/corporate/aboutus';
    frame.scrolling='no';
    frame.frameborder=0;
    frame.border=0;
    frame.width=600;
    frame.height=400;
    frame.style.border='none';
    $('body').html(frame);
    //$.ajax({url:'http://geek.emt/tr/corporate/aboutus',
      //     success: function(mess){$('body').html(mess)}});
}