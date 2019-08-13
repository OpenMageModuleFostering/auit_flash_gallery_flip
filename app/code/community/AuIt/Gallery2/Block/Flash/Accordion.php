<?php
class AuIt_Gallery2_Block_Flash_Accordion extends AuIt_Gallery2_Block_Flash_Abstract 
{
	protected function initParams()
    {
    	parent::initParams();
    	$this->flashSwf='accordion.swf';
    	$this->modelParam['accord_width']=25;
    	$this->modelParam['font_size']=12;
       	$this->modelParam['font_color']='0xe5e5e5';
       	$this->modelParam['background_color']='0x0A263D';
       	$this->modelParam['frame_color']='0xFFFFFF';
		$this->modelParam['randomise']=1;
       	$this->modelParam['alpha']=0.5;
       	$this->modelParam['font']='Arial';
       	$this->modelParam['random_click']=3;
       	$this->modelParam['orientation']='horizontal';
       	$this->modelParam['text_bgcolor']='';
       	$this->modelParam['left_margin']=10;
       	$this->modelParam['right_margin']=10;
    }
}
?>