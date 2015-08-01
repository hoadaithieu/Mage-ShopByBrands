<?php
class VC_ShopByBrands_Block_Brand_Sidebar extends Mage_Core_Block_Template
{
	public function getCollection() {
		$collection = Mage::getModel('vc_shopbybrands/brands')->getCollection();
		$collection->getSelect()->joinLeft(array('option' => Mage::getModel('core/resource')->getTableName('eav_attribute_option_value')), 
		'main_table.option_id = option.option_id AND option.store_id = 0', array('brand' => 'option.value'));
		return $collection;
	}

}
