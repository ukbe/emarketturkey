(function($){

    $.widget("ui.dynabox", {
        options: {
            clickerId: '_ID_', 
            clickerOpenClass: 'box-open', 
            boxId: '_ID_-box', 
            itemTempSelector: '.temp',
            sourceElement: '_ID_-src',
            listObjSelector: '.list',
            newTagSelector: '#_ID_-newtag',
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
            autoUpdate: false,
            clickerMethod: 'hover',
            clickerLetGo: false,
            showHeader: true,
            showFooter: true,
            headerContent: '',
            footerContent: '',
            allowLoadInside: true,
            hoverDelay: 1000,
        },

        _create: function(){

            this._clicker = $('#'+this.options.clickerId.replace('_ID_', this.element.attr('id')));
            this._dynaBox = this.options.position == 'window' ? $.ui.dynabox.window
                            : $('#'+this.options.boxId.replace('_ID_', this.element.attr('id')));
            this._newTag = $(this.options.newTagSelector.replace('_ID_', this.element.attr('id')));
            this._srcElement = $(this.options.sourceElement.replace('_ID_', this.element.attr('id')));
            this._listObj = null;
            this._items = [];
            this._itemTemp = null;
            this._itemLast = null;
            this._isOpen = false;
            this._isFilled = false;
            this._isForm = this.element[0].tagName.toLowerCase() == 'form',
            this._boxesInside = [];
            this._headeron = this.options.showHeader;
            this._footeron = this.options.showFooter;
            // remember this instance
            $.ui.dynabox.instances.push(this.element);
        },

        _init: function(){
            if (typeof this.options.loader != 'function') this.resetLoader();
            if (typeof this.options.filler != 'function') this.resetFiller();
            
            if (this._newTag.text() == '') this._newTag.hide().closest('div.new-holder').hide();
            	
            var loc = (''+window.location);
            var anc = new RegExp('#[\\w\.]*$', 'g');
            var url = loc.replace(anc, '');

            this._isFilled = this.options.loadMethod == 'static' && this.options.loadType == 'none';

            this._isOpen = this._dynaBox.is(':visible');
            this.options.url = this.options.url || this._clicker.attr('href') || this._clicker.attr('alt') || url;

            this.options.method = this._clicker.attr('method') || this.options.method;
            if (this._isForm)
            {
                this.options.url = this.element.attr('action') || this.options.url;
            }

            var hostreg = new RegExp('(http(s)://)?([^/]+)(/\w+)?', 'gi');
            var origin = this.options.url.match(hostreg);
            if (window.location.host !== origin[1] && this.options.url[0] != '/')
            {
            	this.options.loadType = 'JSON';
            }
            
            if (this._dynaBox.length == 0) {
                if (this.options.position == 'distinct')
                {
                    var box = $('<ul class=\"list\"><li class=\"temp\"></li></ul>');
                    if (this.options.showHeader) box.prepend($('<li class=\"header\"></li>').html(this.options.headerContent));
                    if (this.options.showFooter) box.append($('<li class=\"footer\"></li>').html(this.options.footerContent));
                    this._dynaBox = box.wrap('<div></div>').parent();
                    this._dynaBox.addClass('TB_window').attr('id', this.options.boxId.replace('_ID_', this.element.attr('id'))).data('dynacon', this).appendTo('body');
                }
                else
                {
                    this._dynaBox = $.ui.dynabox.window;
                }
                this._dynaBox.hide();
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
            this._itemLast.removeClass('temp').addClass('last').hide();
            this._footer = this._dynaBox.find('li.footer');
            this._header = this._dynaBox.find('li.header');

            var self = this;
            if (this.options.clickerMethod == 'click')
            {
                var act = ($.ui.dynabox.openBox && this.element.closest($.ui.dynabox.openBox._dynaBox).length > 0 && this.options.allowLoadInside && this.options.position == 'window' ? function(){$.ui.dynabox.openBox.appendInBox(self); self.load(self.options.filler, {per: 'ff', kor: 'lok'});} : function(){self.toggle();});
                this._clicker.bind('click', function(){act(); return false;});
            }
            else if (this.options.clickerMethod == 'hover')
            {
                if (!self.options.clickerLetGo) this._clicker.bind('click', function(e){self.toggle();return false;});
                this._clicker.hover(function(e){clearTimeout(self._dynaBox.data('tOutId')); if (!self._isOpen) self.open();return false;}, function(e){self._dynaBox.data('tOutId', setTimeout(function(){self.close();}, self.options.hoverDelay));});
                this._dynaBox.hover(function(e){clearTimeout(self._dynaBox.data('tOutId')); }, function(e){self._dynaBox.data('tOutId', setTimeout(function(){self.close();}, self.options.hoverDelay));});
            }
            if ($('body').data('clicklsnr') != true)
            {
                $('body').bind('mousedown', function(e){if ($.ui.dynabox.openBox!=undefined && $(e.target).closest($.ui.dynabox.openBox._dynaBox).length == 0 && $(e.target).closest($.ui.dynabox.openBox._clicker).length == 0 && $(e.target).closest('ul.ui-autocomplete').length == 0 && $(e.target).closest('#calroot').length == 0) { $.ui.dynabox.openBox.close(); }});
                $('body').data('clicklsnr', true);
            }
            if ($('body').data('dynupdater') != true)
            {
                var updater = function(){
                    $.each($.ui.dynabox.instances, function(i, e){if ($(e).dynabox('option', 'autoUpdate') && !$(e).dynabox('isOpen')) $(e).dynabox('update');});
                    setTimeout(updater, 60000);
                };
                setTimeout(updater, 60000);
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
            if( this._trigger("beforeopen", null, this) === false ){
                return;
            }
            
            if (this.options.showHeader) this._header.show(); else this._header.hide();
            if (this.options.showFooter) this._footer.show(); else this._footer.hide();

            // call methods on every other instance of this dialog
            $.each( this._getOtherInstances(), function(){
                var $this = $(this);
                if($this.dynabox("isOpen")){
                    $this.dynabox("close");
                }
            });

            this._clicker.addClass(this.options.clickerOpenClass);
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
            this._trigger("opened");

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
            this._trigger("closed");

            if (this.options.isFeed && this.options.highlightUnless == 'viewed')
            {
                this._listObj.find('> li').removeClass(this.options.highlightClass);
                this._newTag.text('').hide().closest('div.new-holder').hide();
            }

            $.ui.dynabox.openBox = undefined;

            return this;
        },

        toggle: function(){
            if (this._isOpen) this.close(); else this.open();
        },
        
        hideHeaderFooter: function(){
        	this._header.hide();
        	this._footer.hide();
        	this._headeron = false;
        	this._footeron = false;
        },
        
        hideHeader: function(){
        	this._header.hide();
        	this._headeron = false;
        },
        
        hideFooter: function(){
        	this._footer.hide();
        	this._footeron = false;
        },
        
        showHeaderFooter: function(){
        	this._header.show();
        	this._footer.show();
        	this._headeron = true;
        	this._footeron = true;
        },
        
        showHeader: function(){
        	this._header.show();
        	this._headeron = true;
        },
        
        showFooter: function(){
        	this._footer.show();
        	this._footeron = true;
        },
        
        isOpen: function(){
            return this._isOpen;
        },

        resetFiller: function(){
            var o = this;
            o.options.filler = function(data){
            	if (o.options.loadMethod == 'ajax' && $(data).find('emtRedirect').length)
        		{
            		window.location.href = $(data).find('emtRedirect').text();
        		}
                if (o.options.loadType == 'JSON' && o.options.isFeed)
                {
                    var items = (o.options.isFeed ? data.ITEMS : data);
                    $(items).each(function(j, pl){
                        var newli = o._itemTemp.clone();
                        newli.removeClass('temp').addClass('item');
                        for (key in pl) {newli.html(newli.html().replace(new RegExp('_'+key+'_', 'g'), pl[key]));}
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
                	{
                        o._newTag.text(data.NEW).show().closest('div.new-holder').show();
                	}
                    else
                	{
                        o._newTag.text('').hide().closest('div.new-holder').hide();
                	}
                    if (o._listObj.find('li.item').length > 0)
                        o._listObj.find('li.empty').hide();
                    else
                        o._listObj.find('li.empty').show();
                }
                else if (o.options.loadType == 'xml' || (o.options.loadType == 'JSON' && !(o.options.isFeed)))
                {
                    if (o.options.loadMethod == 'ajax')
                    {
                        (o._itemTemp.hide().clone()).removeClass('temp').addClass('item').html($(data).find('emtBody').html()).insertAfter(o._itemTemp).show();
                        if ($(data).find('emtHeader').length > 0) o._listObj.find('li.header').html($(data).find('emtHeader').html()).show();
                        if ($(data).find('emtFooter').length > 0) o._listObj.find('li.footer').html($(data).find('emtFooter').html()).show();
                        //if ($(data).find('emtInit').length > 0) eval("("+$(data).find('emtInit').text()+")");
                        if ($(data).find('emtInit').length > 0) { var func = eval("(function(){"+$(data).find('emtInit').text()+"})"); func(); }
                    }
                    else
                    {
                        if (!o._isFilled) (o._itemTemp.hide().clone()).removeClass('temp').addClass('item').html(data).insertAfter(o._itemTemp).show();
                    }
                }
                else if (o.options.loadType == 'html')
                {
                    if (o.options.loadMethod == 'ajax')
                    {
                        (o._itemTemp.hide().clone()).removeClass('temp').addClass('item').html($(data).find('emtBody').html()).insertAfter(o._itemTemp).show();
                        if ($(data).find('emtHeader').length > 0) o._listObj.find('li.header').html($(data).find('emtHeader').html()).show(); else o._header.hide();
                        if ($(data).find('emtFooter').length > 0) o._listObj.find('li.footer').html($(data).find('emtFooter').html()).show(); else o._footer.hide();
                        if ($(data).find('emtInit').length > 0) { var func = eval("(function(){"+$(data).find('emtInit').text()+"})"); func(); }
                    }
                    else
                    {
                        if (!o._isFilled) (o._itemTemp.hide().clone()).removeClass('temp').addClass('item').html(data).insertAfter(o._itemTemp).show();
                    }
                }
                if (o.options.position=='window' && o._listObj.height() > 0.6 * $('.TB_overlay').height())
                {
                    o._dynaBox.addClass('flooded');
                    o._listObj.find('li.item').css('height', 0.6*$('.TB_overlay').height());
                }
                else
                {
                    o._dynaBox.removeClass('flooded');
                    o._listObj.find('li.item').css('height', 'auto');
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
                        $.ajax({url: o.options.url, dataType: 'jsonp', async: true, cache: false, type: o.options.method, data: params, 
                            success: function(data){
                                o._listObj.removeClass('loading');
                                if (!(o.options.isFeed))
                            	{
                                	if (isFill) {filler(data.content); return;} else return data.content;
                            	}
                                if (isFill) filler(data); else return data;
                            }
                        });
                        break;
                    case 'xml':
                        $.ajax({
                            url: o.options.url,
                            async: true,
                            type: o.options.method,
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
                    default: /* html */
                        $.ajax({
                            url: o.options.url,
                            async: true,
                            type: o.options.method,
                            cache: false,
                            success: function(data){
                                o._listObj.removeClass('loading');
                                o._listObj.find('li.item').remove();
                                if (isFill) filler(data); else return data;
                            },
                            dataType: 'html',
                            data: params
                        });
                        break;
                    }
                    break;
                 case 'static':
                     switch (o.options.fillType)
                     {
                     case 'copy': 
                         if (isFill) filler($(o._srcElement).html()); else return $(o._srcElement).html();
                         break;
                     case 'param':
                         if (isFill) filler(o.options.content); else return o.options.content;
                         break;
                     case 'none':
                    	 if (isFill) filler();
                    	 break;
                     }
                     o._listObj.removeClass('loading');
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
            this._listObj.find('li.header').html('');
            this._listObj.find('li.item').remove();
            if (this._dynaBox.hasClass('flooded'))
        	{
                this._dynaBox.removeClass('flooded');
                this._listObj.find('li.item').css('height', '');
            }
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
        window: $('<div id="TB_window" class="TB_window"><ul class="list"><li class="header"></li><li class="temp"></li><li class="last"></li><li class="footer"></li></div>')
    });

})(jQuery);

$(function() {
 $.ui.dynabox.window.appendTo('body').hide();
});