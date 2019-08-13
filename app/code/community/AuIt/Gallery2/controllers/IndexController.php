<?php
class AuIt_Gallery2_IndexController extends Mage_Core_Controller_Front_Action
{
    public function xmlAction()
    {
        $modelTyp = $this->getRequest()->getParam('model');
        if ( !$modelTyp)
        	$modelTyp='category_list';
    	$model = null;
        try {
        	$model = Mage::getModel('auit_gallery2/'.$modelTyp);
        	if ( !$model )
        		$model = Mage::getModel('auit_gallery2/category_list');
        }catch (Exception $e) {
        }
    	return $this->getResponse()
        		->setHeader('Content-type', 'text/xml; charset=UTF-8')
        		->setBody($model->getXML($this->getRequest()));
    }
}