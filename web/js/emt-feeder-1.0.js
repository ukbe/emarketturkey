(function($){

    $.widget("ui.emtfeeder", {
        options: {
            clicker: '._ID_-more',
            bookmark: null,
            paramName: 'bookmark',
            url: null,
            replace: false,
        },

        _create: function(){

        },

        _init: function(){
        	var o = this.element;
        	var self = this;
        	this._bookmark = this.options.bookmark;
        	this._isTable = (o[0].tagName == 'TABLE');
        	this._colNum = this._isTable ? this.element.find('tr:first-child td').length : 0;
        	this._more = $(this.options.clicker.replace('_ID_', this.element.attr('id')));

        	var loc = (''+window.location);
            var anc = new RegExp('#[\\w\.]*$', 'g');
            var url = loc.replace(anc, '');
        	this._url = this.options.url || url;

        	if (!this._more.length)
    		{
        		var more = $('<a class="feeder-more">more</a>').attr('href', this._url);
        		more.wrap('<td></td>').parent().attr('colspan', this._colNum).wrap('<tr></tr>').parent().addClass('more-row').appendTo(this.element);
        		this._more = o.find('.feeder-more');
        		this._more.click(function(){self._feed(); return false;});
    		}

        },

        _feed: function(){
            // trigger beforechange
        	if(this._trigger('beforechange', null, this._index) === false){
        		return;
        	}

        	this._load(this._bookmark);
        },
        
        _load: function(bmark){
    		var self = this;
            this.element.addClass('loading');
        	var params = {};
        	params[this.options.paramName] = bmark;
            $.ajax({url: this._url, dataType: 'jsonp', async: true, cache: false, type: self.options.method, data: params, 
                success: function(data){
                    self.element.removeClass('loading');
                    self._update(data);
                }
            });
        	
        },
        
        _update: function(data){
    		var self = this;
            // trigger beforechange
        	if(this._trigger('beforeupdate', null, this) === false){
        		return;
        	}

    		if (this.options.replace)
			{
    			this.element.find('tr._d').fadeOut(300, function(){ $(this).remove(); });
			}

    		setTimeout(function(){
				self._more.closest('tr').before(data.CONTENT);
				self._bookmark = data.BOOKMARK;
				$('html, body').animate({scrollTop: self.element.offset().top-50}, 0);
				if (data.ISLASTPAGE) self._more.hide();
				window.initElementsScript(self.element);
				// trigger update
				self._trigger('update', null, self);
			}, 300);
    		
        },
        
    });

})(jQuery);