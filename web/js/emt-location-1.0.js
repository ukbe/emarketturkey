(function($){

    $.widget("ui.location", {
        options: {
            countryId: '_ID_', 
            stateId: null,
            selected: null,
            url: null,
            initStates: false,
            paramKey: 'cc',
            beforeload: null,
            complete: null
        },

        _create: function(){

            this._country = $('#'+this.options.countryId.replace('_ID_', this.element.attr('id')));
            this._state = this.options.stateId ? $(this.options.stateId) : $('#'+this.element.attr('id').replace('country', 'state'));

            this._updated = this.options.initStates ? false : true;
            this._selected = this._country.val();

            var self = this;
            this._country.change(function(){
            	self._selected = $(this).val();
            	self.update();
            });

            // remember this instance
            $.ui.location.instances.push(this.element);

        },

        _init: function(){

            if (!(this._updated))
            {
            	this.select(this.options.selected ? this.options.selected : this._selected);
            }
            
            if (typeof this.options.beforeload == 'function')
        	{
            	this.bind('beforeload', this.options.beforeLoad);
        	}

            if (typeof this.options.complete == 'function')
            {
            	this.bind('complete', this.options.complete);
            }
            
            this.element.data('isLocationWidget', true);
            this.element.data('locationWidget', this);
        },

        select: function(item_id){
        	if (this._country.find('option[value='+item_id+']').length)
    		{
	        	this._country.find('option[value!='+item_id+']').removeAttr('selected');
	        	this._country.find('option[value='+item_id+']').attr('selected', 'selected');
	        	this._selected = item_id;
	            this.update();
    		}
        },

        update: function(){
            	var o = this;
            	var params = {};
            	params[o.options.paramKey] = this._selected;

	            $.ajax({url: o.options.url, dataType: 'jsonp', async: true, cache: false, type: 'GET', data: params, 
	            	beforeSend: function(){
		                o._country.attr('disabled', true);
		                o._state.attr('disabled', true);

	                	// trigger beforeopen event.  if beforeopen returns false,
		                // prevent bail out of this method. 
		                if( o._trigger("beforeload", null, o) === false ){
		                    return;
		                }
	            	},
	            	complete: function(e){
		                o._country.attr('disabled', false);
		                o._state.attr('disabled', false);
		                // trigger beforeopen event.  if beforeopen returns false,
		                // prevent bail out of this method. 
		                if( o._trigger("complete", null, o) === false ){
		                    return;
		                }
	            	},
	                success: function(data){
	                    o._state.find("option[value!='']").remove();
                        $(data).each(function(g,i){o._state.append($('<option value='+i.ID+'>'+i.NAME+'</option>'));});
	                }    
	            });
            },
            
        destroy: function(){
            // remove this instance from $.ui.location.instances
            var element = this.element,
                position = $.inArray(element, $.ui.location.instances);

            // if this instance was found, splice it off
            if(position > -1){
                $.ui.location.instances.splice(position, 1);
            }

            // call the original destroy method since we overwrote it
            $.Widget.prototype.destroy.call( this );
        },

        _getOtherInstances: function(){
            var element = this.element;

            return $.grep($.ui.location.instances, function(el){
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

    $.extend($.ui.location, {
        instances: [],
    });

})(jQuery);
