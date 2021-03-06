<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mymodule\Product\Ui\Component\Listing;

use Magento\Customer\Model\ResourceModel\Grid\Collection as GridCollection;
use Magento\Framework\Api\Filter;
use Magento\Framework\Data\Collection;
use Magento\Framework\Data\Collection\AbstractDb;

/**
 * Full text filter for customer listing data source
 */
class FulltextFilter extends \Magento\Framework\View\Element\UiComponent\DataProvider\FulltextFilter
{
    /**
     * @inheritdoc
     */
    public function apply(Collection $collection, Filter $filter)
    {
        if (!$collection instanceof AbstractDb) {
            throw new \InvalidArgumentException('Database collection required.');
        }

        /** @var GridCollection $gridCollection */
        $gridCollection = $collection;
        $gridCollection->addFullTextFilter(trim($filter->getValue()));
    }
}
