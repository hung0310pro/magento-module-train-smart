<?php

namespace Mymodule\Product\Api;

interface ProductRepositoryInterface {

    /**
     * GET list productProductRepositoryInterface api
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    // @return \Mymodule\Product\Api\Data\TestRepositoryDataInterface
    public function getList(int $page, int $pageSize);

    /**
     * Save Product Custom
     * @param array $data
     * @return \Mymodule\Product\Api\ProductCustomInterface
     */
    public function save(array $data);

    /**
     * Save Product Custom
     * @param array $ids
     * @return void
     */
    public function delete(array $ids): void;
}