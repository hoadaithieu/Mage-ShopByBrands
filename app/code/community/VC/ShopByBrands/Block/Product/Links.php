<?php   
class VC_ShopByBrands_Block_Product_Links extends Mage_Core_Block_Template{ 
	public function addFooterLink() {
		$block = $this->getLayout()->getBlock('footer_links');
		$block->addLink(Mage::getStoreConfig('vc_shopbybrands/blog/title'),
		Mage::getUrl($this->helper('vc_shopbybrands')->getBlogUrl(), array('_secure' => true)),
		Mage::getStoreConfig('vc_shopbybrands/blog/title'));
	}
	
	public function addTopLink() {
		$block = $this->getLayout()->getBlock('top.links');
		$block->addLink(Mage::getStoreConfig('vc_shopbybrands/blog/title'),
		Mage::getUrl($this->helper('vc_shopbybrands')->getBlogUrl(), array('_secure' => true)),
		Mage::getStoreConfig('vc_shopbybrands/blog/title'));
	}
	
}