<?php
class VC_ShopByBrands_Helper_Data extends Mage_Core_Helper_Abstract {
	public function getBrandUrl() {
		$identifier = $this->_getRequest()->getParam('identifier').'.html';
		return Mage::getStoreConfig('vc_shopbybrands/general/router').'/'.$identifier;
	}
	
	public function getBrandDetailUrl($brandInfo) {
		$identifier = $brandInfo->getIdentifier();
		$brandR = Mage::getStoreConfig('vc_shopbybrands/general/router');
		$this->_getRequest()->setAlias(Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS, $brandR.'/'.trim($identifier).'.html');
		return $this->_getUrl($brandR, 
			array('_secure' => true, 
			'_use_rewrite' => true,
			'identifier' => trim($identifier)));					
	}
	
	public function getLogo($brandInfo) {
		$rs = '';
		if ($brandInfo && count($brandInfo) && is_file(Mage::helper('vc_shopbybrands')->getImagePath().'/'.$brandInfo->getImage())) {
			$rs = Mage::helper('vc_shopbybrands')->getImageUrl().'/'.$brandInfo->getImage();
		}
		return $rs;
	
	}
	
	
	public function getBrandsInfor() {
		$rs = array();
		$collection = Mage::getModel('vc_shopbybrands/brands')->getCollection()
			->addFieldToFilter('is_active', array('eq' => 1));
			
		if ($collection && $collection->getSize() > 0) {
			foreach ($collection as $item) {
				$rs[$item->getOptionId()] = $item;
			}
		}
		return $rs;
	
	}
	
	public function getOptionIdsUsed() {
		$rs = array();
		$collection = Mage::getModel('vc_shopbybrands/brands')->getCollection()
			->addFieldToSelect(array('option_id'));
			
		if ($collection && $collection->getSize() > 0) {
			foreach ($collection as $item) {
				$rs[] = $item->getOptionId();
			}
		}
		return $rs;
	}
	
	public function preProcessIdentifier($str = '') {
		return preg_replace('#([^(a-z,A-Z,0-9,\-)*])#', '', str_replace(' ', '-', strtolower($str)));
	}
	
	public function getStoreOptionValues($storeId, $attributeId) {
		$values = array();
		$valuesCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
			->setAttributeFilter($attributeId)
			->setStoreFilter($storeId, false)
			->load();
		foreach ($valuesCollection as $item) {
			$values[$item->getId()] = $item->getValue();
		}	
		return $values;
	}
	
	public function getOptionLabel($optionId, $options) {
		if (is_array($options) && count($options) > 0) {
			foreach ($options as $option) {
				if ($option['value'] == $optionId) {
					return $option['label'];
				}
			}
		}
		return null;
	}
	
	public function getOptionsByAttributeId($attributeId = 0) {
		$values = array();
		$optionCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
			->setAttributeFilter($attributeId)
			->setPositionOrder('desc', true)
			->load();
		
		$helper = Mage::helper('core');
		
		$optionIdsUsed = Mage::registry('option_ids_used');
		
		foreach ($optionCollection as $option) {
			$value = array();
			if (is_array($optionIdsUsed) && count($optionIdsUsed) > 0 && in_array($option->getId(), $optionIdsUsed)) {
				continue;
			}
			$value['value'] = $option->getId();
			
			$storeValues = $this->getStoreOptionValues(0, $attributeId);
			$value['label'] = $helper->escapeHtml($storeValues[$option->getId()]);
			//$values[] = new Varien_Object($value);
			$values[] = $value;
		}
		return $values;
	}
	
	public function getOptionsByAttributeCode($attributeCode = '') {
		$collection = Mage::getModel('eav/entity_attribute')->getCollection()
		->addFieldToFilter('attribute_code', $attributeCode);
		$item = $collection->getFirstItem();
		
		if ($item && $item->getId() > 0) {
			return $this->getOptionsByAttributeId($item->getId());
		}
		return array();
	}
	
	public function uploadFile($name) {
		try {
			$exAr = explode(',', str_replace('.', '', Mage::getStoreConfig('vc_shopbybrands/general/image_extension_allow')));
			$uploader = new Varien_File_Uploader($name);
			// Any extention would work
			//$uploader->setAllowedExtensions(Mage::helper('vc_shopbybrands')->getExtensionAr());
			//$uploader->setAllowedExtensions(array('png','gif','jpg','jpeg'));
			$uploader->setAllowedExtensions($exAr);
			$uploader->setAllowRenameFiles(false);
			$uploader->setFilesDispersion(false);
			// We set media as the upload dir
			$path = $this->getImagePath();
			$fileName = $_FILES[$name]['name'];
			
			if (file_exists($path.'/'.$fileName)) {
				$fileName = $this->renameFile($path, $fileName);
			}
			
			$uploader->save($path, $fileName);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		
		return $uploader->getUploadedFileName();	
	}
	
	/**
	@ method : renameFile
	**/
	
	public function renameFile($path, $fileName) {
		$pathinfo = pathinfo($path . '/' . $fileName);
		$fileTmp = $fileBase = preg_replace('/[^0-9,a-z,A-Z]/', '', $pathinfo['filename']);
		$ext = $pathinfo['extension'];
	
		$i = 0;
		while (file_exists($path . '/' . $fileBase . '.' . $ext)) {
			$fileBase = $fileTmp.$i;
			$i++;
		}
		return $fileBase.'.'.$ext;
	}
	
	/**
	@ method : _deleteFile
	**/
	
	public function deleteFile($file) {
		$file = (string)$file;
		if (file_exists($this->getImagePath().'/'.$file)) {
			@unlink($this->getImagePath().'/'.$file);	
		}
	}
	
	/**
	@ method : createFolder
	**/
	
	public function createFolder($name) {
		$path = trim(Mage::getBaseDir('media'), '/').'/'.$name;
		if (!file_exists($path)) {
			mkdir($path);
			chmod($path, 0777);
		}
	}
	
	/**
	@ method : getImagePath
	**/
	
	public function getImagePath() {
		//return trim(Mage::getBaseDir('media'), '/').'/banner';
		return Mage::getBaseDir('media') .'/' . Mage::getStoreConfig('vc_shopbybrands/general/image_folder');
	}
	
	/**
	@ method : getImageUrl
	**/
	
	public function getImageUrl() {
		return trim(Mage::getBaseUrl('media'), '/') .'/'. Mage::getStoreConfig('vc_shopbybrands/general/image_folder');
	}


	/*

	public function getFilterUrl() {
		return $this->_getUrl('vc_shopbybrands/index/filter');
	}
	
	public function getCleanUrl() {
		return $this->getFilterUrl();
	}
	
	
	public function getItemQuery($ar) {
		$rs = array();
		if ($query = Mage::registry('vc_query')) {
			$ar += $query;
			
		}
		
		if (is_array($ar) && count($ar) > 0) {
			foreach ($ar as $k => $v) {
				$rs[] = $k.'='.$v;
			}
		}
		return implode('&', $rs);
	}
	
	public function getDeleteQuery($ar, $removeKey = '') {
		$rs = array();
		if ($query = Mage::registry('vc_query')) {
			$ar += $query;
		}
		
		if (isset($ar[$removeKey])) {
			unset($ar[$removeKey]);
		}
		
		if (is_array($ar) && count($ar) > 0) {
			foreach ($ar as $k => $v) {
				$rs[] = $k.'='.$v;
			}
		}
		return implode('&', $rs);
	}
	
	public function getContainer() {
		$container = '';
		$layout = !Mage::registry('vc_layout') ? Mage::app()->getLayout()->getBlock('root')->getTemplate() : Mage::registry('vc_layout');
		if (strpos($layout, '3columns')) {
			$container =  Mage::getStoreConfig('vc_shopbybrands/general/container_3columns');
		} else if (strpos($layout, '2columns-left')) {
			$container =  Mage::getStoreConfig('vc_shopbybrands/general/container_2columns_left');
		}
	
		return $container;
	}
	
	public function getItemUrl($ar) {
		return Mage::registry('vc_category_url').'?'.(is_string($ar) ? $ar: $this->getItemQuery($ar));
	}
	
	public function getClearedUrl() {
		return Mage::registry('vc_category_url');
	}
	
	public function renderFilter($block, $items, $level) {
		$rs = "<ol>";
		foreach ($items as $_item):
			$rs .= '<li style="margin-left:'.($level*10).'px">';
				 if ($_item->getCount() > 0): 
					$rs .= '<a href="'.$block->urlEscape($_item->getUrl()).'">';
					$rs .= $_item->getLabel();
					if ($block->shouldDisplayProductCount()):
						$rs .='<span class="count">('.$_item->getCount().')</span>';
					endif;
					$rs .= '</a>';
				else:
				
					$rs .= '<span>';
					$rs .= $_item->getLabel();
					if ($block->shouldDisplayProductCount()): 
						$rs .= '<span class="count">('.$_item->getCount().')</span>';
					endif;
					$rs .= '</span>';
				endif;
				
				if (count($_item->getChild()) > 0) {
					$rs .= $this->renderFilter($block, $_item->getChild(), $level+1);
				}
			$rs .= '</li>';
		endforeach;
		$rs .="</ol>";
		return $rs;
	}
	*/
}