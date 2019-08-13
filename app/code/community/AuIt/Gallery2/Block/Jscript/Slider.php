<?php
class AuIt_Gallery2_Block_Jscript_Slider extends AuIt_Gallery2_Block_Flash_Abstract 
{
	public function __construct(){
		parent::__construct();
	}
	protected function initParams()
    {
    	parent::initParams();
    	$this->flashattributes['width']=195;
		$this->flashattributes['height']=195;
    }
  	protected function htmlentities_decode( $string ){
      $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
      $trans = array_flip($trans);
      return strtr($string, $trans);
	}
    protected function _toHtml()
    {
    	$ObjId = uniqid();
    	$_jsUrl = $this->getJsUrl();
				$this->updateParams();
    	$this->modelParam['dataurl']=$this->getUrl('au-it-gallery2/index/xml',$this->modelData);
		$modelTyp = $this->modelData['model'];
        if ( !$modelTyp)
        	$modelTyp='category_list';
    	$model = null;
        try {
        	$model = Mage::getModel('auit_gallery2/'.$modelTyp);
        	if ( !$model )
        		$model = Mage::getModel('auit_gallery2/category_list');
        }catch (Exception $e) {
        }
    	if ( !$model) 
    		return '';
    		
        $Request = new Mage_Core_Controller_Request_Http();
        $Request->setParams($this->modelData);
        //return $model->getXML($Request);
    	//$xmlData = simplexml_load_string($this->htmlentities_decode($model->getXML($Request)));
    	$xmlData = simplexml_load_string($model->getXML($Request));
    	ob_start();
?>
<div class="featured" style="<?php echo $this->flashattributes['frame_style'];?>">
<div class="navi"></div>
<br clear="all" />
<a class="prev"></a>
<div class="scrollable">
	<div class="items">
<?php
//		echo $item->short;
	$pcw= $this->modelData['picture_width'];
    $pch=$this->modelData['picture_height'];
  foreach($xmlData->item as $item) {
?>
    <div>
      <a href="<?php echo $item->link ?>" title="<?php echo $this->htmlEscape($item->name) ?>">
        <img class="product-image" src="<?php echo $item->image ?>" width="<?php echo $pcw;?>" height="<?php echo $pch;?>" alt="<?php echo $this->htmlEscape($item->name); ?>" />
      </a>
      <div class="featured-product-name" >
        <h3>
          <a href="<?php echo $item->link ?>" title="<?php echo $this->htmlEscape($item->name) ?>">
            <?php echo $this->htmlEscape($item->name) ?>
          </a>
        </h3>
      </div>
    </div>
<?php
  }
?>
  </div>
</div>
<a class="next"></a>
<br clear="all" />
</div>

<script>
// custom easing called "custom"
jQuery.easing.feature = function (x, t, b, c, d) {
    var s = 1.70158;
    if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
    return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
}

jQuery(function() {
	// initialize scrollable
	jQuery("div.scrollable").scrollable({
    size: 3,
    clickable: false,
    loop: true,
    easing: 'feature',
    speed: 700
  });
});

</script>
<?php    	
    	return ob_get_clean();
    }    
}

