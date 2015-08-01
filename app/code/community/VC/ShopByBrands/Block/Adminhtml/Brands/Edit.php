<?php
class VC_ShopByBrands_Block_Adminhtml_Brands_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'vc_shopbybrands';
        $this->_controller = 'adminhtml_brands';
        
        $this->_updateButton('save', 'label', Mage::helper('vc_shopbybrands')->__('Save Brands'));
        $this->_updateButton('delete', 'label', Mage::helper('vc_shopbybrands')->__('Delete Brands'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('description') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'description');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'description');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action + 'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('brands_data') && Mage::registry('brands_data')->getId() ) {
			if (Mage::registry('brands_label')) {
				return Mage::helper('vc_shopbybrands')->__("Edit Brands '%s'", $this->htmlEscape(Mage::registry('brands_label')));
			}
            return Mage::helper('vc_shopbybrands')->__("Edit Brands '%s'", $this->htmlEscape(Mage::registry('brands_data')->getId()));
        } else {
            return Mage::helper('vc_shopbybrands')->__('Add Brands');
        }
    }
}