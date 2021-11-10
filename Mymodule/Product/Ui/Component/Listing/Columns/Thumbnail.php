<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mymodule\Product\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Thumbnail
 *
 * @api
 * @since 100.0.2
 */
class Thumbnail extends Column
{

    const ALT_FIELD = 'image';

    const URL_IMAGE = 'product/custom/image/';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        $this->storeManager = $storeManager;
        $this->urlBuilder = $urlBuilder;
        $this->imageHelper = $imageHelper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $productCustom = new \Magento\Framework\DataObject($item);
                $url = $this->imageHelper->getDefaultPlaceholderUrl('small_image');
                if (!empty($item[$fieldName])) {
                    $url = $this->storeManager->getStore()->getBaseUrl(
                            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                        ) . self::URL_IMAGE . $item[$fieldName];
                }
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'product/productcustom/edit',
                    ['id' => $productCustom->getEntityId(), 'store' => $this->context->getRequestParam('store')]
                );
                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_alt'] = $productCustom->getImage() ?: $productCustom->getName();
                $item[$fieldName . '_orig_src'] = $url;
            }
        }

        return $dataSource;
    }
}
