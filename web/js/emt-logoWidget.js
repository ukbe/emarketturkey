(function($){

    $.widget('ui.logoWidget', {
        options: {
            url: '',
            left: 0,
            top: 0,
            right: undefined,
            bottom: undefined,
            crop: true,
            frmDims: undefined,
            prwDims: undefined,
            formStatus: undefined,
            frameSelector: '#cropbox',
            prwBoxSelector: '#preview',
            formSelector: undefined,
            saveUrl: (''+window.location).replace(/#[\\w\.]*$/, ''),
            gallerySelector: '#gallery',
            cropTogglerSelector: '#croptoggle',
            saveLinkSelector: '#savephoto',
            removeLinkSelector: '#removephoto',
            noImageTag: 'Upload New Image or Drop Existing Image Here',
        },

        _create: function(){
            var origin = this;
            this._guid = undefined;
            this._width = undefined;
            this._height = undefined;
            this._orgDims = undefined;
            this._jcropHandle = undefined;
            this._left = this.options.left;
            this._top = this.options.top;
            this._right = this.options.right;
            this._bottom = this.options.bottom;
            this._crop = this.options.crop;
            this._uploading = false;
            this._gallery = $(this.options.gallerySelector);
            this._saveLink = $(this.options.saveLinkSelector);
            this._cropToggler = $(this.options.cropTogglerSelector);
            this._prwBox = $(this.options.prwBoxSelector);
            this._preview = this._prwBox.find('img');
            this._frame = $(this.options.frameSelector);
            this._initForm();

            if (this.options.frmDims){
                this._frmDims = this.options.frmDims;
                this._frame.css({'width': this._frmDims[0], 'height': this._frmDims[1]});
            }
            else{
                this._frmDims = [this._frame.width(), this._frame.height()];
            }

            if (!this._preview.length){
                this._prwBox.html(this._preview = $('<img />'));
            }
            
            if (this.options.prwDims){
                this._prwDims = this.options.prwDims;
                this._prwBox.css({'width': this._prwDims[0], 'height': this._prwDims[1]});
            }
            else
            {
                this._prwDims = [this._prwBox.width(), this._prwBox.height()];
            }
            this._prwBox.css('overflow', 'hidden');
            
            this._image = this._frame.find('img');

            if (this._image.length)
            {
                if (this._image[0].complete) {
                    this._image.css('display', 'none');
                    this.options.url = this._url = this._image.attr('src');
                    this._image.css({'width': 'auto', 'height': 'auto'});
                    this._orgDims = [this._image.width(), this._image.height()];
                    this.options.guid = this._guid = this._parseImageGuid(this._url);
                    this._initImage();
                }
                else {
                    this._image.load(function(){
                        origin._image.css('display', 'none');
                        origin.options.url = origin._url = origin._image.attr('src');
                        origin._image.css({'width': 'auto', 'height': 'auto'});
                        origin._orgDims = [origin._image.width(), origin._image.height()];
                        origin.options.guid = origin._guid = origin._parseImageGuid(origin._url);
                        origin._initImage();
                    });
                }
            }
            else if (this.options.url != ''){
                this._loadImage(this.options.url);
            }
            else if (this.options.noImageTag != '') {
                this._frame.html(this.options.noImageTag);
            };

            if (this._cropToggler.length) this._cropToggler.click(function(){
                origin._crop = !origin._crop;
                if (origin._crop) $(this).addClass('active'); else $(this).removeClass('active');
                origin._initImage();
            });
            
            if (this._gallery.length) this._initGallery();

            this._saveLink.closest('form').submit(function(){
                $(this).find('input[name="ref"]').val(origin._guid);
                $(this).find('input[name="crop"]').val(origin._crop);
                $(this).find('input[name="coords"]').val($.param(origin._jcropHandle.tellScaled()));
            });
        },

        _init: function(){
        },

        _loadImage: function(url){
            var origin = this;
            var nimage = $(new Image());
            nimage.load(function(){
                origin._image = $(this);
                origin._url = origin._image.attr('src');
                origin._guid = origin._parseImageGuid(origin._url);
                origin._left = 0;
                origin._top = 0;
                origin._right = undefined;
                origin._bottom = undefined;
                origin._crop = true;
                origin._image.css({'width': 'auto', 'height': 'auto', 'display': 'none'});
                origin._frame.html(origin._image);
                origin._orgDims = [origin._image.width(), origin._image.height()];
                origin._initImage();
            });
            nimage.attr('src', url);
        },

        _initImage: function(){
            this._image.css('display', 'none');
            var rx = this._frmDims[0] / this._orgDims[0];
            var ry = this._frmDims[1] / this._orgDims[1];
            this._refConv = (rx < ry ? rx : ry);
            this._refConv = (this._refConv >= 1) ? 1 : this._refConv;

            this._width = Math.round(this._refConv * this._orgDims[0]);
            this._height = Math.round(this._refConv * this._orgDims[1]);

            this._image.css('width' , this._width);
            this._image.css('height' , this._height);
            
            this._image.css('display', 'block');
            
            this._preview.attr('src', this._url);
            
            var origin = this;
            var setselect = (this._right == undefined || this._bottom == undefined) ? [this._left, this._top, this._left + this._width, this._bottom] : [this._left, this._top, this._right, this._bottom]; 
            
            this._jcropHandle = $.Jcrop(this._image, {
                onChange: function(coords){origin._showPreview(coords);},
                onSelect: function(coords){origin._showPreview(coords);},
                setSelect: setselect,
                aspectRatio: this._prwDims[0]/origin._prwDims[1]
            });
            
            this._checkSaved();
        },
        
        _showPreview: function(coords){
            if (parseInt(coords.w) > 0)
            {
                var rx = this._prwDims[0] / coords.w;
                var ry = this._prwDims[1] / coords.h;
                
                this._preview.css({ 
                    width: Math.round(rx * this._width) + 'px',
                    height: Math.round(ry * this._height) + 'px',
                    marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                    marginTop: '-' + Math.round(ry * coords.y) + 'px'
                });
                
                this._left = coords.x;
                this._top = coords.y;
                this._right = coords.x2;
                this._bottom = coords.y2;
                
                this._checkSaved();
                
                
                
            }
        },
        
        _parseImageGuid: function(url){
            return url.substring(url.lastIndexOf('/') + 1, url.lastIndexOf('.'));
        },
        
        _initForm: function(){
            var origin = this;
            var frm = $(this.options.formSelector);
            this._form = frm.length ? frm : undefined;
            this._formSubmitter = this._form.find('.frm-submit');
            this._formErrorBlock = this._form.find('.error-block');
            this._formCanceller = this._form.find('#cancelupload');
            this._form.append('<input type="hidden" name="js" value="true" />')
            this._uploadStarted = false;
            if (this._form.length)
            {
                (this._iframe = $('<iframe />').attr('id', this._form.attr('id')+'_frame')).hide().appendTo('body');
                this._form.attr('target', this._iframe.attr('id'));
                this._iframe.load(function(){
                   var res = $.parseJSON(origin._iframe.contents().find('body').html());
                   if(res.status == 1)
                   {
                        origin._setOption('imageUrl', res.uri);
                        origin._loadImage(res.uri);
                        origin._setOption('saved', false);
                        origin._form[0].reset();
                   }
                   else if(res.status == 0 && origin._uploadStarted)
                   {
                     origin._formErrorBlock.html(res.message).show();
                   }
                   origin._setFormStatus('select');
                   origin._uploadStarted = false;
                });
                this._formSubmitter.click(function(){
                    origin._uploadStarted = true;
                    origin._formErrorBlock.html('').hide();
                    origin._form.submit();
                    origin._setFormStatus('process');
                });
                this._formCanceller.click(function(){
                    origin._uploadStarted = false;
                    origin._setFormStatus('select');
                    if (navigator.appName == 'Microsoft Internet Explorer') {
                        window.frames[origin._iframe.attr('id')].document.execCommand('Stop');
                    } else {
                        window.frames[origin._iframe.attr('id')].stop();
                    }
                });
                this._form.find('input[type="text"],select').val('');
                this._form.find('option:selected').attr('selected', '');
                this._setFormStatus(this.options.formStatus);
            }
        },
        
        _initGallery: function(){
            
            var origin = this;
            
            this._gallery.find('li').draggable({
                helper: 'clone',
                appendTo: 'body',
                start: function(event, ui){origin._jcropHandle.disable();},
                stop: function(event, ui){origin._jcropHandle.enable();}
            });
            
            this._frame.droppable({
                accept: origin.options.gallerySelector + ' li',
                hoverClass: 'state-hover',
                drop: function( event, ui ) {
                    var pimg = ui.draggable.find('img');
                    origin._loadImage(pimg.attr('alt'));
                }
                
            });        
        },

        _setFormStatus: function(stat){
            if (this._form)
            {
                this._formStatus = (/^(select|process)$/.test(stat) ? stat : 'select');
                this._form.find('[class|="frm-st"]').hide();
                this._form.find('.frm-st-'+this._formStatus).show();
            }
        },
        
        _checkSaved: function(){
            if (this._url != this.options.url || this._crop != this.options.crop || this._left != this.options.left || this._top != this.options.top || this._right != this.options.right || this._bottom != this.options.bottom){
                this._saveLink.show();
            }
            else{
                this._saveLink.hide();
            }
        },
        
        destroy: function(){
            // call the original destroy method since we overwrote it
            $.Widget.prototype.destroy.call( this );
        },

        _setOption: function(key, value){
            this.options[key] = value;
        }
    });

})(jQuery);
