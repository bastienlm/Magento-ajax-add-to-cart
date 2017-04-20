<?php
/**
 * PH2M_PhAddtocart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Addtocart
 * @copyright  Copyright (c) 2016 PH2M SARL | Bastien Lamamy (bastienlm)
 * @author     PH2M SARL <contact@ph2m.com> | Bastien Lamamy (bastienlm)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class PH2M_PhAddtocart_Model_Observer {

    /**
     * Register quote item to Popup
     *
     * @event checkout_cart_product_add_after
     * @param Varien_Event_Observer $observer
     */
    public function registerQuoteItem(Varien_Event_Observer $observer)
    {
        /** @var Mage_Sales_Model_Quote_Item $item */
        $item = $observer->getEvent()->getQuoteItem();
        Mage::getSingleton('core/session')->setLastProductIdAddedToCart($item->getProductId());
    }

    /**
     * Return response for popup and refresh cart informations
     * Only on product page
     *
     * @event checkout_cart_add_product_complete
     * @param $observer
     */
    public function returnPopupData(Varien_Event_Observer $observer)
    {

        if($observer->getRequest()->getParam('action_from') == 'catalog_product_view'
            && $qty = $observer->getRequest()->getParam('qty')
            && $product = $observer->getRequest()->getParam('product')) {

            Mage::getSingleton('checkout/session')->setNoCartRedirect(true);

            $result                         = array();
            $result['cartHtml']             = $this->_getCartHtml();
            $result['success']              = true;
            $result['addedMsg']             = $this->_getAddedMsgHtml($qty);
            $result['errorMsg']             = Mage::helper('phaddtocart')->__('This product is not available for this quantity');

            $observer->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }
    
    protected function _getCartHtml()
    {
        $child =  Mage::app()->getLayout()->createBlock('checkout/cart_sidebar', 'minicart_content')
            ->addItemRender('default', 'checkout/cart_item_renderer', 'checkout/cart/minicart/default.phtml')
            ->addItemRender('simple', 'checkout/cart_item_renderer', 'checkout/cart/minicart/default.phtml')
            ->addItemRender('grouped', 'checkout/cart_item_renderer_grouped', 'checkout/cart/minicart/default.phtml')
            ->addItemRender('configurable', 'checkout/cart_item_renderer_configurable', 'checkout/cart/minicart/default.phtml')
            ->setTemplate('checkout/cart/minicart/items.phtml');

        $block = Mage::app()->getLayout()->createBlock('checkout/cart_minicart', 'minicart_head')
            ->setChild('minicart_content', $child)
        ;

        $block->setTemplate('checkout/cart/minicart.phtml');
        return $block->toHtml();
    }


    protected function _getAddedMsgHtml($qty)
    {
        if($qty > 1) {
            $html = '<i class="fa fa-check" aria-hidden="true"></i> ' . Mage::helper('phaddtocart')->__('%d products were added to your cart', $qty);
        } else {
            $html = '<i class="fa fa-check" aria-hidden="true"></i> ' . Mage::helper('phaddtocart')->__('1 product added to your cart');
        }

        return $html;
    }


}