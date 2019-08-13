<?php
class AuIt_Gallery2_Block_Flash_Photo extends AuIt_Gallery2_Block_Flash_Abstract 
{
	public function __construct(){
		parent::__construct();
	}
	protected function initParams()
    {
    	parent::initParams();
    	$this->flashSwf='photo.swf';
       	$this->modelParam['border_color']='0xdddddd';
       	$this->modelParam['border_background']='0xffffff';
       	$this->modelParam['border_size']='7';
		$this->modelParam['randomise']=1;
       	$this->modelParam['timer']=2;
    	
    }
	protected function updateParams()
    {
    	if ( !$this->modelData['picture_width'])
    		$this->modelData['picture_width']=$this->flashattributes['width']*0.5;
    	if ( !$this->modelData['picture_height'])
    		$this->modelData['picture_height']=$this->flashattributes['height']*0.5;
    	parent::updateParams();	
    }
    
}
?>