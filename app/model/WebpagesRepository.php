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
            return $this->getTable()->insert(array(
                'url' => $url,
                'code'=> $page
                ));
        }
    }
    
    public function findAllUrl() {
        
    }
    
}