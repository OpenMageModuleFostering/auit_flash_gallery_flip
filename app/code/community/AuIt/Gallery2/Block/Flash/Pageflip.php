<?php
class AuIt_Gallery2_Block_Flash_Flip extends AuIt_Gallery2_Block_Flash_Abstract 
{
	public function __construct(){
		parent::__construct();
	}
	protected function initParams()
    {
    	parent::initParams();
    	$this->flashSwf='pageflip.swf';
    }
}