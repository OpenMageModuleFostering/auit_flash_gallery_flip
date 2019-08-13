<?php
/*
 * {{block type="catalog/product_list" category_id="4" template="catalog/product/list.phtml"}}
 */
abstract class AuIt_Gallery2_Block_Flash_Abstract extends Mage_Core_Block_Template
{
	private static $_isInit=false;
	protected $flashSwf;
	protected $modelData=array();
	protected $modelParam=array();
	protected $flashparam=array();
	protected $flashattributes=array();
    protected function _prepareLayout()
    {
		parent::_prepareLayout();
		$this->initParams();
//		$this->updateParams();
    	return $this;
    }
	
	protected function initParams()
    {
    	$this->flashSwf='flip.swf';
    	
    	$this->modelData['picture_type']='small_image';
    	$this->modelData['picture_width']=0;
    	$this->modelData['picture_height']=0;
    	$this->modelData['model']='category_mostviewed';
    	$this->modelData['max_products']=20;
    	$this->modelData['category']=13;
    	$this->modelParam['licensekey']='0000-0000-0000-0000';
    	
    	$this->flashattributes['width']=685;
		$this->flashattributes['height']=135;
		$this->flashattributes['align']='left';
		$this->flashattributes['frame_style']='display:block;width:100%;height:135px;margin-bottom:10px;';
		$this->flashattributes['style']='';
		
    	$this->flashparam['wmode']='transparent';
		$this->flashparam['allowfullscreen']='1';
		$this->flashparam['allowscriptaccess']='sameDomain';
		$this->flashparam['play']='1';
		$this->flashparam['menu']='false';
		$this->flashparam['quality']='best';
		$this->flashparam['scale']='';
		$this->flashparam['bgcolor']='';
		
    }
	protected function updateParams()
    {
    	if ( !$this->modelData['picture_width'])
    		$this->modelData['picture_width']=$this->flashattributes['height'];
    	if ( !$this->modelData['picture_height'])
    		$this->modelData['picture_height']=$this->flashattributes['height'];

		$myData = $this->getData();
		foreach ( $this->modelData as $k => $v )
			if ( isset($myData['modelData_'.$k]) )
				$this->modelData[$k]=$myData['modelData_'.$k];
		foreach ( $this->flashattributes as $k => $v )
			if ( isset($myData['flashAttribute_'.$k]) )
				$this->flashattributes[$k]=$myData['flashAttribute_'.$k];
		foreach ( $this->flashparam as $k => $v )
			if ( isset($myData['flashParam_'.$k]) )
				$this->flashparam[$k]=$myData['flashParam_'.$k];
		foreach ( $this->modelParam as $k => $v )
			if ( isset($myData['modelParam_'.$k]) )
				$this->modelParam[$k]=$myData['modelParam_'.$k];
		if ( $this->modelData['model']=='category_current' )
    	{
    		$this->modelData['model']='category_list';
            $category   = Mage::registry('current_category');
            if ( $category )
	    		$this->modelData['category']=$category->getId();
    	}
    }
    public function modelParam($key,$value)
    {
    	if ( isset($this->modelParam[$key]))
    		$this->modelParam[$key]=$value;
    	return $this;
    }
    public function modelData($key,$value)
    {
    	if ( isset($this->modelData[$key]))
    		$this->modelData[$key]=$value;
    	return $this;
    }
    public function flashParam($key,$value)
    {
    	if ( isset($this->flashparam[$key]))
    		$this->flashparam[$key]=$value;
    	return $this;
    }
    public function flashAttribute($key,$value)
    {
    	if ( isset($this->flashattributes[$key]))
    		$this->flashattributes[$key]=$value;
    	return $this;
    }
    protected function _toHtml()
    {
    	$ObjId = uniqid();
    	$_jsUrl = $this->getJsUrl();
				$this->updateParams();
   // 	$this->flashattributes['width']='1';
	//	$this->flashattributes['height']='2';
    	$this->modelParam['dataurl']=$this->getUrl('au-it-gallery2/index/xml',$this->modelData);
		ob_start();
		if ( !self::$_isInit  )
		{
			self::$_isInit =true;?>
			<script src="<?php echo $_jsUrl;?>auit/gallery2/swf/swfobject.js" type="text/javascript"></script>		
<?php	}
		if ( $this->flashattributes['frame_style'] !=''):?>
		<div style="<?php echo $this->flashattributes['frame_style'];?>">
	<?php endif;?>
	<div id="swf<?php echo $ObjId?>">
		<a href="http://www.adobe.com/go/getflashplayer">Download Adobe Flash Player</a>
	</div>
	<?php if ( $this->flashattributes['frame_style'] !=''):?>
	</div>
	<?php endif;?>

<script  type="text/javascript" >
        swfobject.embedSWF(	"<?php echo $_jsUrl ?>auit/gallery2/swf/<?php echo $this->flashSwf;?>", 
							"swf<?php echo $ObjId?>", 
							"<?php echo $this->flashattributes['width'];?>", 
							"<?php echo $this->flashattributes['height'];?>", 
							"9.0.0", null, 
							<?php echo Zend_Json::encode($this->modelParam);?>,
							<?php echo Zend_Json::encode($this->flashparam);?>, <?php echo Zend_Json::encode($this->flashattributes);?>);
</script>
<?    	
    	return ob_get_clean();
    }
}
