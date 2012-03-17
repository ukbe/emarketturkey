
function newcomers_itemVisibleInCallback(carousel, item, i, state, evt)
{
    var idx = carousel.index(2*i-1, mycarousel_itemList.length);
    carousel.add(2*i-1, mycarousel_itemList[(idx-1)%mycarousel_itemList.length].innerHTML);
    carousel.add(2*i, mycarousel_itemList[idx%mycarousel_itemList.length].innerHTML);
    
};

function newcomers_itemVisibleOutCallback(carousel, item, i, state, evt)
{
    carousel.remove(i+1);
};

jQuery(document).ready(function() {

    window.mycarousel_itemList = jQuery('#newcomers li');

    jQuery('#mycarousel').jcarousel({
        animation:  "normal",
        auto:  7,
        wrap:  "last",
        easing:  "swing"
    });
    
    jQuery('#newcomerscarousel').jcarousel({
        wrap: 'circular',
        vertical:  true,
        easing: "swing",
        animation: "fast",
        auto:  3,
        scroll:  1,
        itemVisibleInCallback: {onBeforeAnimation: newcomers_itemVisibleInCallback},
        itemVisibleOutCallback: {onAfterAnimation: newcomers_itemVisibleOutCallback}
    });

});