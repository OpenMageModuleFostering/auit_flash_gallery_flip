<?php
class AuIt_Gallery2_Model_Category_New extends AuIt_Gallery2_Model_Category_Abstract
{
    protected function _getProductCollection(Mage_Core_Controller_Request_Http $request)
    {
        if (is_null($this->_feprod)) 
        {
			$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
	        
	        $collection = Mage::getResourceModel('catalog/product_collection');
	        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
	        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
	        $collection->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes());
	        $this->_feprod = $collection
	            ->addStoreFilter()
	            ->addAttributeToFilter('news_from_date', array('date' => true, 'to' => $todayDate))
	            ->addAttributeToFilter('news_to_date', array('or'=> array(
	                0 => array('date' => true, 'from' => $todayDate),
	                1 => array('is' => new Zend_Db_Expr('null')))
	            ), 'left')
	            ->addAttributeToSort('news_from_date', 'desc')
	            ->setPageSize(30)
	            ->setCurPage(1)
	        ;        	
        	
        }
        return $this->_feprod;   	
	}
}
?>