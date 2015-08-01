<?php   
//class VC_ShopByBrands_Block_Product_List extends Mage_Core_Block_Template{ 
class VC_ShopByBrands_Block_Product_List extends Mage_Catalog_Block_Product_List{ 
    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $this->_productCollection = Mage::getModel('catalog/product')->getCollection()
			->addAttributeToFilter(Mage::getStoreConfig('vc_shopbybrands/general/brand'), Mage::registry('option_id'));
			
			$this->_productCollection
				->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
				->addMinimalPrice()
				->addFinalPrice()
				->addTaxPercents()
				//->addUrlRewrite($this->getCurrentCategory()->getId())
				;
			Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($this->_productCollection);
			//echo $this->_productCollection->getSelect();
        }
        return $this->_productCollection;
    }

}