<?php

class ProductCategoryI18n extends BaseProductCategoryI18n
{
    public function setName($name)
    {
        parent::setName($name);
        
        $this->setStrippedCategory(myTools::stripText($name));
        // TODO: StrippedCategory verisi ana tabloya taşınmalı sadece ingilizce isim kullanılmalı.
    }
}
