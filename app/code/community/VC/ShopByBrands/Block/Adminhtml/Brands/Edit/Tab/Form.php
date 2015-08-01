<?php
class VC_ShopByBrands_Block_Adminhtml_Brands_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('brands_form', array('legend'=>Mage::helper('vc_shopbybrands')->__('Brands information')));
		
		
		$fieldset->addField(
			'option_id',
			'select',
			array(
				 'name'     => 'option_id',
				 'label'    => Mage::helper('vc_shopbybrands')->__('Brand'),
				 'title'    => Mage::helper('vc_shopbybrands')->__('Brand'),
				 'required' => true,
				 'values'   => Mage::getSingleton('vc_shopbybrands/system_brands')->getBrandsValuesForForm(),
			)
		);	
		
		
		// BEGIN CONFIG
		$config = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
		
		$variableConfig = array('files_browser_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'),
		'widget_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/widget/index'),
		);
		
        $onclickParts = array(
            'search' => array('html_id'),
            'subject' => 'MagentovariablePlugin.loadChooser(\''.Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/system_variable/wysiwygPlugin').'\', \'{{html_id}}\');'
        );
        $variableWysiwygPlugin = array(array('name' => 'magentovariable',
            'src' => Mage::getBaseUrl('js').'mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js',
            'options' => array(
                'title' => Mage::helper('adminhtml')->__('Insert Variable...'),
                'url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/system_variable/wysiwygPlugin'),
                'onclick' => $onclickParts,
                'class'   => 'add-variable plugin'
        )));
        $variableConfig['plugins'] = $variableWysiwygPlugin;
		
		$config->addData($variableConfig);
		// END
		
		$fieldset->addField(
			'description',
			'editor',
			array(
				 'name'   => 'description',
				 'label'  => Mage::helper('vc_shopbybrands')->__('Description'),
				 'title'  => Mage::helper('vc_shopbybrands')->__('Description'),
				 'style'  => 'width:700px; height:200px;',
				 'config' => $config,
				 'widget_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/widget/index'),
			)
		);			

		$fieldset->addType('fileupload', 'VC_ShopByBrands_Block_Adminhtml_Form_Element_FileUpload');
		$fieldset->addField('image', 'fileupload',
			array(
				'name'  => 'image',
				'label' => Mage::helper('vc_shopbybrands')->__('Logo'),
				'title' => Mage::helper('vc_shopbybrands')->__('Logo'),
				'note'  => 'Allowed Extensions: '. Mage::getStoreConfig('vc_shopbybrands/general/image_extension_allow').'
				 with dimension ('.Mage::getStoreConfig('vc_shopbybrands/general/image_width').'px x '.Mage::getStoreConfig('vc_shopbybrands/general/image_height').'px)',
				'class'     => 'required-entry',
				'required'  => true,
				'path_url' => Mage::helper('vc_shopbybrands')->getImageUrl()
			)
		);
		
		$fieldset->addField('show_at_home', 'select', array(
		  'label'     => Mage::helper('vc_shopbybrands')->__('Show at home'),
		  'name'      => 'show_at_home',
		  'values'    => array(
			  array(
				  'value'     => 1,
				  'label'     => Mage::helper('vc_shopbybrands')->__('Enabled'),
			  ),
			  array(
				  'value'     => 2,
				  'label'     => Mage::helper('vc_shopbybrands')->__('Disabled'),
			  ),
		  ),
		));        
					
		
		$fieldset->addField('is_active', 'select', array(
		  'label'     => Mage::helper('vc_shopbybrands')->__('Status'),
		  'name'      => 'is_active',
		  'values'    => array(
			  array(
				  'value'     => 1,
				  'label'     => Mage::helper('vc_shopbybrands')->__('Enabled'),
			  ),
			  array(
				  'value'     => 2,
				  'label'     => Mage::helper('vc_shopbybrands')->__('Disabled'),
			  ),
		  ),
		));        
		
		if ( Mage::registry('brands_data') ) {
			$data = Mage::registry('brands_data')->getData();
			$form->setValues($data);
		}
		return parent::_prepareForm();
	}
}