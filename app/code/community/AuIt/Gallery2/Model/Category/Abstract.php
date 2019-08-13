<?php
abstract class AuIt_Gallery2_Model_Category_Abstract extends Mage_Core_Model_Abstract
{
	protected $_feprod;
	protected $_cacheKey;
	protected $_priceBlock;
	protected $_htmlBlock;
	public function __construct()
    {
    	parent::__construct();
    }
    private function codingXML($text)
    {
    	$text = str_replace('&amp;','[AMPAMP]',$text);
    	$text = str_replace('&','&amp;',$text);
    	return str_replace('[AMPAMP]','&amp;',$text);
    }
    private function addTemplate(Mage_Core_Controller_Request_Http $request)
    {
    	$xml='<template>';
    	$templates  = $request->getParam('template','');
    	if ( !$templates )
    		$templates='default';
    	if ( $templates )
    	{
    		$dir = dirname(__FILE__)."/../../templates/$templates/";
    		if ( file_exists($dir.'view.phtml') )
    		{
    		//	$xml .= '<box><![CDATA[';
    		//	$xml .= file_get_contents($dir.'view.phtml');
    			//$xml .= ']]></box>';
    		}
    		if ( file_exists($dir.'default.css') )
    		{
    			$xml .= '<css><![CDATA[';
    			$xml .= file_get_contents($dir.'default.css');
    			$xml .= ']]></css>';
    		}
    	}
    	$xml.='</template>';
    	return $xml;
    }
    private function buildXMl(Mage_Core_Controller_Request_Http $request,$_productCollection)
    {
    	$xml='';
    
    	$picWidth  = (int)$request->getParam('picture_width',230);
    	if ( $picWidth <= 0 ) $picWidth=230;
    	$picHeight = (int)$request->getParam('picture_height',184);
    	if ( $picHeight <= 0 ) $picHeight=184;
    	$picType = $request->getParam('picture_type','small_image');
    	if (  $picType != 'image' && $picType != 'small_image' && $picType != 'thumbnail'  )
    		$picType='small_image';

    	$max = (int)$request->getParam('max_products',10);
    	if ( $max <= 0 ) $max=10;
    	$iHelper = Mage::helper('catalog/image');
    	
    	if ( $_productCollection )
    	foreach ($_productCollection as $_product)
		{
			$url= ''.$iHelper->init($_product, $picType)
                    ->keepFrame(false)->resize($picWidth,$picHeight);
			if ($url!='')
			{ 
				$xml.='<item>';
				$xml.='<image>'.$url.'</image>';
				$xml.='<name><![CDATA['.$_product->getName().']]></name>';
				$xml.='<short><![CDATA['.$_product->getshortDescription().']]></short>';
				$xml.='<link>'.$_product->getProductUrl().'</link>';
//				$xml.='<price><![CDATA['.str_replace(Array("\n","\t",''),'',$this->getPriceHtml($_product,true)).']]></price>';
				$xml.='<html><![CDATA['.str_replace(Array("\n","\t",''),'',$this->getHtml($_product,true)).']]></html>';
				$xml.='</item>';
				$max--;
				if ( !$max ) break;
			}
		}
		return $xml;
    }
    /**
    public function getPriceHtml($product, $displayMinimalPrice = false, $idSuffix='')
    {
    	if ( !$this->_priceBlock )
    	{
        	$this->_priceBlock = Mage::getSingleton('core/layout')->createBlock('catalog/product_list');
    	}
        return str_replace(Array("<div","</div"),Array('<p','</p'),$this->_priceBlock->getPriceHtml($product, $displayMinimalPrice, $idSuffix));
    }
    */
    public function getHtml($product, $displayMinimalPrice = false, $idSuffix='')
    {
    	if ( !$this->_htmlBlock )
    	{
        	$this->_htmlBlock = Mage::getSingleton('core/layout')->createBlock('auit_gallery2/product_view');
    	}
        return $this->_htmlBlock->getFlashHtml($product);
    }
    protected function getCacheKey()
    {
        return 'auit_de_gallery_'.$this->_cacheKey;
    }
    protected function getCacheTags()
    {
		$tags = array();
        $tags[] = 'auit_de_data';
        return $tags;
    }
    
    protected function getCacheLifetime()
    {
        return 60*60*5; // Sekunden 
    }
    
    protected function _loadCache()
    {
        if (is_null($this->getCacheLifetime()) || !Mage::app()->useCache('auit_de')) {
            return false;
        }
        return Mage::app()->loadCache($this->getCacheKey());
    }
    protected function _saveCache($data)
    {
        if (is_null($this->getCacheLifetime()) || !Mage::app()->useCache('auit_de')) {
            return false;
        }
        Mage::app()->saveCache($data, $this->getCacheKey(), $this->getCacheTags(), $this->getCacheLifetime());
        return $this;
    }
    public function getXML(Mage_Core_Controller_Request_Http $request)
    {
    	$this->_cacheKey = crc32($request->getRequestUri());
    	if (!($xml = $this->_loadCache())) 
    	{
        	$xml = '';
            $xml.= '<?xml version="1.0" encoding="UTF-8"?>'."\n";
    		$xml.= '<data>';
    		$xml.= $this->addTemplate($request);
    		$xml.= $this->buildXMl($request,$this->_getProductCollection($request));
    		$xml.= '</data>';
    		$this->_saveCache($xml);
    	}
    	return $xml;
    }
    abstract protected function _getProductCollection(Mage_Core_Controller_Request_Http $request);
	protected function _shuffle()
	{
		$shuff=array();
		$keys=array();
		$_productCollection=self::$_feprod;
		foreach ($_productCollection as $k => $_product)
		{
			$shuff[]=$_product;$keys[]=$k;
		}
		foreach ($keys as $k)
		{
			$_productCollection->removeItemByKey($k);
		}
//		$this->_productCollectionas->clear()
		shuffle($shuff);
		foreach ($shuff as $k => $_product)
		{
			//$_product->setId($k);
			$_productCollection->addItem($_product);
		}
		self::$_feprod =$_productCollection;
	}
 
}

?>