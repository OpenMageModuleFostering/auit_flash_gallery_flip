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

    	// Text-Block
       	$this->modelParam['show_textblock']=1;
    	$this->modelParam['textblock_height']=60;
       	$this->modelParam['textblock_background']='0x000000';
       	$this->modelParam['textblock_alpha']=0.5;
       	
    	// Loader
		$this->modelParam['randomise']=1;
       	//Player
       	$this->modelParam['effect_time']=1.5;
       	
		$this->modelParam['slices_picture_mode']=2;
       	$this->modelParam['slices_number']=1;
       	$this->modelParam['show_reflect']=0;
       	$this->modelParam['show_dropshadow']=1;
       	$this->modelParam['timer']=2;
       	
       	// Frame
       	$this->modelParam['show_frame']=1;
       	$this->modelParam['border_size']=10;
    	$this->modelParam['border_color']='0xdddddd';
       	$this->modelParam['border_background']='0xffffff';

    	$this->flashattributes['width']=195;
		$this->flashattributes['height']=195;
		$this->flashattributes['align']='';
		$this->flashattributes['frame_style']='';
		$this->flashattributes['align']='';
    }
	protected function updateParams()
    {
    	if ( !$this->modelData['picture_width'])
    		$this->modelData['picture_width']=$this->flashattributes['width']*0.7;
    	if ( !$this->modelData['picture_height'])
    		$this->modelData['picture_height']=$this->flashattributes['width']*0.7;
    	
    	parent::updateParams();	
    }
    
}
?>