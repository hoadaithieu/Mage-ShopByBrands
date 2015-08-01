<?php

/**
 * Adminhtml customer grid block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class VC_ShopByBrands_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{


    protected function _prepareCollection()
    {
		parent::_prepareCollection();
		$collection = $this->getCollection()
			->addAttributeToSelect(Mage::getStoreConfig('vc_shopbybrands/general/brand'));
        return $this;
    }

    protected function _prepareColumns()
    {
		parent::_prepareColumns();	
		
        $this->addColumn(Mage::getStoreConfig('vc_shopbybrands/general/brand'),
            array(
                'header'=> Mage::helper('catalog')->__(Mage::getStoreConfig('vc_shopbybrands/general/brand_title')),
                'width' => '60px',
                'index' => Mage::getStoreConfig('vc_shopbybrands/general/brand'),
                'type'  => 'options',
                'options' => Mage::getSingleton('vc_shopbybrands/catalog_product_brand')->getOptionArray(),
        ));

        return $this;
    }

    
}
