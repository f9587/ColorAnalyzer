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
        $statement="SELECT Pictures.id
                    FROM Pictures
                    LEFT JOIN Picture_Colors
                    ON (Picture_Colors.pic_id=Pictures.id)
                    LEFT JOIN Colors
                    ON (Picture_Colors.color_id=Colors.id)
                    WHERE (Colors.id= ?)";
        
        return $this->connection->query($statement,$color);
    }
    
    private function getLastWebpage_id()
    {
        if ($this->getTable()->count()==0){
            return 0;
        }else {
            return $this->getTable()->max('url_id');
        }
    }
    
    private function getStringHistogram(\Imagick $image)
    {
        $histogram=$image->getImageHistogram();
        
    }
    
    /**
     * get code from webpages database and update pictures database
     */
    public function updateData()
    {
        foreach ($this->connection->table('Webpages') as $page)
        {
            preg_match_all('/<img\s+src=["\'](\S+)["\']/i',$page['code'],$matches);
            $adresses=$matches[1];
            print_r($adresses);
            $url= new \Nette\Http\Url($page['url']);
            $url->path=\Nette\Utils\Strings::replace($url->path, '@[^/]+[.][^/]+$@',"");
            $page['url']=$url->hostUrl . $url->path;
            foreach ($adresses as $adress)
            {
                if (!\Nette\Utils\Validators::isUrl($adress)){
                    $adress= $page['url'] . "/" . $adress;
                }
                $image = new \Imagick($adress);
                $height=$image->getImageHeight();
                $width=$image->getImageWidth();
                $size=$image->getImageLength();
                if(($width>100)||($height>100)){
                    $image->resizeImage(min(100,$width), min(100,$height), \Imagick::FILTER_LANCZOS,1);
                }
                
                //$histogram=getStringHistogram($image);
                $histogram=$adress;
                $this->addPicture($page['id'],$adress,$size,$width,$height,$histogram);
            }
        
            
        }
        
    }
        
    /**
     * 
     * @param unsigned in $url_id
     * @param string $adress
     * @param string $histogram
     * @return Nette\Database\Table\ActiveRow
     */
    public function addPicture($url_id,$adress,$size,$width,$height,$histogram)
    {
        if ($this->findBy(array('adress' => $adress))->count()==0){
            return $this->getTable()->insert(array(
                'url_id'=>$url_id,
                'adress'=>$adress,
                'size'=>$size,
                'width'=>$width,
                'height'=>$height,
                'histogram'=>$histogram
                    ));
        } return 0;
    }
}