<?php
class VC_ShopByBrands_Block_Adminhtml_Brands_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('brands_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('vc_shopbybrands')->__('Brands Information'));
	}
	
	protected function _beforeToHtml()
	{
		$this->addTab('form_section', array(
			'label'     => Mage::helper('vc_shopbybrands')->__('Brands Information'),
			'title'     => Mage::helper('vc_shopbybrands')->__('Brands Information'),
			'content'   => $this->getLayout()->createBlock('vc_shopbybrands/adminhtml_brands_edit_tab_form')->toHtml(),
		));

		$this->addTab('meta_section', array(
			'label'     => Mage::helper('vc_shopbybrands')->__('Meta Information'),
			'title'     => Mage::helper('vc_shopbybrands')->__('Meta Information'),
			'content'   => $this->getLayout()->createBlock('vc_shopbybrands/adminhtml_brands_edit_tab_meta')->toHtml(),
		));
		
		return parent::_beforeToHtml();
	}
}