<?php

class boxtestAction extends EmtAction
{
    public function execute($request)
    {
        if ($this->getRequest()->isXmlHttpRequest())
        {
            header('Content-type: text/html');
            sfLoader::loadHelpers('Url');
            if ($this->hasRequestParameter('settings'))
            {
                return $this->renderPartial('tempSettings');
            }
            else if ($this->hasRequestParameter('advanced'))
            {
                return $this->renderPartial('tempAdvanced');
            }
            else if ($this->hasRequestParameter('notify'))
            {
                return $this->renderText(
                    json_encode(array('NEW' => 3, 'ITEMS' => array(
                        array('IMG' => $this->sesuser->getProfilePictureUri(), 'NAME' => 'Ukbe', 'LASTNAME' => 'Akdoğan', 'MESSAGE' => 'seninle arkadaş olmak istiyor', 'URL' => url_for('@homepage'), 'OCCURENCE' => '15 May 12:15', 'NEW' => true),
                        array('IMG' => $this->sesuser->getProfilePictureUri(), 'NAME' => 'Hakan', 'LASTNAME' => 'Gürsoy', 'MESSAGE' => 'seninle arkadaş olmak istiyor', 'URL' => url_for('@homepage'), 'OCCURENCE' => '15 May 12:15', 'NEW' => true),
                        array('IMG' => $this->sesuser->getProfilePictureUri(), 'NAME' => 'Kazım', 'LASTNAME' => 'Tatlı', 'MESSAGE' => 'seni Yok Artık grubuna davet etti', 'URL' => url_for('@homepage'), 'OCCURENCE' => '15 May 12:15', 'NEW' => true),
                        array('IMG' => $this->sesuser->getProfilePictureUri(), 'NAME' => 'Mahmut', 'LASTNAME' => 'Özen', 'MESSAGE' => 'seninle arkadaş olmak istiyor', 'URL' => url_for('@homepage'), 'OCCURENCE' => '15 May 12:15', 'NEW' => false),
                        array('IMG' => $this->sesuser->getProfilePictureUri(), 'NAME' => 'Özlem', 'LASTNAME' => 'Kurnaz', 'MESSAGE' => 'seninle arkadaş olmak istiyor', 'URL' => url_for('@homepage'), 'OCCURENCE' => '15 May 12:15', 'NEW' => false),
                        array('IMG' => $this->sesuser->getProfilePictureUri(), 'NAME' => 'Jale', 'LASTNAME' => 'Özenç', 'MESSAGE' => 'seninle arkadaş olmak istiyor', 'URL' => url_for('@homepage'), 'OCCURENCE' => '15 May 12:15', 'NEW' => false),
                    ))
                ));
            }
            else
            {
                return $this->renderText(
                    json_encode(array('NEW' => 5, 'ITEMS' => array(
                        array('NAME' => 'Can', 'LASTNAME' => 'Akdoğan', 'MESSAGE' => 'Slm dostum, naber?', 'OCCURENCE' => '15 May 12:15', 'NEW' => true),
                        array('NAME' => 'Ukbe', 'LASTNAME' => 'Akdoğan', 'MESSAGE' => 'Slm dostum, naber?', 'OCCURENCE' => '15 May 12:15', 'NEW' => true),
                        array('NAME' => 'Kaan', 'LASTNAME' => 'Kural', 'MESSAGE' => 'Yarınki toplantı iptal oldu', 'OCCURENCE' => '15 May 14:33', 'NEW' => true),
                        array('NAME' => 'İbrahim', 'LASTNAME' => 'Tokat', 'MESSAGE' => 'Abi noldu bizim iş', 'OCCURENCE' => '15 May 15:35', 'NEW' => false),
                        array('NAME' => 'Zeynel', 'LASTNAME' => 'Abidin', 'MESSAGE' => 'Gönder abi bizim elemanı', 'OCCURENCE' => '15 May 23:55', 'NEW' => false),
                        array('NAME' => 'Kaan', 'LASTNAME' => 'Abidin', 'MESSAGE' => 'Gönder abi bizim elemanı', 'OCCURENCE' => '15 May 23:55', 'NEW' => false),
                        array('NAME' => 'Kazım', 'LASTNAME' => 'Abidin', 'MESSAGE' => 'Gönder abi bizim elemanı', 'OCCURENCE' => '15 May 23:55', 'NEW' => false),
                    ))
                ));
            }
        }
    }
    
    public function handleError()
    {
    }
    
}
