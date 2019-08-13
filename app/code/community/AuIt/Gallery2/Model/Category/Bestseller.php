<?php
class AuIt_Gallery2_Model_Category_Bestseller extends AuIt_Gallery2_Model_Category_Abstract
{
    protected function _getProductCollection(Mage_Core_Controller_Request_Http $request)
    {
        if (is_null($this->_feprod)) 
        {
        	$storeId = Mage::app()->getStore()->getId();
	        $this->_feprod = Mage::getResourceModel('reports/product_collection')
            ->addOrderedQty()
            ->addAttributeToSelect(array('name', 'price','status','small_image','thumbnail','image'))
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
            ->setOrder('ordered_qty', 'desc');
        }
        return $this->_feprod;   	
	}
}
?>