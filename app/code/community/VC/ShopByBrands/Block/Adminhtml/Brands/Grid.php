<?php
class VC_ShopByBrands_Block_Adminhtml_Brands_Grid extends Mage_Adminhtml_Block_Widget_Grid {
	public function __construct() {
		parent::__construct();
		$this->setId('brandsGrid');
		$this->setDefaultSort('id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}
	
	/**
	@ method : _prepareCollection
	**/
	
	protected function _prepareCollection() {
		$collection = Mage::getModel('vc_shopbybrands/brands')->getCollection();
		$collection->getSelect()->joinLeft(array('option' => Mage::getModel('core/resource')->getTableName('eav_attribute_option_value')), 
		'main_table.option_id = option.option_id AND option.store_id = 0', array('brand' => 'option.value'));
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	
	/**
	@ method : _prepareColumns
	**/
	
	protected function _prepareColumns() {
		$this->addColumn('id', array(
		  'header'    => Mage::helper('vc_shopbybrands')->__('ID'),
		  'align'     =>'right',
		  'width'     => '50px',
		  'index'     => 'id',
		));
		
		$this->addColumn('brand', array(
		  'header'    => Mage::helper('vc_shopbybrands')->__('Brand'),
		  'align'     =>'left',
		  'index'     => 'brand'
		));
		
		$this->addColumn('image', array(
		  'header'    => Mage::helper('vc_shopbybrands')->__('Logo'),
		  'align'     =>'left',
		  'index'     => 'image',
		  'renderer' => 'vc_shopbybrands/adminhtml_column_renderer_image',
		  'filter'    => false,
		));
		
		$this->addColumn('show_at_home', array(
		  'header'    => Mage::helper('vc_shopbybrands')->__('Show at home'),
		  'align'     => 'left',
		  'width'     => '80px',
		  'index'     => 'show_at_home',
		  'type'      => 'options',
		  'options'   => array(
			  1 => 'Enabled',
			  2 => 'Disabled',
		  ),
		));
		
		
		$this->addColumn('created_at', array(
		  'header'    => Mage::helper('vc_shopbybrands')->__('Created At'),
		  'align'     =>'left',
		  /*'width'     => '50px',*/
		  'index'     => 'created_at',
		));

		$this->addColumn('updated_at', array(
		  'header'    => Mage::helper('vc_shopbybrands')->__('Updated At'),
		  'align'     =>'left',
		  /*'width'     => '50px',*/
		  'index'     => 'updated_at',
		));
		
		
		$this->addColumn('is_active', array(
		  'header'    => Mage::helper('vc_shopbybrands')->__('Status'),
		  'align'     => 'left',
		  'width'     => '80px',
		  'index'     => 'is_active',
		  'type'      => 'options',
		  'options'   => array(
			  1 => 'Enabled',
			  2 => 'Disabled',
		  ),
		));
						
		$this->addColumn('action',
			array(
				'header'    =>  Mage::helper('vc_shopbybrands')->__('Action'),
				'width'     => '100px',
				'type'      => 'action',
				'getter'    => 'getId',
				'actions'   => array(
					array(
						'caption'   => Mage::helper('vc_shopbybrands')->__('Edit'),
						'url'       => array('base'=> '*/*/edit'),
						'field'     => 'id'
					),
					array(
						'caption'   => Mage::helper('vc_shopbybrands')->__('Delete'),
						'url'       => array('base'=> '*/*/delete'),
						'field'     => 'id'
					)
				),
				'filter'    => false,
				'sortable'  => false,
				'index'     => 'stores',
				'is_system' => true,
		));
		
		
		return parent::_prepareColumns();
	}
	
	/**
	@ method : _prepareMassaction
	**/
	
	protected function _prepareMassaction() {
		$this->setMassactionIdField('brands_id');
		$this->getMassactionBlock()->setFormFieldName('vc_shopbybrands');
		
		$this->getMassactionBlock()->addItem('delete', array(
			 'label'    => Mage::helper('vc_shopbybrands')->__('Delete'),
			 'url'      => $this->getUrl('*/*/massDelete'),
			 'confirm'  => Mage::helper('vc_shopbybrands')->__('Are you sure?')
		));
		
		return $this;
	}
	
	/**
	@ method : getRowUrl
	**/
	
	public function getRowUrl($row) {
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
	
}