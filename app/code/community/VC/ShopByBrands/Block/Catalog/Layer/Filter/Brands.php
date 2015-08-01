<?php
include_once 'app/code/core/Mage/Catalog/Block/Layer/Filter/Attribute.php';

class VC_ShopByBrands_Block_Catalog_Layer_Filter_Brands extends Mage_Catalog_Block_Layer_Filter_Attribute
{
    /**
     * Initialize Price filter module
     *
     */
    public function __construct()
    {
        parent::__construct();
		$this->setTemplate('vc_shopbybrands/catalog/layer/brands/filter.phtml');
    }
	
}
