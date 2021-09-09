<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Mymodule\Product\Model\ResourceModel\Grid;

use Mymodule\Product\Model\ResourceModel\ProductCustom;
use Magento\Customer\Ui\Component\DataProvider\Document;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;

/**
 * Collection to present grid of customers on admin area
 */
class Collection extends SearchResult
{
    /**
     * @var ResolverInterface
     */
    private $localeResolver;

    /**
     * @inheritdoc
     */
    protected $document = Document::class;

    /**
     * @inheritdoc
     */
    protected $_map = [
        'fields' =>
            [
                'entity_id' => 'main_table.entity_id',
                'name' => 'main_table.name',
                'sku' => 'main_table.sku',
                'description' => 'main_table.description',
                'created_at' => 'main_table.created_at',
                'updated_at' => 'main_table.updated_at',
                'product_sku' => 'cpe.sku'
            ]
    ];

    /**
     * @param EntityFactory $entityFactory
     * @param Logger $logger
     * @param FetchStrategy $fetchStrategy
     * @param EventManager $eventManager
     * @param ResolverInterface $localeResolver
     * @param string $mainTable
     * @param string $resourceModel
     */
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        ResolverInterface $localeResolver,
        $mainTable = 'product_custom',
        $resourceModel = ProductCustom::class
    ) {
        $this->localeResolver = $localeResolver;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }

    /**
     * @inheritdoc
     */
    // add more field from other table.
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()
            ->joinLeft(
                ['cpe' => $this->getTable('catalog_product_entity')],
                'main_table.entity_id = cpe.entity_id',
                ['product_sku' => 'cpe.sku']
            );

        return $this;
    }

    /**
     * Add fulltext filter
     *
     * @param string $value
     * @return $this
     */
    public function addFullTextFilter(string $value)
    {
        $fields = $this->getFulltextIndexColumns();
        $whereCondition = '';
        foreach ($fields as $key => $field) {
            $condition = $this->_getConditionSql(
                $this->getConnection()->quoteIdentifier($field),
                ['like' => "%$value%"]
            );
            $whereCondition .= ($key === 0 ? '' : ' OR ') . $condition;
        }

        if ($whereCondition) {
            $this->getSelect()->where($whereCondition);
        }

        return $this;
    }

    /**
     * Returns list of columns from fulltext index
     *
     * @return array
     */
    private function getFulltextIndexColumns(): array
    {
        $indexes = $this->getConnection()->getIndexList($this->getMainTable());
        foreach ($indexes as $index) {
            if (strtoupper($index['INDEX_TYPE']) == 'FULLTEXT') {
                return $index['COLUMNS_LIST'];
            }
        }
        return [];
    }
}
