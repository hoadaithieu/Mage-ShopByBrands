<?php   
class VC_ShopByBrands_Block_Product_Sidebar extends Mage_Core_Block_Template{ 
   /**
     * Product Collection
     *
     * @var Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected $_productCollection;
	protected $_catCollection;
	protected $_getTags = null;
	
	protected $_key = '';
	protected $_value = '';

    /**
     * Retrieve loaded category collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
           
            $this->_productCollection = Mage::getModel('vc_shopbybrands/product')->getCollection();
			$this->_productCollection->setPageSize(Mage::getStoreConfig('vc_shopbybrands/menu_link/recent_product'));
			
        }
        return $this->_productCollection;
    }

   

    /**
     * Retrieve loaded category collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getLoadedProductCollection()
    {
        return $this->_getProductCollection();
    }
	
	public function setConfig($key, $value) {
		$this->_key = $key;
		$this->_value = $value;
		
	}
	
	public function allowShow() {
		if (Mage::getStoreConfig($this->_key) == $this->_value) {
			return true;
		}
		return false;
	}
	
    protected function _getCatCollection()
    {
        if (is_null($this->_catCollection)) {
           
            $this->_catCollection = Mage::getModel('vc_shopbybrands/category')->getCollection();
			
			
        }
        return $this->_catCollection;
    }

    public function getLoadedCatCollection()
    {
        return $this->_getCatCollection();
    }
	
    protected function _getTags()
    {
        if (is_null($this->_getTags)) {
           
            $collection = Mage::getModel('vc_shopbybrands/product')->getCollection();
			$collection->getSelect()->columns(array('tags' => '(GROUP_CONCAT(tags))'));	
			$this->_getTagItem = $collection->getFirstItem();
			
			if ($this->_getTagItem ) {
				$this->_getTags = $this->_getTagItem->getTags();
			}	
        }
        return $this->_getTags;
    }

    public function getLoadedTags()
    {
        return $this->_getTags();
    }	
	
}