(function($){

    $.widget("ui.branch", {
        options: {
            map: {},
            method: 'anim',
            toggleClass: 'ghost',
        },

        _create: function(){
            var o = this;
            this._map = {};

            this._value = this.element.val();
            
            for (val in this.options.map) {
                this._map[val] = $(this.options.map[val]);
                if (this._value != val) this._switch(this._map[val], 'hide');
            }

            this.element.change(function(){o._update();});
            this._update();
        },

        _update: function(){
            if (this._map[this._value]) this._switch(this._map[this._value], 'hide');
            
            this._value = this.element.val();
            for (val in this._map) {
                if (this._value == val) this._switch(this._map[val], 'show');
            }
        },
        
        _switch: function(item, act){
            if (this.options.method == 'anim')
                act == 'toggle' ? item.toggle() : act == 'hide' ? item.hide() : item.show();
            else if (this.options.method == 'class')
                act == 'toggle' ? item.toggleClass(this.options.toggleClass) : act == 'hide' ? item.addClass(this.options.toggleClass) : item.removeClass(this.options.toggleClass);
        }       
    });

})(jQuery);