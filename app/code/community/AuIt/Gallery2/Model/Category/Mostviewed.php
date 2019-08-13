<?php
class AuIt_Gallery2_Model_Category_Mostviewed extends AuIt_Gallery2_Model_Category_Abstract
{
    protected function _getProductCollection(Mage_Core_Controller_Request_Http $request)
    {
        if (is_null($this->_feprod)) 
        {
        	$storeId = Mage::app()->getStore()->getId();
 			$this->_feprod = Mage::getResourceModel('reports/product_collection')
            ->addAttributeToSelect('*')
            ->addViewsCount()
            ->setStoreId($storeId)
            ->addStoreFilter($storeId);        	
        }
        return $this->_feprod;   	
	}
}
?>