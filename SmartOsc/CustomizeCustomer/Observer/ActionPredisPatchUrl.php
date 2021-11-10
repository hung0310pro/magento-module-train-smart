<?php

namespace SmartOsc\CustomizeCustomer\Observer;

use Magento\Framework\Event\Observer;
use Magento\Customer\Model\Session;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Controller\Result\ForwardFactory;

class ActionPredisPatchUrl implements ObserverInterface
{
    /**
     * @var Session
     */
    protected $_session;

    /**
     * @var ProductRepository
     */
    protected $_productRepository;

    const ACTION_NAME_PRODUCT_DETAIL = 'catalog_product_view';

    /**
     * @var ForwardFactory
     */
    protected $_forwardFactory;

    /**
     * ActionPredisPatchUrl constructor.
     * @param Session $session
     * @param ProductRepository $productRepository
     * @param ForwardFactory $forwardFactory
     */
    public function __construct(
        Session $session,
        ProductRepository $productRepository,
        ForwardFactory $forwardFactory
    )
    {
        $this->_session = $session;
        $this->_productRepository = $productRepository;
        $this->_forwardFactory = $forwardFactory;
    }

    /**
     * Execute Action Pre disPatch Url
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $request = $observer->getEvent()->getRequest();
        $actionFullName = strtolower($request->getFullActionName());
        if ($actionFullName == self::ACTION_NAME_PRODUCT_DETAIL) {
            $product = $this->getInfoProduct($observer->getRequest()->getParam('id'));
            $this->checkProductVip($product);
        }
    }

    /**
     * Redirect404Page
     * @return \Magento\Framework\Controller\Result\Forward
     */
    public function redirect404Page()
    {
        $resultForward = $this->_forwardFactory->create();
        $resultForward->setController('index');
        $resultForward->forward('defaultNoRoute');

        return $resultForward;
    }

    /**
     * Get info about product by product id
     * @param int $id
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function getInfoProduct(int $id)
    {
        return $this->_productRepository->getById($id);
    }

    /**
     * Check Product Vip
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return \Magento\Framework\Controller\Result\Forward|void
     */
    public function checkProductVip($product)
    {
        if ($product->getVipAttributeProduct() && !$this->checkCustomerVip()) {
            return $this->redirect404Page();
        }
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