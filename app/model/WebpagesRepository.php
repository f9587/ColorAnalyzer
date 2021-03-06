<?php

namespace PictureAnalyzer;

use Nette;

class WebpagesRepository extends Repository
{
    
    /**
    * @param string $url
    * @return Nette\Database\Table\ActiveRow
    */
    public function addWebpage($url)
    {
        if ($this->findBy(array('url' => $url))->count()==0){        
            $page = file_get_contents($url);
            if (!mb_check_encoding($page, 'UTF-8')){
                $page= \Nette\Utils\Strings::fixEncoding($page);
            }
            return $this->getTable()->insert(array(
                'url' => $url,
                'code'=> $page
                ));
        }
        return 0;
    }
    
}