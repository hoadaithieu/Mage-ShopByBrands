<?php
include_once 'app/code/core/Mage/Catalog/Block/Layer/View.php';
class VC_ShopByBrands_Block_Catalog_Layer_View extends Mage_Catalog_Block_Layer_View
{
    protected $_brandsFilterBlockName;

    /**
     * Initialize blocks names
     */
    protected function _initBlocks()
    {
		parent::_initBlocks();
        $this->_brandsFilterBlockName      = 'vc_shopbybrands/catalog_layer_filter_brands';
    }

    
    /**
     * Prepare child blocks
     *
     * @return Mage_Catalog_Block_Layer_View
     */
    protected function _prepareLayout()
    {
        $stateBlock = $this->getLayout()->createBlock($this->_stateBlockName)
            ->setLayer($this->getLayer());

        $categoryBlock = $this->getLayout()->createBlock($this->_categoryBlockName)
            ->setLayer($this->getLayer())
            ->init();

        $this->setChild('layer_state', $stateBlock);
        $this->setChild('category_filter', $categoryBlock);

        $filterableAttributes = $this->_getFilterableAttributes();
        foreach ($filterableAttributes as $attribute) {
            if ($attribute->getAttributeCode() == 'price') {
                $filterBlockName = $this->_priceFilterBlockName;
            } elseif ($attribute->getAttributeCode() == Mage::getStoreConfig('vc_shopbybrands/general/brand')) {
				$filterBlockName = $this->_brandsFilterBlockName;
			} elseif ($attribute->getBackendType() == 'decimal') {
                $filterBlockName = $this->_decimalFilterBlockName;
            } else {
                $filterBlockName = $this->_attributeFilterBlockName;
            }

            $this->setChild($attribute->getAttributeCode() . '_filter',
                $this->getLayout()->createBlock($filterBlockName)
                    ->setLayer($this->getLayer())
                    ->setAttributeModel($attribute)
                    ->init());
        }

        $this->getLayer()->apply();

        return $this;
    }

}
