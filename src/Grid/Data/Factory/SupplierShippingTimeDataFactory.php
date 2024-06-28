<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\Grid\Data\Factory;

use PrestaShop\PrestaShop\Core\Grid\Data\Factory\GridDataFactoryInterface;
use PrestaShop\PrestaShop\Core\Grid\Data\GridData;
use PrestaShop\PrestaShop\Core\Grid\Record\RecordCollection;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

class SupplierShippingTimeDataFactory implements GridDataFactoryInterface
{

  /**
   * @var GridDataFactoryInterface
   */
  private $gridDataFactory;

  /**
   * @param GridDataFactoryInterface $gridDataFactory
   */
  public function __construct(
    GridDataFactoryInterface $gridDataFactory
  ) {
    $this->gridDataFactory = $gridDataFactory;
  }

  /**
   * @param SearchCriteriaInterface $searchCriteria
   * @return GridData
   */
  public function getData(SearchCriteriaInterface $searchCriteria)
  {
    $supplierShippingTimesData = $this->gridDataFactory->getData($searchCriteria);
    $modifiedRecords = $this->applyModification($supplierShippingTimesData->getRecords()->all());

    return new GridData(
      new RecordCollection($modifiedRecords),
      $supplierShippingTimesData->getRecordsTotal(),
      $supplierShippingTimesData->getQuery()
    );
  }

  private function applyModification(array $rows)
  {
    return $rows;
  }
}
