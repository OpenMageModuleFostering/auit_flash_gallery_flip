<?php
abstract class AuIt_Gallery2_Model_Category_Abstract extends Mage_Core_Model_Abstract
{
	protected $_feprod;
	protected $_cacheKey;
    public function __construct()
    {
    	parent::__construct();
    }
    private function buildXMl(Mage_Core_Controller_Request_Http $request,&$xml,$_productCollection)
    {
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
				$NTmp = $xml->addChild('item');
				$NTmp->addChild('image',$url);
				$NTmp->addChild('name',htmlentities ($_product->getName(),ENT_COMPAT ,'UTF-8'));
				$NTmp->addChild('short',$_product->getshortDescription());
				$NTmp->addChild('link',$_product->getProductUrl());
				$max--;
				if ( !$max ) break;
			}
		}
		
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
    	if (!($data = $this->_loadCache())) 
    	{
			$xml = new SimpleXMLElement("<?xml version='1.0'  encoding='utf-8'?><data></data>");
	    	$this->buildXMl($request,$xml,$this->_getProductCollection($request));
			$data = $xml->asXML();
    		$this->_saveCache($data);
    	}
    	return $data;
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