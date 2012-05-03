(function($){

    $.widget("ui.langform", {
        options: {
			availangs: {'tr': [0, 'Turkish'], 'en': [0, 'English']},
			beforeAdd: undefined,
			afterAdd: undefined
        },

        _create: function(){
        	var o = $(this.element);
        	
        	this._blocks = o.find('dl.ln-part');
        	this._addlink = o.find('a.ln-addlink');
        	this._lastblock = o.find('dl.ln-part:last').next();
        	this._emptydl = o.find('dl.ln-part:first').clone();
        	this._inited = false;
        	this._beforeAdd = this.options.beforeAdd;
        	this._afterAdd = this.options.afterAdd;

        	// remember this instance
        	$.ui.langform.instances.push(this.element);
        },
        
        _init: function(){
    		var o = this;
    		o._emptydl.find('select.ln-select option:selected').removeAttr('selected');
            o._emptydl.find('.error').removeClass('error');
            o._emptydl.find('input, textarea').val('').html('');
            o._blocks.each(function(i,pl){ o._setupBlock(pl); });
            
            if (o._blocks.length >= Object.keys(o.options.availangs).length) o._addlink.hide();
            
            o._addlink.click(function(){
            	// This should be removed in the future
                if (typeof o._beforeAdd == 'function' && (o._beforeAdd() == false)) return false;

                var pl = o._emptydl.clone();
                o._setupBlock(pl);
                pl.find('.ln-remove').remove();
                pl.find('.ln-show').removeClass('ghost');
                pl.find('label').removeClass('error');
                pl.find('em.err').remove();
                pl.select.find('option').each(function(i,el){if (el.value in o.options.availangs && o.options.availangs[el.value][0]==1) $(el).attr('disabled', 'disabled');});
                pl.insertBefore(o._lastblock);
                $('html, body').animate({scrollTop: pl.offset().top-100}, 500);
                if (o._blocks.length >= Object.keys(o.options.availangs).length) o._addlink.hide();        

                // This should be removed in the future
                if (typeof o._afterAdd == 'function') o._afterAdd();

            });

            if (window.location.hash=='#addtrans') o._addlink.click();
        },

        _setupBlock: function(dl){
    		var o = this;
            $.extend(dl, {select: $(dl).find('select.ln-select'), lang: '', removelink: $(dl).find('.ln-removelink'), notify: $(dl).find('.ln-notify'), 
                remove: function(){
                        var offs = $(dl).prev().offset().top;
                        if (this.lang != '') o.options.availangs[this.lang][0] = 0;
                        o._blocks.each(function(i, bl){if (bl.lang!=dl.lang){bl.select.find('option:disabled').each(function(i,op){if (op.value==dl.lang) $(op).removeAttr('disabled');});}});
                        x = $.inArray(this, o._blocks);
                        o._blocks.splice(x);
                        $(this).remove();
                        $('html, body').animate({scrollTop: offs-100}, 500);
                }
            });
            $.extend(dl.select, {kk: dl, tag: $(dl).find('span.ln-tag')});
            dl.select.change(function(){
                if (this.value != '' && o.options.availangs[this.value][0] == 0 &&  dl.lang != this.value)
                {
                    if (dl.lang in o.options.availangs) o.options.availangs[dl.lang][0] = 0;
                    o._blocks.each(function(i, bl){if (bl.lang!=dl.lang){bl.select.find('option:disabled').each(function(i,op){if (op.value==dl.lang) $(op).removeAttr('disabled');});}});
                    p = this.value;
                    dl.lang = this.value;
                    o.options.availangs[dl.lang][0] = 1;
                    dl.select.tag.html(dl.select.find('option:selected').text());
                    o._blocks.each(function(i, bl){if (bl.lang!=dl.lang && dl._inited){bl.select.find('option').each(function(i,op){if (op.value==dl.lang) $(op).attr('disabled', 'disabled');});}});
                    dl.notify.removeClass('ghost');
                }
                else if (this.value == '')
                {
                    if (dl.lang != '') o.options.availangs[dl.lang][0] = 0;
                    o._blocks.each(function(i, bl){if (bl.lang!=dl.lang){bl.select.find('option:disabled').each(function(i,op){if (op.value==dl.lang) $(op).removeAttr('disabled');});}});
                    dl.select.tag.html(dl.select.find('option:selected').text());
                    dl.lang = '';
                    dl.notify.addClass('ghost');
                }
                else {
                    return false;
                }
            });
            for (ln in o.options.availangs) {if (o.options.availangs[ln][0] == 1) dl.select.find('option[value='+ln+']').attr('disabled', 'disabled')};
            dl.select.change();
            dl.removelink.click(function(){
                dl.remove();
                if (Object.keys(o.options.availangs).length > o._blocks.length) o._addlink.show();
            });
            x = $.inArray(dl, o._blocks);
            if (x < 0) { o._blocks.push(dl); x = $.inArray(dl, o._blocks); }
            if (x > 0)
            {
                $(dl).find('.ln-remove').remove();
                $(dl).find('.ln-show').removeClass('ghost');
            }
            $(dl).find('input, select, textarea').each(function(i, m){$(m).attr('id', $(m).attr('id').replace(/_[\d+]$/, '') + '_' + x);});
            $(dl).find('input, select, textarea').not(dl.select).each(function(i, m){$(m).attr('name', $(m).attr('name').replace(/_[\d+]$/, '') + '_' + x);});
            $(dl).find('label').each(function(i, m){$(m).attr('for', $(m).attr('for').replace(/_[\d+]$/, '') + '_' + x);});
            
            dl._inited = true;
        },

        _retblock: function(lng){
            o._blocks.each(function(){if (this.lang == lng) return this;});
        }
    });

    $.extend($.ui.langform, {
        instances: []
    });

})(jQuery);

/*        
$.fn.langform = function(){
    var o = $(this[0]);
    $.extend(o, {availangs: {'tr': [0, 'Turkish'], 'en': [0, 'English']}, blocks: o.find('dl.ln-part'), addlink: o.find('a.ln-addlink'), lastblock: o.find('dl.ln-part:last').next(), emptydl: o.find('dl.ln-part:first').clone(), inited: false, beforeAdd: undefined, afterAdd: undefined,
        setupBlock: function(dl){
            $.extend(dl, {select: $(dl).find('select.ln-select'), lang: '', removelink: $(dl).find('.ln-removelink'), notify: $(dl).find('.ln-notify'), 
                remove: function(){
                        var offs = $(dl).prev().offset().top;
                        if (this.lang != '') o.options.availangs[this.lang][0] = 0;
                        o._blocks.each(function(i, bl){if (bl.lang!=dl.lang){bl.select.find('option:disabled').each(function(i,op){if (op.value==dl.lang) $(op).removeAttr('disabled');});}});
                        x = $.inArray(this, o._blocks);
                        o._blocks.splice(x);
                        $(this).remove();
                        $('html, body').animate({scrollTop: offs-100}, 500);
                }
            });
            $.extend(dl.select, {kk: dl, tag: $(dl).find('span.ln-tag')});
            dl.select.change(function(){
                if (this.value != '' && o.options.availangs[this.value][0] == 0 &&  dl.lang != this.value)
                {
                    if (dl.lang in o.options.availangs) o.options.availangs[dl.lang][0] = 0;
                    o._blocks.each(function(i, bl){if (bl.lang!=dl.lang){bl.select.find('option:disabled').each(function(i,op){if (op.value==dl.lang) $(op).removeAttr('disabled');});}});
                    p = this.value;
                    dl.lang = this.value;
                    o.options.availangs[dl.lang][0] = 1;
                    dl.select.tag.html(dl.select.find('option:selected').text());
                    o._blocks.each(function(i, bl){if (bl.lang!=dl.lang && dl._inited){bl.select.find('option').each(function(i,op){if (op.value==dl.lang) $(op).attr('disabled', 'disabled');});}});
                    dl.notify.removeClass('ghost');
                }
                else if (this.value == '')
                {
                    if (dl.lang != '') o.options.availangs[dl.lang][0] = 0;
                    o._blocks.each(function(i, bl){if (bl.lang!=dl.lang){bl.select.find('option:disabled').each(function(i,op){if (op.value==dl.lang) $(op).removeAttr('disabled');});}});
                    dl.select.tag.html(dl.select.find('option:selected').text());
                    dl.lang = '';
                    dl.notify.addClass('ghost');
                }
                else {
                    return false;
                }
            });
            for (ln in o.options.availangs) {if (o.options.availangs[ln][0] == 1) dl.select.find('option[value='+ln+']').attr('disabled', 'disabled')};
            dl.select.change();
            dl.removelink.click(function(){
                dl.remove();
                if (Object.keys(o.options.availangs).length > o._blocks.length) o._addlink.show();
            });
            x = $.inArray(dl, o._blocks);
            if (x < 0) { o._blocks.push(dl); x = $.inArray(dl, o._blocks); }
            if (x > 0)
            {
                $(dl).find('.ln-remove').remove();
                $(dl).find('.ln-show').removeClass('ghost');
            }
            $(dl).find('input, select, textarea').each(function(i, m){$(m).attr('id', $(m).attr('id').replace(/_[\d+]$/, '') + '_' + x);});
            $(dl).find('input, select, textarea').not(dl.select).each(function(i, m){$(m).attr('name', $(m).attr('name').replace(/_[\d+]$/, '') + '_' + x);});
            $(dl).find('label').each(function(i, m){$(m).attr('for', $(m).attr('for').replace(/_[\d+]$/, '') + '_' + x);});
            
            dl._inited = true;
        },
        retblock: function(lng){
            o._blocks.each(function(){if (this.lang == lng) return this;});
        }
    });
    o._emptydl.find('select.ln-select option:selected').removeAttr('selected');
    o._emptydl.find('.error').removeClass('error');
    o._emptydl.find('input, textarea').val('').html('');
    o._blocks.each(function(i,pl){ o.setupBlock(pl); });
    
    if (o._blocks.length >= Object.keys(o.options.availangs).length) o._addlink.hide();
    
    o._addlink.click(function(){
    	// This should be removed in the future
        if (typeof o._beforeAdd == 'function' && (o._beforeAdd() == false)) return false;

        var pl = o._emptydl.clone();
        o.setupBlock(pl);
        pl.find('.ln-remove').remove();
        pl.find('.ln-show').removeClass('ghost');
        pl.find('label').removeClass('error');
        pl.find('em.err').remove();
        pl.select.find('option').each(function(i,el){if (el.value in o.options.availangs && o.options.availangs[el.value][0]==1) $(el).attr('disabled', 'disabled');});
        pl.insertBefore(o._lastblock);
        $('html, body').animate({scrollTop: pl.offset().top-100}, 500);
        if (o._blocks.length >= Object.keys(o.options.availangs).length) o._addlink.hide();        

        // This should be removed in the future
        if (typeof o._afterAdd == 'function') o._afterAdd();

    });

    if (window.location.hash=='#addtrans') o._addlink.click();
};
*/