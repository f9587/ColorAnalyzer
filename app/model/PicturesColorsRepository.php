<?php

namespace PictureAnalyzer;

use Nette;

class Picture_ColorsRepository extends Repository
{
    public function addRow($picture_id,$color_id)
    {
        $select=$this->findBy(array(
            'pic_id' => $picture_id,
            'color_id' => $color_id));
        if ($select->count()==0){
            return $this->getTable()->insert(array(
                'pic_id' => $picture_id,
                'color_id' => $color_id));
        }
        return 0;
    }
}