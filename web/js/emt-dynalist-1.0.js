(function($){

    $.widget("ui.dynalist", {
        options: {
          defaultText:'add a tag',
          minChars:2,
          width: 'auto',
          height: 'auto',
          autoCompleteConf: null,
          unique: true,
          removeWithBackspace:true,
          itemValueMatrix: {tagLabel: 'label', item_id: 'id', item_type_id: 'type_id'},
          data: {},
          mapFields: {},
          maxAllowedItems: 20
        },

        _create: function(){
            var self = this;
            this._list = $(this.element[0]);
            this._id = this._list.attr('id');
            this._list.addClass('tagBlock');
            this._input = $('<input type=text />').appendTo(this._list).attr('id', this._id + '_tagInput').addClass('tagInput');
            this._data = [];
            var _data = $(this.options.data.length ? this.options.data : []);
            _data.each(function(l,p){ self.addItem(p, l); });
            // remember this instance
            $.ui.dynalist.instances.push(this.element);
        },
        
        addItem: function(item, index){
            var self = this;
            var inputs = [];
            index = index ? index : this._data.length;
            for (key in self.options.mapFields)
            {
                inputs.push('<input type=hidden name='+self.options.mapFields[key]+' value='+item[key]+' />');
            }
            $('<a href="#"></a>').text(item.LABEL).click(function(e){ $(this).parent().remove(); self._data.splice(index, 1); if (self._data.length < self.options.maxAllowedItems) self._input.attr('disabled', false); e.stopPropagation(); }).wrap('<div></div>').parent().attr('rel', self._id + '_' + index).addClass('recipient').insertBefore(self._input).append($(inputs.join()));
            this._data.push(item);
            if (self._data.length >= self.options.maxAllowedItems) self._input.attr('disabled', true);
        },

        _init: function(){
            var self = this;
            self._list.click(function(e){ self._input.focus(); });
            if (this.options.autoCompleteConf)
            {
                var conf = {
                    dataType: 'jsonp',
                    data: {
                        maxRows: 12,
                    }
                };
                $.extend(conf, self.options.autoCompleteConf);
                $.ajaxSetup({async: false});
                $.getScript('/js/jquery.ui-1.8.14.autocomplete.js');
                $.ajaxSetup({async: true});
                this._input.autocomplete({
                    source: function( request, response ) {
                        $.extend(conf.data, {keyword: request.term});
                        $.extend(conf, {success: function( data ) {
                                                response( data.ITEMS );
                                            }
                                        }
                        );
                        $.ajax(conf);
                    },
                    minLength: self.minChars,
                    select: function( event, ui ) {
                        self.addItem(ui.item);
                        self._input.focus();
                        self._list.animate({scrollTop: self._input.offset().top}, 500);
                    },
                    open: function() {
                        $( this ).removeClass( 'ui-corner-all' ).addClass( 'ui-corner-top' );
                    },
                    close: function() {
                        $( this ).removeClass( 'ui-corner-top' ).addClass( 'ui-corner-all' );
                    }
                })
                .data( 'autocomplete' )._renderItem = function( ul, item ) {
                    var clss = [];
                    for (key in self.options.classMap) clss.push(self.options.classMap[key][item[key]]);
                    return $('<li></li>')
                        .data('item.autocomplete', item)
                        .append('<a>' + (self.options.includeSpan ? '<span></span>' : '') + (item.LABEL.length > 50 ? item.LABEL.substr(0, 50) + '...' : item.LABEL) + '</a>')
                        .addClass(clss.join(' '))
                        .appendTo(ul);
                };    
            }
            
        },
    });

    $.extend($.ui.dynalist, {
        instances: []
    });

})(jQuery);