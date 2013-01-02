<ol class="column">
<li class="column append-2">
<?php echo link_to('Messages<span id="ua-peer-newtag"></span>', '/en/default/boxtest', array('class' => 'dynabox', 'id' => 'ua-peer')); ?>
<div id="ua-peer-box" class="ghost">
<ul class="list">
<li class="header">Messages</li>
<li class="item temp">_NAME_ _LASTNAME_<br />_MESSAGE_<br />_OCCURENCE_</li>
<li class="footer"><?php echo link_to('see all', '@homepage') ?></li>
</ul>
</div>
</li>
<li class="column append-2">
<?php echo link_to('Account&nbsp;<span id="ua-bing-newtag"></span>', '/ajax-proxy.php?csurl=http://tx.geek.emt/en/default/boxtest?notify', array('class' => 'dynabox', 'id' => 'ua-bing')); ?>
<div id="ua-bing-box" class="ghost">
<ul class="list">
<li class="header">Account Settings</li>
<li class="item temp"><a href="_URL_"><img src="_IMG_" style="float: left; margin-right: 7px;" />_NAME_ _LASTNAME_<br />_MESSAGE_<br />_OCCURENCE_</a></li>
<li class="footer"><?php echo link_to('see all', '@homepage') ?></li>
</ul>
</div>
</li>
<li class="column">
<?php echo link_to('Edit Settings', '/en/default/boxtest?settings', array('class' => 'dynabox', 'id' => 'ua-thick')); ?>
</li>
<li class="column">
<?php echo link_to_function('Close Account Menu', "$('#ua-bing').dynabox('close');"); ?>
</li>
</ol>
<style>
.list { background-color: white; margin: 0px; padding: 0px; list-style-type: none; min-width: 200px;}
.list .temp { height: auto; }
.list.loading { min-height: 150px; position: relative; background: white url(/images/layout/icon/wait.gif) no-repeat center; }
.list.loading .footer { margin-top: 150px; }
.list > li {padding: 4px 5px; margin: 0px;}
.list .item {font: 11px verdana; color: #888888; border-bottom: solid 1px #EFEFEF;}
.list .item:last-child { border-bottom: none; }
.list .item a {text-decoration: none; color: #666666;}
.list .new-item {background-color: #e16a6a; color: #EEEEEE;}
.list .new-item a {background-color: #e16a6a; color: #EEEEEE;}
.list .header { background-color: #f6f6f6; color: #222222; border-bottom: solid 1px #AAAAAA;}
.list .footer { background-color: #253c67; color: #FFFFFF; margin-bottom: 0px; }
.list .footer a { color: #FFFFFF; text-decoration: none; }
.list .footer a:hover { text-decoration: underline; }
#ua-peer-box { background-color: #efefef; padding: 4px; border: solid 1px #cccccc; position: absolute; }
#ua-bing-box { background-color: #efefef; padding: 4px; border: solid 1px #cccccc; position: absolute; }
.dynabox { background-color: #DDDDDD; color: blue; padding: 4px 5px; text-decoration: none; margin-bottom: 16px; line-height: 23px; position: relative; }
.dynabox.box-open { background-color: #f7e9a6; color: black; }
.dynabox span[id$="-newtag"] { background-color: red; color: white; position: absolute; bottom: -5px; right: -5px; padding: 3px; line-height: 9px; font: 9px tahoma;z-index: 5; }
#ua-bing { background: #DDDDDD url(/images/layout/icon/expend-collapse.png) right 8px no-repeat; padding-right: 20px;}
#ua-bing.box-open { background: #f7e9a6 url(/images/layout/icon/expend-collapse.png) right -12px no-repeat; }
.TB_window .list .header { background-color: #222d3a; color: #FFFFFF; height: 20px; line-height: 20px; font: bold 11px verdana;}
.TB_window .list .footer { width: 480px; background: white url(/images/layout/background/footer-bg.png) no-repeat center; color: #000000; line-height: 30px; height: 30px; padding: 0px 10px; text-align: center; }
.TB_window .list .footer a { background-color: #50587e; color: #FFFFFF; font: bold 11px tahoma; padding: 4px 6px; text-decoration: none; margin: 0px 5px; }
.TB_window .list .footer a.thin { font: 11px tahoma; color: #888888; text-decoration: none; background: none; }
.TB_window .list .footer .left { float: left; margin: 0; }
.TB_window .list .footer .right { float: right; margin: 0; }
.TB_window .list .footer .center { margin: 0 auto; margin: 0; }

.TB_overlay { background-color:#000; filter:alpha(opacity=25); -moz-opacity: 0.25; opacity: 0.25; 
position: fixed;
    z-index:300;
    top: 0px;
    left: 0px;
    height:100%;
    width:100%; }
    
.TB_window {
    position: fixed;
    background: #ffffff;
    z-index: 302;
    color:#000000;
    display:none;
    border: 10px solid #525252;
    text-align:left;
    top:35%;
    left:50%;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
    width: 500px;
    height: auto;
    margin-left: -250px;
    margin-top: -100px;
}

</style>
<script>
(function($){

    $.widget("ui.dynabox", {
        options: {
            clickerId: '_ID_', 
            clickerOpenClass: 'box-open', 
            boxId: '_ID_-box', 
            itemTempSelector: '.temp',
            listObjSelector: '.list',
            newTagSelector: '_ID_-newtag',
            keepContent: true, 
            url: undefined,
            isFeed: false,
            loadMethod: 'ajax',
            loadType: 'JSON',
            filler: null,
            fillType: null,
            highlightClass: 'new-item',
            highlightUnless: 'viewed',
            newItemIndicator: 'NEW',
            method: 'GET',
            position: 'distinct',
            maxItems: 5,
            expendable: false,
            autoUpdate: true,
            clickerMethod: 'hover',
            showHeader: true,
            showFooter: true,
            headerContent: '',
            footerContent: '',
            allowLoadInside: true,
        },

        _create: function(){

            this._clicker = $('#'+this.options.clickerId.replace('_ID_', this.element.attr('id')));
            this._dynaBox = this.options.position == 'window' ? $.ui.dynabox.window
                            : $('#'+this.options.boxId.replace('_ID_', this.element.attr('id')));
            this._newTag = $('#'+this.options.newTagSelector.replace('_ID_', this.element.attr('id')));
            this._listObj = null;
            this._items = [];
            this._itemTemp = null;
            this._itemLast = null;
            this._isOpen = false;
            this._isFilled = false;
            this._isForm = this.element[0].tagName.toLowerCase() == 'form',
            this._boxesInside = [];
            // remember this instance
            $.ui.dynabox.instances.push(this.element);
        },

        _init: function(){
            if (typeof this.options.loader != 'function') this.resetLoader();
            if (typeof this.options.filler != 'function') this.resetFiller();

            var loc = (''+window.location);
            var anc = new RegExp('#[\\w\.]*$', 'g');
            var url = loc.replace(anc, '');

            this._isOpen = this._dynaBox.is(':visible');
            this.options.url = this.options.url || this._clicker.attr('href') || this._clicker.attr('alt') || url;
            this.options.method = this._clicker.attr('method') || this.options.method;
            if (this._isForm)
            {
                this.options.url = this.element.attr('action') || this.options.url;
            }
            if (this._dynaBox.length == 0) {
                var box = $('<ul class=\"list\"><li class=\"temp\"></li></ul>');
                if (this.options.showHeader) box.prepend($('<li class=\"header\"></li>').html(this.options.headerContent));
                if (this.options.showFooter) box.append($('<li class=\"footer\"></li>').html(this.options.footerContent));
                this._dynaBox = box.wrap('<div></div>').parent();
                this._dynaBox.addClass('TB_window').attr('id', this.options.boxId.replace('_ID_', this.element.attr('id'))).data('dynacon', this).appendTo('body');
            }
            this._listObj = this._dynaBox.find(this.options.listObjSelector);
            this._itemTemp = (this.options.itemTempSelector!=null ? this._listObj.find(this.options.itemTempSelector) : (this._listObj.find('li.header').length == 0 ? this._listObj.find(':first-child') : this._listObj.find(':nth-child(2)')))
                         || $('<li class=\"temp\"></li>').prependTo(this._listObj);
            if (!this._isOpen) this._itemTemp.hide();
            this._itemLast = this._listObj.find('li.last');
            if (this._itemLast.length == 0) 
            {
                this._itemLast = this._itemTemp.clone();
                this._itemLast.insertAfter(this._itemTemp);
            }
            this._itemLast.removeClass('temp').addClass('last');

            var self = this;
            if (this.options.clickerMethod == 'click')
            {
                var act = ($.ui.dynabox.openBox && $($.ui.dynabox.openBox).find(this.element) && this.options.allowLoadInside && this.options.position == 'window' ? function(){$.ui.dynabox.openBox.appendInBox(self); self.load(self.options.filler, {per: 'ff', kor: 'lok'});} : function(){self.toggle();});
                this._clicker.bind('click', function(){act(); return false;});
            }
            else if (this.options.clickerMethod == 'hover')
            {
                this._clicker.bind('click', function(e){self.toggle();return false;});
                this._clicker.hover(function(e){clearTimeout(self._dynaBox.data('tOutId')); if (!self._isOpen) self.open();return false;}, function(e){self._clicker.data('tOutId', setTimeout(function(){self.close();}, 100));});
                this._dynaBox.hover(function(e){clearTimeout(self._clicker.data('tOutId')); }, function(e){self._dynaBox.data('tOutId', setTimeout(function(){self.close();}, 100));});
            }
            if ($('body').data('clicklsnr') != true)
            {
                $('body').bind('mousedown', function(e){if ($.ui.dynabox.openBox!=undefined && $(e.target).closest($.ui.dynabox.openBox._dynaBox).length == 0 && $(e.target).closest($.ui.dynabox.openBox._clicker).length == 0) { $.ui.dynabox.openBox.close(); }});
                $('body').data('clicklsnr', true);
            }
            if ($('body').data('dynupdater') != true)
            {
                var updater = function(){
                    $.each($.ui.dynabox.instances, function(i, e){if ($(e).dynabox('option', 'autoUpdate') && !$(e).dynabox('isOpen')) $(e).dynabox('update');});
                    setTimeout(updater, 10000);
                };
                setTimeout(updater, 10000);
                $('body').data('dynupdater', true);
            }
            this.element.data('isDynaBox', true);
            this.element.data('dynabox', this);
        },

        update: function(){
            this.load(this.options.filler);
            },

        fill: function(data){
            this.options.filler(data);
            },

        load: function(filler){
                this.options.loader(filler);
            },

        open: function(){
            if (this._isOpen) return false;

            // trigger beforeopen event.  if beforeopen returns false,
            // prevent bail out of this method. 
            if( this._trigger("beforeopen") === false ){
                return;
            }

            // call methods on every other instance of this dialog
            $.each( this._getOtherInstances(), function(){
                var $this = $(this);
                if($this.dynabox("isOpen")){
                    $this.dynabox("close");
                }
            });

            this._clicker.addClass(this.options._clickerOpenClass);
            if (this.options.position == 'window') { 
                $('body').data('dynoverlay', $('<div class=\"TB_overlay\"></div>').appendTo('body'));
            }
            this._dynaBox.show();
            this._isOpen = true;

            if (!this._isFilled || (this._isFilled && !this.options.keepContent)){
                this.load(this.options.filler);
            }

            $.ui.dynabox.openBox = this;

            // trigger open event
            this._trigger("open");

            return this;
        },

        close: function(){
            if (!this._isOpen) return false;

            // trigger beforeclose event.  if beforeclose returns false,
            // prevent bail out of this method. 
            if( this._trigger("beforeclose") === false ){
                return;
            }

            $.each(this._boxesInside, function(){this.close();});

            this._dynaBox.hide();
            if (this.options.position == 'window') { $('body').data('dynoverlay').remove(); }

            if (!this.options.keepContent) { this.empty(); }
            this._clicker.removeClass(this.options.clickerOpenClass);

            this._isOpen = false;

            // trigger close event
            this._trigger("close");

            if (this.options.isFeed && this.options.highlightUnless == 'viewed')
            {
                this._listObj.find('> li').removeClass(this.options.highlightClass);
                this._newTag.text('').hide();
            }

            $.ui.dynabox.openBox = undefined;

            return this;
        },

        toggle: function(){
                if (this._isOpen) this.close(); else this.open();
            },

        isOpen: function(){
            return this._isOpen;
        },

        resetFiller: function(){
            var o = this;
            o.options.filler = function(data){
                if (o.options.loadType == 'JSON')
                {
                    var items = (o.options.isFeed ? data.ITEMS : data);
                    $(items).each(function(j, pl){
                        var newli = o._itemTemp.clone();
                        for (key in pl) {newli.html(newli.html().replace('_'+key+'_', pl[key]));}
                        if (o.options.newItemIndicator in pl && pl[o.options.newItemIndicator] == true) newli.addClass(o.options.highlightClass);
                        var exists = false;
                        o._listObj.children().each(function(i,c){return !(exists = $(c).html()==newli.html());});
                        if (!exists){
                            if (o._isFilled)
                                newli.insertAfter(o._itemTemp).show();
                            else
                                newli.insertBefore(o._itemLast).show();
                            o._itemTemp.nextUntil(o._itemLast).slice(o.options.maxItems).remove();
                        }
                        return (o.options.maxItems <= 0 || (o.options.maxItems > 0 && j+1 < o.options.maxItems));
                    });
                    if (o.options.isFeed && o._newTag && data.NEW > 0)
                        o._newTag.text(data.NEW).show();
                    else
                        o._newTag.text('').hide();
                }
                else if (o.options.loadType == 'html')
                {
                    (o._itemTemp.hide().clone()).removeClass('temp').addClass('item').html($(data).find('body').text()).insertAfter(o._itemTemp).show();
                    if ($(data).find('header').length > 0) o._listObj.find('li.header').html($(data).find('header').text());
                    if ($(data).find('footer').length > 0) o._listObj.find('li.footer').html($(data).find('footer').text());
                    if ($(data).find('init').length > 0) eval($(data).find('init').text());
                }
                o._isFilled = true;
            };
        },

        resetLoader: function(){
            var o = this;
            o.options.loader = function(filler, params){
                if (!o._isFilled || o._loadType == 'html') {
                    o._listObj.addClass('loading');
                    o._listObj.find('li.item').hide();
                }
                params = (o._isForm ? o.element.serialize() : '');
                var isFill = (typeof filler == 'function');
                switch (o.options.loadMethod)
                {
                 case 'ajax':
                    switch (o.options.loadType)
                    {
                    case 'JSON':
                        $.ajax({url: o.options.url, dataType: 'json', async: false, cache: false, method: o.options.method, data: params, 
                            success: function(data){
                                o._listObj.removeClass('loading');
                                if (isFill) filler(data); else return data;
                            }
                        });
                        break;
                    default: /* html */
                        $.ajax({
                            url: o.options.url,
                            method: o.options.method,
                            cache: false,
                            success: function(data){
                                o._listObj.removeClass('loading');
                                o._listObj.find('li.item').remove();
                                if (isFill) filler(data); else return data;
                            },
                            dataType: 'xml',
                            data: params
                        });
                        break;
                    }
                    break;
                case 'static':
                    switch (o.options.loadType)
                    {
                    case 'copy': 
                        if (isFill) filler($(o.options.sourceElement).html()); else return $(o.options.sourceElement).html();
                        break;
                    case 'param':
                        if (isFill) filler(o.options.content); else return o.options.content;
                        break;
                    }
                    break;
                }
            };    
        },

        appendInBox: function(box){
            if ($.inArray(box, this._boxesInside) == -1)
                this._boxesInside.push(box);
        },

        empty: function(){
            if (this._isFilled)
            {
                if (this.options.loadType == 'JSON')
                    this._itemTemp.nextUntil(this._itemLast).remove();
                else if (this.options.loadType == 'html')
                    this._itemTemp.children().remove();
            }
            this._listObj.find('li.footer').html('');
            this._isFilled = false;
        },

        destroy: function(){
            // remove this instance from $.ui.dynabox.instances
            var element = this.element,
                position = $.inArray(element, $.ui.dynabox.instances);

            // if this instance was found, splice it off
            if(position > -1){
                $.ui.dynabox.instances.splice(position, 1);
            }

            // call the original destroy method since we overwrote it
            $.Widget.prototype.destroy.call( this );
        },

        _getOtherInstances: function(){
            var element = this.element;

            return $.grep($.ui.dynabox.instances, function(el){
                return el !== element;
            });
        },

        _setOption: function(key, value){
            this.options[key] = value;

            switch(key){
                case "something":
                    // perform some additional logic if just setting the new
                    // value in this.options is not enough. 
                    break;
            }
        }
    });

    $.extend($.ui.dynabox, {
        instances: [],
        openBox: undefined,
        window: $('<div class="TB_window"><ul class="list"><li class="header"></li><li class="temp"></li><li class="last"></li><li class="footer"></li></div>').appendTo('body').hide()
    });

})(jQuery);
</script>
<?php echo javascript_tag("

$('#ua-peer').dynabox({clickerMethod: 'hover', highlightUnless: 'clicked', isFeed: true});
$('#ua-bing').dynabox({clickerMethod: 'click', highlightUnless: 'viewed', isFeed: true});
$('#ua-thick').dynabox({clickerMethod: 'click', position: 'window', headerContent: 'slm', loadMethod: 'ajax', loadType: 'html', autoUpdate: false, keepContent: false});

") ?>

<? /*
 if (!function_exists('mb_ucfirst') && function_exists('mb_substr')) {
    function mb_ucfirst($string) {
        $string = mb_strtoupper(mb_substr($string,0,1, 'UTF-8'), 'UTF-8').mb_strtolower(mb_substr($string, 1, mb_strlen($string)-1, 'UTF-8'), 'UTF-8');
        return $string;
    }
}
 ?>
<?php $usrs = UserPeer::doSelect(new Criteria()) ?>
<?php foreach ($usrs as $usr): ?>
<?php echo $usr."\t".mb_convert_case($usr, MB_CASE_TITLE, 'UTF8') ?><br />
<?php endforeach ?>
<?php */ ?>
