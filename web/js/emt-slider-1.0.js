(function($){

    $.widget("ui.emtslider", {
        options: {
            nav: '._ID_-navi',
            toggleClass: 'ghost',
            delay: 5000,
            hideSpeed: 'fast',
            showSpeed: 'slow',
            parallelPack: null
        },

        _create: function(){

        },

        _init: function(){
        	var o = this.element;
        	var self = this;
        	this._index = 0;
        	this._items = o.find('.items > *');
        	this._nav = $(this.options.nav.replace('_ID_', this.element.attr('id')));
        	if (this._nav.length && !this._nav.children().length)
    		{
        		this._items.each(function(i, p){ var a = $('<a></a>');a.appendTo(self._nav);a.click(function(){ self._goto(i); });  });
        		this._nav.items = this._nav.children();
    		}
        	this._apply();
        	this._parallel = this.options.parallelPack ? $(this.options.parallelPack.replace('_ID_', this.element.attr('id'))) : null;
        	if (this._parallel && this._parallel.length) {this._parallel.items = this._parallel.children();}
        	this._timerFunc = function() {
            	self._next();
            	self._timer = setTimeout(function(){self._timerFunc();}, self.options.delay);
            }
        	this._items.mouseover(function(){clearTimeout(self._timer);});
        	this._items.mouseout(function(){self._timer = setTimeout(self._timerFunc, self.options.delay);});
        	self._timer = setTimeout(function(){self._timerFunc();}, self.options.delay);
        },
        
        _apply: function(){
        	var self = this;
        	this._items.filter(':not(:eq('+this._index+'))').fadeOut(this.options.hideSpeed);
        	if (this._parallel) this._parallel.items.filter(':not(:eq('+this._index+'))').fadeOut(this.options.hideSpeed);
        	this._items.filter(':eq('+this._index+')').fadeIn(this.options.showSpeed);
        	if (this._parallel) this._parallel.items.filter(':eq('+this._index+')').fadeIn(this.options.showSpeed);
        	if (this._nav.length)
        	{
    			this._nav.items.filter(':not(:eq('+this._index+'))').removeClass('active');
    			this._nav.items.filter(':eq('+this._index+')').addClass('active');
			}
        	// trigger afterChange
        	this._trigger("afterchange", null, this._index);
        },
        
        _next: function(){
            // trigger beforechange
        	if(this._trigger('beforechange', null, this._index) === false){
        		return;
        	}

        	this._index = (this._index+1 >= this._items.length ? 0 : this._index+1);
        	this._apply();
        },
        
        _goto: function(ind){
        	if (ind >= 0 && ind < this._items.length)
    		{
        		var self = this;
	        	// trigger beforechange
	        	if(this._trigger('beforechange', null, this._index) === false){
	        		return;
	        	}
	        	clearTimeout(this._timer);

	        	this._index = ind;
	        	this._apply();
	        	
	        	this._timer = setTimeout(function(){self._timerFunc();}, this.options.delay);
    		}
        },
        
    });

})(jQuery);