$.fn.langform = function(){
    var o = $(this[0]);
    $.extend(o, {availangs: {'tr': [0, 'Turkish'], 'en': [0, 'English']}, blocks: o.find('dl.ln-part'), addlink: o.find('a.ln-addlink'), lastblock: o.find('dl.ln-part:last').next(), emptydl: o.find('dl.ln-part:first').clone(), inited: false, beforeAdd: undefined, afterAdd: undefined,
        setupBlock: function(dl){
            $.extend(dl, {select: $(dl).find('select.ln-select'), lang: '', removelink: $(dl).find('.ln-removelink'), notify: $(dl).find('.ln-notify'), 
                remove: function(){
                        var offs = $(dl).prev().offset().top;
                        if (this.lang != '') o.availangs[this.lang][0] = 0;
                        o.blocks.each(function(i, bl){if (bl.lang!=dl.lang){bl.select.find('option:disabled').each(function(i,op){if (op.value==dl.lang) $(op).removeAttr('disabled');});}});
                        x = $.inArray(this, o.blocks);
                        o.blocks.splice(x);
                        $(this).remove();
                        $('html, body').animate({scrollTop: offs-100}, 500);
                }
            });
            $.extend(dl.select, {kk: dl, tag: $(dl).find('span.ln-tag')});
            dl.select.change(function(){
                if (this.value != '' && o.availangs[this.value][0] == 0 &&  dl.lang != this.value)
                {
                    if (dl.lang in o.availangs) o.availangs[dl.lang][0] = 0;
                    o.blocks.each(function(i, bl){if (bl.lang!=dl.lang){bl.select.find('option:disabled').each(function(i,op){if (op.value==dl.lang) $(op).removeAttr('disabled');});}});
                    p = this.value;
                    dl.lang = this.value;
                    o.availangs[dl.lang][0] = 1;
                    dl.select.tag.html(dl.select.find('option:selected').text());
                    o.blocks.each(function(i, bl){if (bl.lang!=dl.lang && dl.inited){bl.select.find('option').each(function(i,op){if (op.value==dl.lang) $(op).attr('disabled', 'disabled');});}});
                    dl.notify.removeClass('ghost');
                }
                else if (this.value == '')
                {
                    if (dl.lang != '') o.availangs[dl.lang][0] = 0;
                    o.blocks.each(function(i, bl){if (bl.lang!=dl.lang){bl.select.find('option:disabled').each(function(i,op){if (op.value==dl.lang) $(op).removeAttr('disabled');});}});
                    dl.select.tag.html(dl.select.find('option:selected').text());
                    dl.lang = '';
                    dl.notify.addClass('ghost');
                }
                else {
                    return false;
                }
            });
            for (ln in o.availangs) {if (o.availangs[ln][0] == 1) dl.select.find('option[value='+ln+']').attr('disabled', 'disabled')};
            dl.select.change();
            dl.removelink.click(function(){
                dl.remove();
                if (Object.keys(o.availangs).length > o.blocks.length) o.addlink.show();
            });
            x = $.inArray(dl, o.blocks);
            if (x < 0) { o.blocks.push(dl); x = $.inArray(dl, o.blocks); }
            if (x > 0)
            {
                $(dl).find('.ln-remove').remove();
                $(dl).find('.ln-show').removeClass('ghost');
            }
            $(dl).find('input, select, textarea').each(function(i, m){$(m).attr('id', $(m).attr('id').replace(/_[\d+]$/, '') + '_' + x);});
            $(dl).find('input, select, textarea').not(dl.select).each(function(i, m){$(m).attr('name', $(m).attr('name').replace(/_[\d+]$/, '') + '_' + x);});
            $(dl).find('label').each(function(i, m){$(m).attr('for', $(m).attr('for').replace(/_[\d+]$/, '') + '_' + x);});
            
            dl.inited = true;
        },
        retblock: function(lng){
            o.blocks.each(function(){if (this.lang == lng) return this;});
        }
    });
    o.emptydl.find('select.ln-select option:selected').removeAttr('selected');
    o.emptydl.find('.error').removeClass('error');
    o.emptydl.find('input, textarea').val('').html('');
    o.blocks.each(function(i,pl){ o.setupBlock(pl); });
    
    if (o.blocks.length >= Object.keys(o.availangs).length) o.addlink.hide();
    
    o.addlink.click(function(){
        if (typeof o.beforeAdd == 'function' && (o.beforeAdd() == false)) return false;
        var pl = o.emptydl.clone();
        o.setupBlock(pl);
        pl.find('.ln-remove').remove();
        pl.find('.ln-show').removeClass('ghost');
        pl.find('label').removeClass('error');
        pl.find('em.err').remove();
        pl.select.find('option').each(function(i,el){if (el.value in o.availangs && o.availangs[el.value][0]==1) $(el).attr('disabled', 'disabled');});
        pl.insertBefore(o.lastblock);
        $('html, body').animate({scrollTop: pl.offset().top-100}, 500);
        if (o.blocks.length >= Object.keys(o.availangs).length) o.addlink.hide();        
        if (typeof o.beforeAdd == 'function') o.afterAdd();
    });

    if (window.location.hash=='#addtrans') o.addlink.click();
};
