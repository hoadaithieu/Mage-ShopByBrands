<?php
/**
 * Category View block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class VC_ShopByBrands_Block_Brand_View extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $this->getLayout()->createBlock('catalog/breadcrumbs');

        if (($headBlock = $this->getLayout()->getBlock('head')) && ($brand = Mage::registry('brand'))) {
			
            if ($title = $brand->getBrand()) {
                $headBlock->setTitle($title);
            }
			
            if ($description = $brand->getMetaDescription()) {
                $headBlock->setDescription($description);
            }
			
            if ($keywords = $brand->getMetaKeywords()) {
                $headBlock->setKeywords($keywords);
            }
            
        }

		if (($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) && ($brand = Mage::registry('brand'))) {
			$breadcrumbs->addCrumb('home', array(
				'label' => Mage::helper('cms')->__('Home'),
				'title' => Mage::helper('cms')->__('Go to Home Page'),
				'link' => Mage::getBaseUrl()
			))->addCrumb('brand', array(
				'label' => Mage::getStoreConfig('vc_shopbybrands/general/brand_title'),
				'title' => Mage::getStoreConfig('vc_shopbybrands/general/brand_title'),
				'link' => Mage::getBaseUrl().Mage::getStoreConfig('vc_shopbybrands/general/router')
			))->addCrumb('brand3_detail', array(
				'label' => $brand->getBrand()
			));
		}

        return $this;
    }


    public function getProductListHtml()
    {
        return $this->getChildHtml('product_list');
    }
	
	public function getBrandDetailHtml() {
	    return $this->getChildHtml('brand.detail');
	}
	
	public function getBrandInfo() {
		$optionId = $this->getRequest()->getParam(Mage::getStoreConfig('vc_shopbybrands/general/brand'));
		if ($optionId > 0) {
			$collection = Mage::getModel('vc_shopbybrands/brands')->getCollection()
			->addFieldToFilter('main_table.option_id', $optionId);
			$collection->getSelect()->joinLeft(array('option' => Mage::getModel('core/resource')->getTableName('eav_attribute_option_value')), 
			'main_table.option_id = option.option_id AND option.store_id = 0', array('brand' => 'option.value'));
			
			$item = $collection->getFirstItem();
			Mage::register('brand', $item);
		}
		return Mage::registry('brand');
	}

}
