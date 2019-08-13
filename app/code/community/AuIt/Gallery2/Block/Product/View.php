<?php
class AuIt_Gallery2_Block_Product_View extends Mage_Catalog_Block_Product_Abstract
{
	protected $_priceBlock;
	
    protected function _prepareLayout()
    {
    	$this->setTemplate('default/view.phtml');
        return parent::_prepareLayout();
    }
    /**
     * Return true if product has options
     *
     * @return bool
     */
    public function hasOptions()
    {
        if ($this->getProduct()->getTypeInstance(true)->hasOptions($this->getProduct())) {
            return true;
        }
        return false;
    }

    /**
     * Check if product has required options
     *
     * @return bool
     */
    public function hasRequiredOptions()
    {
        return $this->getProduct()->getTypeInstance(true)->hasRequiredOptions($this->getProduct());
    }
    public function renderView()
    {
        Varien_Profiler::start(__METHOD__);
        $baseDir = Mage::getBaseDir() . DS . 'app'. DS .'code'. DS .'community'. DS .'AuIt'. DS . 'Gallery2';
        $this->setScriptPath($baseDir. DS .'templates');
        $params = array('_relative'=>true);
        if ($area = $this->getArea()) {
            $params['_area'] = $area;
        }

        //$templateName = Mage::getDesign()->getTemplateFilename($this->getTemplate(), $params);
		
        $templateName = $this->getTemplate();
        $html = $this->fetchView($templateName);

        Varien_Profiler::stop(__METHOD__);

        return $html;
    }
    
    public function getFlashHtml($product)
    {
    	$this->setProduct($product);
        return str_replace(Array("<div","</div"),Array('<p','</p'),$this->toHtml());
    }    
    public function getPriceHtml($product, $displayMinimalPrice = false, $idSuffix='')
    {
    	if ( !$this->_priceBlock )
    	{
        	$this->_priceBlock = Mage::getSingleton('core/layout')->createBlock('catalog/product_list');
    	}
        return $this->_priceBlock->getPriceHtml($product, $displayMinimalPrice, $idSuffix);
    }
    
}
