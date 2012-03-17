jQuery.fn.hierarchyselector = function(options){
    var o = $(this[0]);
    var settings = {queryUrl: '/', paramKey: 'id', sendKey: 'id', selectComplete: function(ctid, data){}, staticParams: {} };
    if (options) {$.extend(settings, options)}
    $.extend(o, {levels: $(new Array()), rootChild: o.find('li.hs-part:first'), label: $('label[for='+settings.sendKey+']'), genericId: o.find('li.hs-part:first > select.hs-selector').attr('id'), emptyli: $('<li class=\"hs-part\"><select class=\"hs-selector\"><option value=\"\"></option></select></li>'),
        removeChild: function (bl) {
            bl.childHs.remove();
        },
        setupChild: function(dl, parent){
            $.extend(dl, {selector: $(dl).find('select.hs-selector'), value: '', parentHs: parent, index: $.inArray(dl, o.levels), childHs: undefined,  
                remove: function(){
                    if (this.childHs.length){
                        this.childHs.remove();
                        this.childHs = undefined;
                    }
                    if (this.parentHs.length){
                        this.parentHs.childHs = undefined;
                    }
                    x = $.inArray(this, o.levels);
                    o.levels.splice(x);
                    $(this).remove();
                },
                disable: function(){
                    if (dl.childHs && dl.childHs.length) dl.childHs.selector.attr('disabled', true);
                    dl.selector.attr('disabled', true);
                },
                enable: function(){
                    if (dl.childHs && dl.childHs.length) dl.childHs.selector.attr('disabled', false);
                    dl.selector.attr('disabled', false);
                }
            });
            dl.value = dl.selector.val();
            o.levels.each(function(i,kl){ if ($(dl).attr('id') == o.genericId + '_item_' + $(kl).value) {kl.childHs = dl;dl.parentHs = kl;}});
            dl.selector.change(function(){
                if (this.value != '' && dl.value != this.value)
                {
                    var p = this.value;
                    dl.disable();
                    var params = settings.staticParams;
                    params[settings.paramKey] = p;
                    $.getJSON(settings.queryUrl, params, 
                        function(d){
                            var items = d.ITEMS;
                            if (dl.childHs) dl.childHs.remove();
                            dl.value = p;
                            if (items.length > 0)
                            {
                            	if (!settings.isArrayInput) dl.selector.attr('name', dl.selector.attr('id'));
                                var newLi = o.emptyli.clone();
                                $(items).each(function(i,g){newLi.find('select.hs-selector').append($('<option value='+g.ID+'>'+g.NAME+'</option>'));});
                                newLi.attr('id', o.genericId+'_item_'+dl.value);
                                newLi.find('select.hs-selector').attr({'id': o.genericId+'_'+dl.value, 'name': o.rootChild.selector.attr('name')});
                                o.setupChild(newLi, dl);
                                o.append(dl.childHs);
                                o.label.attr('for', newLi.selector.attr('id'));
                            }
                            else
                            {
                                if (!settings.isArrayInput) dl.selector.attr({name: settings.sendKey});
                                o.label.attr('for', dl.selector.attr('id'));
                                settings.selectComplete(dl.selector.attr('value'), d);
                            }
                        }
                    )
                    .error(function(e,str){})
                    .complete(function(){dl.enable();});
                }
                else if (this.value == '')
                {
                    if (dl.childHs) dl.childHs.remove();
                    dl.value = '';
                }
                else {
                    return false;
                }
            });
            if ($.inArray(dl, o.levels) < 0) o.levels.push(dl);
            o.levels.push(dl);
            dl.index = $.inArray(dl, o.levels);
            dl.childHs = o.find('#'+o.genericId+'_item_'+dl.value);
            if (dl.parentHs) dl.parentHs.childHs = dl;
            if (dl.childHs.length) 
                o.setupChild(dl.childHs, dl);
            else {
                dl.selector.attr('name', settings.isArrayInput ? o.rootChild.attr('name') : settings.sendKey);
                o.label.attr('for', dl.attr('id'));
            }
            //dl.selector.change();
        },
        retHs: function(val, st){
            o.levels.each(function(){if (this.value == val) return this;});
        }
    });
    o.emptyli.find('select.hs-selector option:selected').removeAttr('selected');
    o.setupChild(o.rootChild);
    //o.levels.each(function(i,pl){ o.setupChild(pl); if (i==o.levels.length-1) o.label.attr('for', pl.selector.attr('id'));});
};
