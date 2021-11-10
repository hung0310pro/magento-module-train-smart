<?php

namespace Mymodule\Product\Controller\Adminhtml\ProductCustom;

use Magento\Backend\App\Action\Context;
use Mymodule\Product\Model\ProductCustom;
use Psr\Log\LoggerInterface;
use Magento\Framework\Controller\ResultFactory;
use Mymodule\Product\Api\ProductRepositoryInterface;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var ProductCustom
     */
    protected $productCustom;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Save Product Constructor.
     * @param Context $context
     * @param LoggerInterface $logger
     * @param ProductCustom $productCustom
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger,
        ProductCustom $productCustom,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->productCustom = $productCustom;
        $this->logger = $logger;
        $this->productRepository = $productRepository;
        return parent::__construct($context);
    }

    /**
     * Save product action
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $productPostData = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        try {
            if (empty($productPostData)) {
                $this->messageManager->addErrorMessage(__("Save Fail !!"));
                return $resultRedirect->setPath('*/productcustom/new');
            }
            $data = $this->productCustom->convertDataImageProduct($productPostData);
            $this->productRepository->save($data);
            $this->messageManager->addSuccessMessage(__('Save Success !!'));

        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving the product.'));
            $this->logger->critical($e);
        }

        return $resultRedirect->setPath('*/productcustom/index');
    }
}

