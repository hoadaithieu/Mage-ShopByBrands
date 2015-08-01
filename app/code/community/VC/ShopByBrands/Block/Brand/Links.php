<?php   
class VC_ShopByBrands_Block_Brand_Links extends Mage_Core_Block_Template{ 
	public function addFooterLink() {
		$block = $this->getLayout()->getBlock('footer_links');
		$block->addLink(Mage::getStoreConfig('vc_shopbybrands/menu_link/title'),
			Mage::getUrl(Mage::getStoreConfig('vc_shopbybrands/general/router'), array('_secure' => true)),
			Mage::getStoreConfig('vc_shopbybrands/menu_link/title')
		);
		
	}
	
	public function addTopLink() {
		$block = $this->getLayout()->getBlock('top.links');
		$block->addLink(Mage::getStoreConfig('vc_shopbybrands/menu_link/title'),
			Mage::getUrl(Mage::getStoreConfig('vc_shopbybrands/general/router'), array('_secure' => true)),
			Mage::getStoreConfig('vc_shopbybrands/menu_link/title')
		);
	}
	
}