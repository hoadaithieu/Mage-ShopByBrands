<?php
include "app/code/core/Mage/Catalog/controllers/CategoryController.php";
//class VC_ShopByBrands_BrandsController extends Mage_Catalog_CategoryController{
class VC_ShopByBrands_BrandsController extends Mage_Core_Controller_Front_Action{	
    public function indexAction() {
		$this->loadLayout();
		$this->renderLayout(); 
    }
	
	public function _initBrand() {
		$identifier = $this->getRequest()->getParam('identifier');
		$collection = Mage::getModel('vc_shopbybrands/brands')->getCollection()
		->addFieldToFilter('identifier', $identifier);
		$collection->getSelect()->joinLeft(array('option' => Mage::getModel('core/resource')->getTableName('eav_attribute_option_value')), 
		'main_table.option_id = option.option_id AND option.store_id = 0', array('brand' => 'option.value'));
		
		$item = $collection->getFirstItem();
		if ($item && $item->getId() > 0) {
			return $item;
		}
		
		return false;
	}
	
	public function viewAction() {
		if ($brand = $this->_initBrand()) {
			if ($brand->getOptionId() > 0) {
				Mage::register('option_id', $brand->getOptionId());
			}
			Mage::register('brand', $brand);
			$this->loadLayout();
			$this->renderLayout();
		}
	}
	

	
}