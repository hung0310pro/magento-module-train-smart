<?php

namespace SmartOsc\CustomizeCustomer\Plugin;

use Magento\Checkout\Model\Cart;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Model\Session;

class PreventAddToCart
{
    /**
     * @var Session
     */
    protected $_session;

    /**
     * PreventAddToCart constructor.
     *
     * @param Session $session
     */
    public function __construct(
        Session $session
    )
    {
        $this->_session = $session;
    }

    /**
     * Before Add Product
     * @param Cart $subject
     * @param object $productInfo
     * @param null $requestInfo
     * @return array
     */
    public function beforeAddProduct(Cart $subject, object $productInfo, $requestInfo = null): array
    {
        if ($productInfo->getVipAttributeProduct() && !$this->checkCustomerVip()) {
            throw new LocalizedException(__("You can't buy this product, because You aren't VIP"));
        }

        return [$productInfo, $requestInfo];
    }

    /**
     * Check Customer Vip.
     * @return null|int
     */
    public function checkCustomerVip()
    {
        if (!$this->_session->isLoggedIn()) {
            return null;
        }

        if ($this->customerAttributeVip()) {
            return $this->customerAttributeVip()->getValue();
        }

        return null;
    }

    /**
     * Customer Attribute Vip
     * @return null|object
     */
    public function customerAttributeVip()
    {
        return $this->_session->getCustomerData()->getCustomAttribute('customer_vip');
    }
}