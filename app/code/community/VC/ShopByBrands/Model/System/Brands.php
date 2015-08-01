<?php
class VC_ShopByBrands_Model_System_Brands extends Varien_Object
{
    public function getBrandsValuesForForm()
    {
        $options = array();
		
		$rs = Mage::helper('vc_shopbybrands')->getOptionsByAttributeCode(Mage::getStoreConfig('vc_shopbybrands/general/brand'));
		if (is_array($rs) && count($rs) > 0) {
			$options = $rs;
		}
		if (count($options) == 0) {
            $options[] = array(
                'label' => '',
                'value' => ''
            );
		}

        return $options;
    }
}
