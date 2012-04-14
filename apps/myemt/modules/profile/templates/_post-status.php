<span class="status-message greyedbox"><?php
$str = str_replace("\n", '<br />', $item->getItem()->getMessage());
echo mb_strlen($str)> 200 ? mb_substr($str, 0, 200, 'utf-8').link_to_function(__('read more'), "linkread(this)", 'class=readmorelink')."<span class='more'>".mb_substr($str, 200, -1, 'utf-8')."</span>" : $str ?></span>