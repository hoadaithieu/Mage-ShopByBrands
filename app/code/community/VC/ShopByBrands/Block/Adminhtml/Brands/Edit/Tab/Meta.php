<?php
class VC_ShopByBrands_Block_Adminhtml_Brands_Edit_Tab_Meta extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('brands_form', array('legend'=>Mage::helper('vc_shopbybrands')->__('Meta information')));
		$priceGroup = Mage::registry('brands_data');
		
	
		
		
		$fieldset->addField(
			'meta_keyword',
			'textarea',
			array(
				 'name'   => 'meta_keyword',
				 'label'  => Mage::helper('vc_shopbybrands')->__('Meta Keyword'),
				 'title'  => Mage::helper('vc_shopbybrands')->__('Meta Keyword'),
				 'style'  => 'width:700px; height:100px;',
			)
		);
		
		$fieldset->addField(
			'meta_description',
			'textarea',
			array(
				 'name'   => 'meta_description',
				 'label'  => Mage::helper('vc_shopbybrands')->__('Meta Description'),
				 'title'  => Mage::helper('vc_shopbybrands')->__('Meta Description'),
				 'style'  => 'width:700px; height:100px;',
			)
		);
		

		
		if ( Mage::registry('brands_data') ) {
			$form->setValues(Mage::registry('brands_data')->getData());
		}
		return parent::_prepareForm();
	}
}