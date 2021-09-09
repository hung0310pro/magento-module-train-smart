<?php

namespace Mymodule\Product\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Mymodule\Product\Api\Data\TestRepositoryDataInterfaceFactory;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\Product\Type;

class ProductRepository implements \Mymodule\Product\Api\ProductRepositoryInterface
{

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Mymodule\Product\Model\ResourceModel\ProductCustomFactory
     */
    protected $productCustomResource;

    /**
     * @var Status
     */
    protected $productStatus;

    /**
     * @var Visibility
     */
    protected $productVisibility;

    /**
     * @var JsonFactory
     */
    protected $jsonResultFactory;

    /**
     * @var ProductSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var TestRepositoryDataInterfaceFactory
     */
    protected $testRepositoryDataInterfaceFactory;

    /**
     * @var ProductCustomFactory
     */
    protected $productCustomFactory;

    /**
     * ProductRepository constructor.
     * @param CollectionFactory $collectionFactory
     * @param Status $productStatus
     * @param Visibility $productVisibility
     * @param JsonFactory $jsonResultFactory
     * @param ProductSearchResultsInterfaceFactory $searchResultsFactory
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param TestRepositoryDataInterfaceFactory $testRepositoryDataInterfaceFactory
     * @param ProductCustomFactory $productCustomFactory
     * @param ResourceModel\ProductCustomFactory $productCustomResource
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Status $productStatus,
        Visibility $productVisibility,
        JsonFactory $jsonResultFactory,
        ProductSearchResultsInterfaceFactory $searchResultsFactory,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        TestRepositoryDataInterfaceFactory $testRepositoryDataInterfaceFactory,
        ProductCustomFactory $productCustomFactory,
        \Mymodule\Product\Model\ResourceModel\ProductCustom $productCustomResource
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->testRepositoryDataInterfaceFactory = $testRepositoryDataInterfaceFactory;
        $this->productCustomFactory = $productCustomFactory;
        $this->productCustomResource = $productCustomResource;
    }

    /**
     * @inheritdoc
     */
    public function getList(int $page, int $pageSize)
    {
        /*
        // return a array to json TestRepositoryDataInterface, TestRepositoryData
       $check = $this->testRepositoryDataInterfaceFactory->create();
       $check->setName('Hung Lm');
       $check->setAge(23);
       $check->setAddress('aaaaaa');
        */

        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
        $collection = $this->collectionFactory->create();
        $this->extensionAttributesJoinProcessor->process($collection);
        $collection->addAttributeToSelect('*')
            ->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()])
            ->addAttributeToFilter('visibility', ['in' => $this->productVisibility->getVisibleInSiteIds()])
            ->addFieldToFilter('type_id', ['eq' => Type::TYPE_SIMPLE])
            ->setPageSize($pageSize)
            ->setCurPage($page);

        $collection->load();

        $collection->addCategoryIds();
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }

    /**
     * @inheritdoc
     */
    public function save(array $data)
    {
        $productCustom = $this->productCustomFactory->create();
        $productCustom->setData($data);

        return $productCustom->save();
    }

    /**
     * @inheritdoc
     */
    public function delete(array $ids): void
    {
        $this->productCustomResource->deleteProduct($ids);
    }
}
