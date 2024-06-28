<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\Command;

use Module\Cp_SupplierShippingTime\Exception\InvalidBulkSupplierShippingTimeException;
use Module\Cp_SupplierShippingTime\ValueObject\SupplierShippingTimeId;

abstract class AbstractBulkSupplierShippingTimeCommand implements BulkSupplierShippingTimeCommandInterface
{
  /**
   * @var SupplierShippingTimeId[]
   */
  private $shippingTimeIds;

  public function __construct(array $shippingTimeIds)
  {
    if ($this->assertIsEmptyOrContainsNonIntegerValues($shippingTimeIds)) {
      throw new InvalidBulkSupplierShippingTimeException('Uno o più id dei tempi di consegna non è valido');
    }
    $this->setSupplierShippingTimeIds($shippingTimeIds);
  }

  public function getSupplierShippingTimeIds(): array
  {
    return $this->shippingTimeIds;
  }

  public function setSupplierShippingTimeIds(array $shippingTimeIds): BulkSupplierShippingTimeCommandInterface
  {
    foreach ($shippingTimeIds as $id) {
      $this->shippingTimeIds[] = new SupplierShippingTimeId($id);
    }

    return $this;
  }

  private function assertIsEmptyOrContainsNonIntegerValues(array $ids): bool
  {
    return empty($ids) || $ids !== array_filter($ids, 'is_int');
  }
}
