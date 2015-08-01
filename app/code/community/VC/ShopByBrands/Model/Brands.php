<?php
class VC_ShopByBrands_Model_Brands extends Mage_Core_Model_Abstract
{
    public function _construct() {
        parent::_construct();
        $this->_init('vc_shopbybrands/brands', 'id');
    }
	
	public function validIdentifier($str = '') {
		return $this->_getResource()->validIdentifier($this, $str, $this->getId());
	}
	
}
