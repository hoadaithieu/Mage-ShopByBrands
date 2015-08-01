<?php
class VC_ShopByBrands_Model_Catalog_Product_Brand{
    static public function getOptionArray()
    {
        $options = array();
		$collection = Mage::getModel('vc_shopbybrands/brands')->getCollection();
		$collection->getSelect()->joinLeft(array('option' => Mage::getModel('core/resource')->getTableName('eav_attribute_option_value')), 
		'main_table.option_id = option.option_id AND option.store_id = 0', array('brand' => 'option.value'));
		if ($collection && $collection->getSize() > 0) {
			foreach ($collection as $item) {
				$options[$item->getOptionId()] = $item->getBrand();
			}
		}		
        return $options;
    }

}