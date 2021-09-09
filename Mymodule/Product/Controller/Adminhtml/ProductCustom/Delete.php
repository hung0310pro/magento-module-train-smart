<?php

namespace Mymodule\Product\Controller\Adminhtml\ProductCustom;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Mymodule\Product\Api\ProductRepositoryInterface;
use Psr\Log\LoggerInterface;
use Mymodule\Product\Model\ResourceModel\ProductCustom\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * Massactions filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Delete Product Constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        Filter $filter,
        CollectionFactory $collectionFactory,
        LoggerInterface $logger
    )
    {
        $this->productRepository = $productRepository;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->logger = $logger;
        return parent::__construct($context);
    }

    /**
     * Delete product action
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        try {
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/productcustom/index');
            $ids = $this->buildIdProduct();
            if (empty($ids)) {
                $this->messageManager->addErrorMessage(__('Ids is required'));
                return $resultRedirect;
            }
            $this->productRepository->delete($ids);
            $this->messageManager->addSuccessMessage(__('Delete Success !!'));

            return $resultRedirect;
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while delete the product.'));
            $this->logger->critical($e);
        }
    }

    /**
     * Build Id Product
     * @return array
     */
    public function buildIdProduct(): array
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        /** @var \Mymodule\Product\Model\ProductCustom $product */
        $ids = [];
        foreach ($collection->getItems() as $product) {
            $ids[] = $product->getId();
        }

        return $ids;
    }
}