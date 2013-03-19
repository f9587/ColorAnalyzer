<?php

namespace PictureAnalyzer;

use Nette;

class ColorsRepository extends Repository
{
    
    /**
     * 
     * @param unsigned int $limit
     * @return Nette\Database\Table\Selection
     */
    public function getTopColors($limit=100)
    {
        return $this->getTable()->order('count DESC')->limit($limit);
    }
}