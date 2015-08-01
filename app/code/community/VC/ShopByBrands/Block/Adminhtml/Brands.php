<?php
class VC_ShopByBrands_Block_Adminhtml_Brands extends Mage_Adminhtml_Block_Widget_Grid_Container {
	public function __construct() {
		$this->_controller = 'adminhtml_brands';
		$this->_blockGroup = 'vc_shopbybrands';
		$this->_headerText = Mage::helper('vc_shopbybrands')->__('Brands Manager');
		$this->_addButtonLabel = Mage::helper('vc_shopbybrands')->__('Add Brand');
		parent::__construct();
	}
}