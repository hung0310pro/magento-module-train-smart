<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace CheckoutCustom\Attribute\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;


class Agree extends Column
{
    /**#@+
     * Product Status values
     */
    const STATUS_ENABLED = 1;

    const STATUS_DISABLED = 0;

    const STATUS_ENABLED_TEXT = 'Agree';

    const STATUS_DISABLED_TEXT = 'Not Agree';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

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
        array $components = [],
        array $data = []
    )
    {
        $this->storeManager = $storeManager;
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
            foreach ($dataSource['data']['items'] as & $item) {
                $order = new \Magento\Framework\DataObject($item);
                $item['agree'] = $this->convertStatus($order->getAgree());
            }
        }

        return $dataSource;
    }

    /**
     * Convert Status
     * @param string $status
     * @return string
     */
    public function convertStatus(string $status): string
    {
        if ($status == self::STATUS_ENABLED) {
            return self::STATUS_ENABLED_TEXT;
        }

        return self::STATUS_DISABLED_TEXT;
    }
}
