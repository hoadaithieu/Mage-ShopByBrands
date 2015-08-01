<?php
class VC_ShopByBrands_Block_Brand_List extends Mage_Core_Block_Template
{
	public function getCollection($condition = array()) {
		$collection = Mage::getModel('vc_shopbybrands/brands')->getCollection();
		if (is_array($condition) && count($condition) > 0) {
			list($key, $value) = each($condition);
			
			$collection->addFieldToFilter($key, $value);
		}
		$collection->getSelect()->joinLeft(array('option' => Mage::getModel('core/resource')->getTableName('eav_attribute_option_value')), 
		'main_table.option_id = option.option_id AND option.store_id = 0', array('brand' => 'option.value'));
		return $collection;
	}

}
