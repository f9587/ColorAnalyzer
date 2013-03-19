<?php

namespace PictureAnalyzer;

use Nette;

class PicturesRepository extends Repository
{
    
    /**
     * 
     * @param unsigned int $color
     * @return 
     */
    public function getPictures($color)
    {
        $statment="SELECT Pictures.id
                    FROM Pictures
                    LEFT JOIN Picture_Colors
                    ON (Picture_Colors.pic_id=Pictures.id)
                    LEFT JOIN Colors
                    ON (Picture_Colors.color_id=Colors.id)
                    WHERE (Colors.id= ?)";
        
        return $this->connection->query($statement,$color);
    }
}