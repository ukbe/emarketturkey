<?php

function get_progress_bar(EmtAjaxTable $table)
{
    $html = "<div id=\"tab_".$table->getName()."_progress\" class=\"ghost\">".image_tag('layout/icon/loadingAnimation.gif', 'vspace=4')."</div>";
    return $html;
}

function get_error_box(EmtAjaxTable $table)
{
    $html = "<div id=\"tab_".$table->getName()."_error\"></div>";
    return $html;
}

function get_pager_links(EmtAjaxTable $table)
{
    $tabname = $table->getName();
    $pager = $table->getPager();
    
    $html = '';
    $html .= ' <ol id="tab_'.$tabname.'_pagerlinks" class="pagerlinks inline-form">';
    $html .= '<li>'.__($table->getRowCountLabel(), array('%1' => $pager->getNbResults())).'</li>';
    if ($table->getShowItemsPerPage()) $html .= '<li>'.__('%1sel <span style="float: left;">&nbsp;per page</span>', array('%1sel' => select_tag('max', options_for_select(array(5 => 5, 10 => 10, 20 => 20, 50 => 50, 100 => 100), $table->getItemsPerPage()), "onchange=ajaxtables['$tabname'].setMax(this.value) class=\"column\""))).'</li>';
    if ($table->getPager()->haveToPaginate())
    {
        $html .= '<li style="line-height: 5px;">';
        if ($pager->getPage()>1)
        {
            $html .= link_to_function('&laquo;', "ajaxtables['$tabname'].gotoPage(".$pager->getFirstPage().");");
            $html .= link_to_function('&lt;', "ajaxtables['$tabname'].gotoPage(".($pager->getFirstIndice()-1).");");
        }
        $links = $pager->getLinks();
        
        foreach ($links as $page)
        {
            $html .= ($page == $pager->getPage()) ? link_to_function($page, 'return false;', 'class=current') : link_to_function($page, "ajaxtables['$tabname'].gotoPage(".(($page-1)*$table->getItemsPerPage()+1).");");
        }
        if ($pager->getNbResults()>$pager->getLastIndice())
        {
            $html .= link_to_function('&gt;', "ajaxtables['$tabname'].gotoPage(".($pager->getLastIndice()+1).");");
            $html .= link_to_function('&raquo;', "ajaxtables['$tabname'].gotoPage(".$pager->getNbResults().");");
        }
        $html .= "</li>";
    }
    $html .= "</ol>";

    return $html;
}

function get_ajax_table(EmtAjaxTable $table, $include_header=true)
{
    $tabname = $table->getName();
    $html = '';
    $columns = $table->getColumns();
    if ($include_header)
    {
        $html .= emt_remote_form("tab_{$tabname}_body", sfContext::getInstance()->getRouting()->getCurrentInternalUri(), array(), "id=tab_{$tabname}_form");
        $html .= input_hidden_tag('act', 'ret');
        $html .= input_hidden_tag('max', $table->getItemsPerPage());
        $html .= input_hidden_tag('start', $table->getPager()->getFirstIndice());
        $html .= input_hidden_tag('filter', $table->getKeyword());
        $html .= input_hidden_tag('sort', $table->getOrderColumn());
        $html .= input_hidden_tag('dir', $table->getSortOrder());
        $html .= input_hidden_tag('params', json_encode($table->getStaticParams()));
        $html .= submit_tag('post', 'style=display:none');
        $html .= "</form>";
        $html .= "<table id=\"$tabname\" class=\"ajaxtable".($table->getCssClass()!=''?' '.$table->getCssClass():'').'" cellspacing="0" cellpadding="0">';
        if ($table->getShowHeader())
        {
            $html .= '<thead>';
            $html .= '<tr>';
            if ($table->getSelectable()=='1' || $table->getSelectable()=='N')
            {
                $html .= '<th></th>';
            }
            
            foreach ($columns as $column)
            {
                $colname = $column->getName();
                $title = $column->getDisplayName();
        
                if ($column->getIsSortable() && !$column->getIsActionColumn())
                {
                    if ($column->getIsSortColumn()) $title = __($title) . ' ' . $table->getSortOrder()=='DESC'?'▲':'▼';
                    $title = link_to_function($title, "", "id={$tabname}_{$colname}_h");
                }
                $css = $column->getHeaderCssClass(). ' ' . $column->getCssClass(); 
                $html .= "<th" . 
                            (trim($css)!==''?" class='$css'":'') . 
                                ">$title</th>";
                            
            }
            
            $html .= '</tr></thead>';
        }
    
        $html .= "<tbody id='tab_{$tabname}_body'>";
    
    }
    $i = 0;
    $rows = $table->getPager()->getResults();
    foreach ($rows as $row)
    {
        $html .= '<tr>'; 
        $i++;

        if ($table->getSelectable()=='1' || $table->getSelectable()=='N')
        {
            $html .= "<td class='check'>".($table->getSelectable()=='1'?radiobutton_tag('selected_items', $row->getId(), false, "id={$tabname}_chk_".$row->getId())
                        : checkbox_tag('selected_items[]', $row->getId(), false, array('id' => "{$tabname}_chk_".$row->getId())))."</td>";
        }
        
        $itemUrl = $table->getItemUrl();
        $itemUrl[1] = (count($itemUrl)>1&&is_array($itemUrl[1]) ? $itemUrl[1] : array());
        $itemUrl[1]['id']=$row->getId(); 
        
        foreach ($columns as $column)
        {
            if ($column->getIsActionColumn())
            {
                $html .= '<td class="actions">';
                
                if ($table->getEditAction())
                {
                    $html .= link_to(image_tag('layout/icon/edit-n.png', array('title' => __('Edit'))), $itemUrl[0], array('query_string' => http_build_query($itemUrl[1])));
                }
                if ($table->getDeleteAction())
                {
                    $html .= link_to(image_tag('layout/icon/delete-n.png', array('title' => __('Delete'))), $itemUrl[0], array('query_string' => http_build_query($itemUrl[1]).'&act=rm'));
                }
                if ($table->getActivateAction())
                {
                    $html .= "<span id=\"{$tabname}_toggle_{$row->getId()}\">".emt_remote_link(
                                    image_tag('layout/icon/'.($row->getActive()?'active-n':'active-grey-n').'.png', array('title' => $row->getActive()?__('De-Activate'):__('Activate'))), 
                                    "{$tabname}_toggle_".$row->getId(), 
                                    $itemUrl[0], 
                                    array_merge(array('id' => $row->getId(), 'act' => 'tog'), $itemUrl[1])
                                ) . "</span><span id=\"{$tabname}_toggle_{$row->getId()}error\"></span>";
                }
            }
            else
            {
                $html .= "<td".($column->getCssClass()!=''?" class='".$column->getCssClass()."'":'').">".get_partial($table->getRowPartial(), array('row' => $row, 'column' => $column->getName())).'</td>';
            }
        }
        $html .= '</tr>'; 
    }
    if ($include_header)
    {
        $html .= "</tbody>";
        $html .= '</table>';
    }
    use_javascript('emt-ajax-table.min.js');;
    return $html;
}