<style>
.first {margin-top: 7px;}
.ghost {display: none;}
div.xml-element {border: solid 1px #CCCCCC; padding: 5px; margin: 10px;}
div.xml-element.hover {background-color: #FAF1E1;}
div.xml-element > a {background-color: #A6CCD9; display: inline-block; color: #434343; font: 12px tahoma; padding: 5px;}
div.xml-element > a.clicked {background-color: #346779;}

</style>
<h2>Import Company Products</h2>
<p>You may automatically import products of a registered company through any website.</p>
<?php echo form_tag('admin/importProducts') ?>
<h3>Step 1 - Build product links list</h3>
<ol style="list-style-type: none;">
<li>Select source type for product list:</li>
<li><?php echo select_tag('list-type', options_for_select(
                                            array('XML' => 'XML - Paste XML content', 
                                                  'TEXT' => 'TEXT - Paste links list in text format'
                                            ), null, 
                                            array('include_custom' => 'please select')
                                        ), 
                            array('onchange' => "jQuery('.LISTTYPE').hide(); jQuery('.LISTTYPE.OPT'+jQuery(this).val()).show().find('textarea').focus();")
                ) ?></li>
<li class="LISTTYPE OPTXML first ghost">Paste product list in XML format:</li>
<li class="LISTTYPE OPTXML ghost"><?php echo textarea_tag('product-list-source', '', array('cols' => 120, 'rows' => 15, 'onchange' => "discover(jQuery(this).val());")) ?></li>
<li class="LISTTYPE OPTXML first ghost"><div id="poll"></div></li>
<li class="LISTTYPE OPTXML first ghost">Select location element:</li>
<li class="LISTTYPE OPTXML ghost"><?php echo select_tag('location-element', options_for_select(array(), null, array('include_custom' => '(optional)')), 'class=tagselect') ?></li>
<li class="LISTTYPE OPTXML first ghost">Select image element:</li>
<li class="LISTTYPE OPTXML ghost"><?php echo select_tag('image-element', options_for_select(array(), null, array('include_custom' => '(optional)')), 'class=tagselect') ?></li>
<li class="LISTTYPE OPTXML first ghost">Select product title element:</li>
<li class="LISTTYPE OPTXML ghost"><?php echo select_tag('title-element', options_for_select(array(), null, array('include_custom' => '(optional)')), 'class=tagselect') ?></li>
<li class="LISTTYPE OPTXML first ghost">Select product description element:</li>
<li class="LISTTYPE OPTXML ghost"><?php echo select_tag('description-element', options_for_select(array(), null, array('include_custom' => '(optional)')), 'class=tagselect') ?></li>
<li class="LISTTYPE OPTTEXT first ghost">Paste product list source in Text format:</li>
<li class="LISTTYPE OPTTEXT ghost"><?php echo textarea_tag('product-list-source', '', array('cols' => 120, 'rows' => 15)) ?></li>
</ol>
</form>
<script>
var llit = new Array();
var selected = null;

var discover = function(node) {
    if (node.nodeName!==undefined)
    {
        if (jQuery(node).parent().attr('prnt')!==undefined)
        {
            jQuery(node).attr('prnt', jQuery(node).parent().attr('prnt')+'-'+node.nodeName);
            var divid=jQuery(node).parent().attr('prnt');
        }
        else
        {
            jQuery(node).attr('prnt', node.nodeName);
            var divid='poll';
        }
    
        if (jQuery.inArray(jQuery(node).attr('prnt'), llit) == -1)
        {
            llit.push(jQuery(node).attr('prnt'));
            jQuery('#'+divid).append(jQuery('<div id="'+jQuery(node).attr('prnt')+'" class="xml-element"><a href="javascript:selected=this;jQuery(this).parent(\'div\').addClass(\'hover\');">'+node.nodeName+'</a></div>'));
        }
    }
        
        jQuery(node).children().each(function(i, o) {
            discover(o);
        });
}



</script>