<?php
class AuIt_Gallery2_Model_Category_List  extends AuIt_Gallery2_Model_Category_Abstract
{
    protected function _getProductCollection(Mage_Core_Controller_Request_Http $request)
    {
        if (is_null($this->_feprod)) 
        {
            $category   = Mage::getModel('catalog/category')->load($request->getParam('category',4));
            if ( !$category )
            {
            	$category   = Mage::getModel('catalog/category')->load($request->getParam('category',Mage::app()->getStore()->getRootCategoryId()));
            }
			$origCategory = null;
            if ( $category )
            {
				$layer = Mage::getSingleton('catalog/layer');
				$collection = $category->getProductCollection();
				$this->prepareProductCollection($category,$collection);
				$this->_feprod =$collection;
			}
        }
        return $this->_feprod;    	
	}
    public function prepareProductCollection($category,$collection)
    {
        $attributes = Mage::getSingleton('catalog/config')
            ->getProductAttributes();
        $attributes[]='image';
        $collection->addAttributeToSelect($attributes)
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            //->addStoreFilter()
            ;

        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
        $collection->addUrlRewrite($category->getId());
        return $this;
    }
}
?>