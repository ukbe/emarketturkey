$.fn.locform = function(options){
    var o = $(this[0]);
    var settings = {queryUrl: '/' };
    if (options) {$.extend(settings, options)}
    $.extend(o, {locations: [], blocks: o.find('dl.lc-part'), addlink: o.find('a.lc-addlink'), lastblock: o.find('dl.lc-part:last').next(), emptydl: o.find('dl.lc-part:first').clone(),
        broadcastCN : function(bl) {
             o.blocks.each(function(i,pl){ if (pl==undefined) return;
                            if (bl.country!='' && pl.country!=bl.country) 
                                pl.select_cn.find('option[value='+bl.country+']').attr('disabled', 'disabled');
                            else if (bl.country!='' && pl.country==bl.country)
                                bl.select_st.find('option[value='+pl.state+']').attr('disabled', 'disabled');
                        })
        },
        broadcastST : function(bl) {
            o.blocks.each(function(i,pl){ if (pl==undefined) return;
                            if (bl.state!='' && pl.country==bl.country && pl.state!=bl.state) 
                            {
                                pl.select_st.find('option[value='+bl.state+']').attr('disabled', 'disabled');
                            }
                            else if (bl.state!='' && pl.country!=bl.country)
                            {
                                pl.select_cn.find('option[value='+bl.country+']').removeAttr('disabled');
                            }
                            else if (bl.state=='' && pl.country!=bl.country)
                            {
                                pl.select_cn.find('option[value='+bl.country+']').attr('disabled', 'disabled');
                            }
                        })
        },
        clearCN: function (bl) {
            o.blocks.each(function(i,pl){ if (pl==undefined) return; if (bl.country!='' && pl.country!=bl.country) pl.select_cn.find('option[value='+bl.country+']').removeAttr('disabled');});
        },
        clearST: function (bl) {
            o.blocks.each(function(i,pl){ if (pl==undefined) return; if (pl.country==bl.country) pl.select_st.find('option[value='+bl.state+']').removeAttr('disabled');});
        },
        setupBlock: function(dl){
            $.extend(dl, {index: '', select_cn: $(dl).find('select.lc-country'), select_st: $(dl).find('select.lc-state'), input_pr: $(dl).find('input.lc-personel'), country: '', state: '', personel: '', removelink: $(dl).find('.lc-removelink'), 
                remove: function(){
                        o.clearST(dl);
                        o.clearCN(dl);
                        x = $.inArray(dl, o.blocks);
                        o.blocks[x] = null;
                        $(this).remove();
                },
                isValid: function(){ var err = []; o.blocks.each(function(i,kl){if (kl==undefined) return; if (kl.index!=dl.index && kl.country==dl.country && (kl.state==dl.state || kl.state=='' || dl.state=='')) err.push('country='+kl.country+', region='+kl.state+' conflict'); var reg = new RegExp('^[0-9]+$'); if (!reg.test(kl.personel)) err.push('Number of staff should hold numerical value.'); if (kl.country=='') err.push('Please select country.');}); return err;},
                switch: function(){ if (dl.personel=='') dl.input_pr.tag.closest('div.personel').hide(); 
                    $(dl).addClass('view');
                    if (dl.state=='') $(dl).addClass('countrywide');
                },
                updateCountry: function(){
                    var cn = dl.select_cn.find('option:selected');
                    dl.country=cn.val();
                    dl.select_cn.tag.html(cn.val() != '' ? cn.text() : ''); 
                },
                updateState: function(v){
                    var st = dl.select_st.find('option:selected');
                    dl.state=st.val();
                    dl.select_st.tag.html(st.val() != '' ? st.text() : '');
                }
            });
            $.extend(dl.select_cn, {tag: $(dl).find('span.lc-country'), etag: $(dl).find('span.lc-st-error')});
            dl.select_cn.change(function(){
                if (this.value != '' && dl.country != this.value)   //?
                {   //?
                    var p = this.value;
                    dl.select_cn.attr('disabled', true); dl.select_cn.etag.addClass('ghost');
                    dl.select_st.attr('disabled', true);
                    $.getJSON(settings.queryUrl, {cc: p}, 
                        function(d){
                            o.clearST(dl);
                            o.clearCN(dl);
                            dl.updateCountry();
                            dl.select_st.empty().append($('<option/>'));
                            $(d).each(function(g,i){dl.select_st.append($('<option value='+i.ID+'>'+i.NAME+'</option>'));});
                            dl.updateState();
                            //o.blocks.find('dl[country='+dl.country+']').each(function(i,p){dl.select_st.find('option[value='+p.state+']').attr('disabled', true);});
                            o.broadcastCN(dl);
                            o.broadcastST(dl);
                        }
                    )
                    .error(function(e,str){dl.select_cn.etag.removeClass('ghost'); dl.select_cn.find('option[value='+p+']').attr('selected', true);})
                    .complete(function(){dl.select_cn.attr('disabled', false);dl.select_st.attr('disabled', false);});
                }   //?
                else if (this.value == '')   //?
                {   //?
                    dl.select_st.empty();
                    o.clearST(dl);   //?
                    o.clearCN(dl);   //?
                    dl.updateCountry();
                    dl.updateState();
                }   //?
                else {   //?
                    return false;   //?
                }   //?
            });
            dl.updateCountry();
            $.extend(dl.select_st, {tag: $(dl).find('span.lc-state')});
            dl.select_st.change(function(){
                if (this.value != '' && dl.state != this.value)
                {
                    o.clearST(dl);
                    dl.updateState();
                    o.broadcastST(dl);
                }
                else if (this.value == '')
                {
                    o.clearST(dl);
                    dl.updateState();
                }
                else {
                    return false;
                }
            });
            dl.updateState();
            $.extend(dl.input_pr, {tag: $(dl).find('span.lc-personel')});
            dl.input_pr.change(function(){
                if (this.value != '')
                {
                    dl.personel = this.value;
                    dl.input_pr.tag.html(dl.input_pr.val());
                }
                else {
                    dl.personel = '';
                    dl.input_pr.tag.html('');
                }
            });
            dl.removelink.click(function(){
                dl.remove();
            });
            dl.index = x = $.inArray(dl, o.blocks);
            if (x < 0) o.blocks.push(dl);
            if (x > 0)
            {
                $(dl).find('.ln-remove').remove();
                $(dl).find('.ln-show').removeClass('ghost');
            };
            $(dl).find('input, select, textarea').each(function(i, m){$(m).attr('id', $(m).attr('id').replace(/_[\d+]$/, '') + '_' + x);});
            $(dl).find('input, select, textarea').each(function(i, m){$(m).attr('name', $(m).attr('name').replace(/_[\d+]$/, '') + '_' + x);});
            $(dl).find('label').each(function(i, m){$(m).attr('for', $(m).attr('for').replace(/_[\d+]$/, '') + '_' + x);});
            if (dl.isValid().length == 0) dl.switch();
            else if (dl.select_cn.children().length == 0) dl.select_cn.change();
        },
        retblock: function(cnt, st){
            o.blocks.each(function(){if ((this.country == cnt) && (this.state == st)) return this;});
        }
    });
    //o.emptydl.find('select.lc-country option:selected').removeAttr('selected');
    o.emptydl.find('select.lc-state option:selected').removeAttr('selected');
    o.blocks.each(function(i,pl){ o.setupBlock(pl); });
    
    o.addlink.click(function(){
        var allvalid = true;
        o.blocks.each(function(i, bl){ 
            if (!$(bl).hasClass('view')){
                var vam = o.blocks[o.blocks.length-1].isValid();
                if (vam.length == 0) o.blocks[o.blocks.length-1].switch();
                else { allvalid = false; alert(vam[0]);}
            }
        });
        if (!allvalid) return false;
        var pl = o.emptydl.clone();
        o.setupBlock(pl);
        pl.find('.lc-remove').remove();
        pl.find('.lc-show').removeClass('ghost');
        o.blocks.each(function(i, bl){if (bl==undefined) return; 
            if (bl.country != '' && bl.state == '') 
            {
                pl.select_cn.find('option[value='+bl.country+']').attr('disabled', 'disabled');
                if (pl.country == bl.country) { pl.select_cn.find('option:selected').removeAttr('selected'); pl.select_cn.change(); }
            }
            if (bl.country == pl.country && bl.state != '') 
                pl.select_st.find('option[value='+bl.state+']').attr('disabled', 'disabled');
            
        });
        pl.insertBefore(o.lastblock);
        $('html, body').animate({scrollTop: pl.offset().top-100}, 500);
    });
};