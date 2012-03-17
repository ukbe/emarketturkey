jQuery.noConflict();
window.ajaxtables = {};
(function(jQuery) {

    jQuery.fn.AjaxTable = function(o) {
        if (typeof o == 'string') {
            var instance = jQuery(this).data('AjaxTable'), args = Array.prototype.slice.call(arguments, 1);
            return instance[o].apply(instance, args);
        } else
            return this.each(function() {
                jQuery(this).data('AjaxTable', new $at(this, o));
            });
    };

    var defaults = {
        start: "",
        max: "10",
        act: "ret",
        sort: "name",
        dir: "ASC",
        keyword: ""
    };

    jQuery.AjaxTable = function(e, o) {
        this.options    = jQuery.extend({}, defaults, o || {});

        this.list = jQuery(e);
        
        this.name = this.list.attr('id');
        this.obj = e;
        this.progressbar = jQuery('#'+this.getProgressId());
        this.errorbox = jQuery('#'+this.getErrorBoxId());
        this.pagerlinks = jQuery('#'+this.getPagerLinksId());
        this.body = this.list.find('tbody#'+this.getBodyId());
        this.headers = this.list.find('th');
        this.rows = this.list.find('tr');
        this.form = jQuery('form#'+this.getFormId());
        this.rows.hover(function(){jQuery(this).addClass('overthecell');}, function(){jQuery(this).removeClass('overthecell');});
        var self = this;

        this.headers.find('a[id^='+this.name+'_]').click(function(){self.sort(jQuery(this).attr('id'));});
        
        if (jQuery.browser.safari) {
            jQuery(window).bind('load.AjaxTable', function() { self.setup(); });
        } else
            this.setup();
    };

    // Create shortcut for internal use
    var $at = jQuery.AjaxTable;

    $at.fn = $at.prototype = {
        AjaxTable: '1.1'
    };

    $at.fn.extend = $at.extend = jQuery.extend;

    $at.fn.extend({    
    
        setParam: function(n,v){
            this.options[n] = v;
        },

        updateParams: function(items){
            for (var key in items){  
                this.form.find('input[type=hidden][name='+key+']').val(items[key]);
                this.options[key] = items[key];
            }
        },

        gotoPage: function(p){
            dat = jQuery.extend({}, this.options);
            dat['start'] = p;
            this.refresh(dat);
        },

        setMax: function(m){
            dat = jQuery.extend({}, this.options);
            dat['max'] = m;
            this.refresh(dat);
        },

        refresh: function(dat){
            this.progressbar.show();
            var self = this;
            this.errorbox.html('');
            dat['act'] = 'ret';
            this.headers.find('a[id='+this.getHeaderId(this.options['sort'])+']').parent().html(this.headers.find('a[id='+this.getHeaderId(this.options['sort'])+']'));
            this.headers.find('a[id='+this.getHeaderId(this.options['sort'])+']').click(function(){self.sort(jQuery(this).attr('id'));});
            var r = new RegExp('^http://[\\w\.]*', 'g');
            var anc = new RegExp('#[\\w\.]*$', 'g');
            var loadUrl = (''+window.location).replace(r, '').replace(anc, '');
            ajaxset = {
                type: "GET", 
                url: loadUrl, 
                async: true, 
                success: function(res){
                            self.body.html(res);
                            self.headers.find('a[id='+self.getHeaderId(dat['sort'])+']').after(dat['dir']=='ASC'?' ▲':' ▼');
                            dat = null;
                        }, 
                data: self.sumup(dat),
                error: function(xhr, exception){
                    self.progressbar.hide();
                    self.headers.find('a[id='+self.getHeaderId(self.options['sort'])+']').after(self.options['dir']=='ASC'?' ▲':' ▼');
                    self.errorbox.html('Error while requesting page:  '+exception + ' ('+xhr.status+')');
                    dat = null;
                }
            };
            jQuery.ajax(ajaxset);
        },

        setup: function(){
            window.ajaxtables[this.name] = this;
            this.setParam('max', this.getInitVal('max'));
            this.setParam('sort', this.getInitVal('sort'));
            this.setParam('dir', this.getInitVal('dir'));
            this.setParam('start', this.getInitVal('start'));
            this.setParam('act', this.getInitVal('act'));
            this.setParam('keyword', this.getInitVal('filter'));
            sparams = jQuery.parseJSON(this.getInitVal('params'));
            for (key in sparams)
            {
                this.setParam(key, sparams[key]);
            }
            this.headers.find('a[id='+this.getHeaderId(this.options['sort'])+']').after(this.options['dir']=='ASC'?' ▲':' ▼');
            var self = this;
            jQuery('input[type=check][id^='+this.getCheckId()+']').click(function(){if (this.checked){jQuery(this).parent().parent().addClass('selectedRow');} else {jQuery(this).parent().parent().removeClass('selectedRow');}});
            jQuery('input[type=radio][id^='+this.getCheckId()+']').click(function(){jQuery(':radio[id^='+self.getCheckId()+']').each(function(){jQuery(this).parent().parent().removeClass('selectedRow');});jQuery(this).parent().parent().addClass('selectedRow');});
        },
        
        sort: function(col){
            this.progressbar.show();
            var self = this;
            this.errorbox.html('');
            if (col.indexOf('_')>-1)
            {
                var r = new RegExp('^'+self.name+'_|_h$', 'g');
                col = col.replace(r,'');
            }
            dat = jQuery.extend({}, this.options);
            dat['sort'] = col;
            this.headers.find('a[id='+this.getHeaderId(this.options['sort'])+']').parent().html(this.headers.find('a[id='+this.getHeaderId(this.options['sort'])+']'));
            this.headers.find('a[id='+this.getHeaderId(this.options['sort'])+']').click(function(){self.sort(jQuery(this).attr('id'));});
            if (dat['sort']!=this.options['sort']) dat['dir'] = 'ASC';
            else dat['dir']=(this.options['dir']=='DESC'?'ASC':'DESC');
            var r = new RegExp('^http://[\\w\.]*|#$', 'g');
            var loadUrl = (''+window.location).replace(r, '');
            ajaxset = {
                type: "GET", 
                url: loadUrl, 
                async: true, 
                success: function(res){
                            self.body.html(res);
                            self.setParam('dir', dat['dir']);
                            self.setParam('sort', dat['sort']);
                            self.headers.find('a[id='+self.getHeaderId(dat['sort'])+']').after(dat['dir']=='ASC'?' ▲':' ▼');
                            dat = null;
                        }, 
                data: self.sumup(dat),
                error: function(xhr, exception){
                    self.progressbar.hide();
                    self.headers.find('a[id='+self.getHeaderId(self.options['sort'])+']').after(self.options['dir']=='ASC'?' ▲':' ▼');
                    self.errorbox.html('Error while requesting page:  '+exception + ' ('+xhr.status+')');
                    dat = null;
                }
            };
            jQuery.ajax(ajaxset);
        },
        
        sumup: function(arr){
            res = "";
            for (var e in arr){
                if (arr[e]!='') res += "&"+e+"="+escape(arr[e]);
            }
            return res.substring(1);
        },
        
        getInitVal : function(n){
            return this.form.find('input[type=hidden][name='+n+']').val();
        },
        
        getHeaderId : function(n){
            return this.name+'_'+n+'_h';
        },
        
        getCheckId : function(n){
            return this.name+'_chk_';
        },
        
        getProgressId : function(){
            return 'tab_'+this.name+'_progress';
        },
        
        getErrorBoxId : function(){
            return 'tab_'+this.name+'_error';
        },
        
        getPagerLinksId : function(){
            return 'tab_'+this.name+'_pagerlinks';
        },
        
        getBodyId : function(){
            return 'tab_'+this.name+'_body';
        },
        
        getFormId : function(){
            return 'tab_'+this.name+'_form';
        }
        
    });

    $at.extend({
        defaults: function(d) {
            return jQuery.extend(defaults, d || {});
        }

    });

})(jQuery);
    
jQuery(document).ready(function(){
    jQuery.ajaxSetup ({  
            cache: false
              
        });
    jQuery('table[class~=ajaxtable]').AjaxTable();
});
    
    
    