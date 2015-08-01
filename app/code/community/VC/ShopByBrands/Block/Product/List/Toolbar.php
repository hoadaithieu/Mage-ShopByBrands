<?php
class VC_ShopByBrands_Block_Product_List_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar{
    public function getPagerUrl($params=array())
    {
        $urlParams = array();
        $urlParams['_current']  = true;
        $urlParams['_escape']   = true;
        $urlParams['_use_rewrite']   = true;
        $urlParams['_query']    = $params;
		$this->getRequest()->setAlias(Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS, $this->helper('vc_shopbybrands')->getBrandUrl());
        return $this->getUrl('*/*/*', $urlParams);
    }

}
