<?php
class VC_ShopByBrands_Model_System_Config_Source_Layout_Brand
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
			array('value' => 3, 'label'=>Mage::helper('adminhtml')->__('Only Logo')),
            array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('Only Name')),
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Logo & Name')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
			array('value' => 3, 'label'=>Mage::helper('adminhtml')->__('Only Logo')),
            array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('Only Name')),
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Logo & Name')),
        );
    }

}
