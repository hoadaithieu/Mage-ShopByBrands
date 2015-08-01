<?php
class VC_ShopByBrands_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract
{
    public function initControllerRouters($observer)
    {
		if (Mage::getStoreConfig('vc_shopbybrands/general/enable')) {
			$front = $observer->getEvent()->getFront();
			$vcRouter = new VC_ShopByBrands_Controller_Router();
			$front->addRouter('vc_shopbybrands', $vcRouter);
		}
    }

    public function match(Zend_Controller_Request_Http $request)
    {
        if (!Mage::app()->isInstalled()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect(Mage::getUrl('install'))
                ->sendResponse();
            exit;
        }
		
		
		$pathInfo = trim($request->getPathInfo(), '/');
		//echo $pathInfo;die();
		$pathInfoAr = explode('/', $pathInfo);
		//if ($pathInfoAr[0] == Mage::getStoreConfig('vc_shopbybrands/general/router')) {
		if ($pathInfoAr[0] == Mage::getStoreConfig('vc_shopbybrands/general/router')) {
			if (isset($pathInfoAr[1])) {
				$request->setModuleName('vc_shopbybrands')
					->setControllerName('brands')
					->setActionName('view');
			
				$request->setParams(array('identifier' => str_replace('.html','', $pathInfoAr[1])));
			} else {
				$request->setModuleName('vc_shopbybrands')
					->setControllerName('brands')
					->setActionName('index');
			}
            return true;		
		}
        return false;
    }
}