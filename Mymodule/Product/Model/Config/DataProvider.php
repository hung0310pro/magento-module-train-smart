<?php

namespace Mymodule\Product\Model\Config;

use Magento\Store\Model\StoreManagerInterface;
use Mymodule\Product\Model\ResourceModel\ProductCustom\CollectionFactory;
use Mymodule\Product\Ui\Component\Listing\Columns\Thumbnail;
use Magento\Catalog\Helper\Image;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $_loadedData;

    protected $collection;

    /**
     * @var Image
     */
    protected $imageHelper;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory,
     * @param Image $imageHelper,
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        Image $imageHelper,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        $this->imageHelper = $imageHelper;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $imageUrl = $this->getProductImageUrl($item->getImage());
            $data = $item->getData();
            $data = $this->buildDataImageProduct($data, $item, $imageUrl);
            $this->_loadedData[$item->getId()] = $data;
        }

        return $this->_loadedData;
    }

    /**
     * Converts product custom image data to acceptable for rendering format
     * @param array $data
     * @param object $item
     * @param string $imageUrl
     * @return array
     */
    private function buildDataImageProduct(array $data, object $item, string $imageUrl): array
    {
        if (!empty($data['image'])) {
            unset($data['image']);
            $data['image'][0]['name'] = $item->getImage();
            $data['image'][0]['url'] = $imageUrl;
        }

        return $data;
    }

    /**
     * Get Product Image Url
     * @param string|null $image
     * @return string
     */
    public function getProductImageUrl(string $image = null): string
    {
        $url = $this->imageHelper->getDefaultPlaceholderUrl('small_image');
        if (!empty($image)) {
            $url = $this->storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . Thumbnail::URL_IMAGE . $image;
        }

        return $url;
    }
}