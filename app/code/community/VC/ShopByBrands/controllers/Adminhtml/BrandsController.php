<?php
class VC_ShopByBrands_Adminhtml_BrandsController extends Mage_Adminhtml_Controller_Action {
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('catalog')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Brands Manager'), Mage::helper('adminhtml')->__('Brands Manager'));
		
		return $this;
	}   
 
 	/**
	@ method : indexAction
	**/
	
	public function indexAction() {
		Mage::helper('vc_shopbybrands')->createFolder(Mage::getStoreConfig('vc_shopbybrands/general/image_folder'));	
		$this->_initAction()
			->renderLayout();
	}

	/**
	@ method : editAction
	**/
	
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('vc_shopbybrands/brands')->load($id);
		
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			
			$optionLabel = 	'';		
			if ($id == 0) {
				Mage::register('option_ids_used', Mage::helper('vc_shopbybrands')->getOptionIdsUsed());
			} else {
				$optionAr = Mage::helper('vc_shopbybrands')->getOptionsByAttributeCode(Mage::getStoreConfig('vc_shopbybrands/general/brand'));
				$optionLabel = Mage::helper('vc_shopbybrands')->getOptionLabel($model->getOptionId(), $optionAr);	
						
			}
			Mage::register('brands_label', $optionLabel);
			Mage::register('brands_id', $id);
			Mage::register('brands_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('catalog');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Brands Manager'), Mage::helper('adminhtml')->__('Brands Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Brands News'), Mage::helper('adminhtml')->__('Brands News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('vc_shopbybrands/adminhtml_brands_edit'))
				->_addLeft($this->getLayout()->createBlock('vc_shopbybrands/adminhtml_brands_edit_tabs'));
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vc_shopbybrands')->__('Brands does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
 	/**
	@ method : newAction
	**/
	
	public function newAction() {
		$this->_forward('edit');
	}
	
 	/**
	@ method : saveAction
	**/
	
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$id = $this->getRequest()->getParam('id');
			$model = Mage::getModel('vc_shopbybrands/brands')->load($id);		
			try {
				
				if ($model->getCreatedAt() == NULL) {
					$model->setCreatedAt(now());
				}
				
				$optionAr = Mage::helper('vc_shopbybrands')->getOptionsByAttributeCode(Mage::getStoreConfig('vc_shopbybrands/general/brand'));
				$optionLabel = Mage::helper('vc_shopbybrands')->getOptionLabel($data['option_id'], $optionAr);
				
				if (!$optionLabel) {
					Mage::throwException($this->__('Attribute option is not valid.'));
				}
				
				$identifier = Mage::helper('vc_shopbybrands')->preProcessIdentifier($optionLabel);
				if (!$model->validIdentifier($identifier)) throw new Exception(Mage::helper('vc_shopbybrands')->__('Identifier field is exiting for other item.'));
				
				$model->setIdentifier($identifier)
					->setOptionId($data['option_id'])
					->setMetaKeyword($data['meta_keyword'])
					->setMetaDescription($data['meta_description'])
					->setDescription($data['description'])
					->setShowAtHome($data['show_at_home'])
					->setIsActive(($data['is_active'] >= 1 && $data['is_active'] <= 2) ? $data['is_active'] : 2);
								
				if ($id > 0) {
					$model->setUpdatedAt(date('Y-m-d H:i:s'));
				} else {
					$model->setCreatedAt(date('Y-m-d H:i:s'));
				}
					
				Mage::helper('vc_shopbybrands')->createFolder(Mage::getStoreConfig('vc_shopbybrands/general/image_folder'));
				$ar = array('image');
				foreach ($ar as $name) {
					$isDeleted = false;
					if (isset($data[$name]['delete']) && isset($data[$name]['value'])) {
						Mage::helper('vc_shopbybrands')->deleteFile($data[$name]['value']);
						$data[$name] = '';
						$isDeleted = true;
					}
					
					
					if(isset($_FILES[$name]['name']) && $_FILES[$name]['name'] != '') {
						$data[$name] = Mage::helper('vc_shopbybrands')->uploadFile($name);
					} else if (!$isDeleted) {
						unset($data[$name]);
					}
				}	
				
				if (isset($data[$ar[0]])) {
					$model->setImage($data[$ar[0]]);				
				}				
				
				$model->save();
				
				
								
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vc_shopbybrands')->__('Brands was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vc_shopbybrands')->__('Unable to find Brands to save'));
        $this->_redirect('*/*/');
	}
	
	/**
	@ method : deleteAction
	**/
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$this->_deleteAction($this->getRequest()->getParam('id'));	
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Brands was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

	/**
	@ method : massDeleteAction
	**/
	
    public function massDeleteAction() {
        $ids = $this->getRequest()->getParam('vc_shopbybrands');
        if(!is_array($ids)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Brands(s)'));
        } else {
            try {
                foreach ($ids as $id) {
					$this->_deleteAction($id);
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($ids)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
	/**
	@ method : _deleteAction
	**/
	
	private function _deleteAction($id = 0) {
		$model = Mage::getModel('vc_shopbybrands/brands')->load($id);
		if (strlen($model->getImage()) > 0) {
			Mage::helper('vc_shopbybrands')->deleteFile($model->getImage());
		}
		$model->delete();				
	}

	
}