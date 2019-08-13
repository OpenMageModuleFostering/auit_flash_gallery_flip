<?php
class AuIt_Gallery2_Block_Flash_Flip extends AuIt_Gallery2_Block_Flash_Abstract 
{
	public function __construct(){
		parent::__construct();
	}
	protected function initParams()
    {
    	parent::initParams();
    	$this->flashSwf='flip.swf';
       	$this->modelParam['border_color']='0xdddddd';
       	$this->modelParam['border_background']='0xffffff';
		$this->modelParam['randomise']=1;
       	$this->modelParam['timer']=2;

    	$this->flashattributes['width']=195;
		$this->flashattributes['height']=195;
		$this->flashattributes['align']='';
		$this->flashattributes['frame_style']='';
       	
    	
    }
}