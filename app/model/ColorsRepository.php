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
    
    /**
     * 
     * @param unsigned $red
     * @param unsigned $green
     * @param unsigned $blue
     * @return Nette\Database\Table\ActiveRow
     */
    public function addColor($hex)
    {
        $select=$this->findBy(array('hex' => $hex));
        if ($select->count()==0){
            return $this->getTable()->insert(array('hex' => $hex));
        }else{
            $row=$select->fetch();
            $new_count=++$row['count'];
            $row->update(array('count'=>$new_count));
            return 0;
        }
    }
}