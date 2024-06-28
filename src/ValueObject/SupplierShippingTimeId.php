<?php

namespace Module\Cp_SupplierShippingTime\ValueObject;

use Module\Cp_SupplierShippingTime\Exception\InvalidSupplierShippingTimeException;

class SupplierShippingTimeId
{
  /**
   * @var int
   */
  private $shippingTimeId;

  public function __construct(int $shippingTimeId)
  {
    $this->assertIsGreaterThanZero($shippingTimeId);
    $this->shippingTimeId = $shippingTimeId;
  }

  /**
   * @return int
   */
  public function getValue(): int
  {
    return $this->shippingTimeId;
  }

  private function assertIsGreaterThanZero(int $shippingTimeId)
  {
    if (0 >= $shippingTimeId) {
      throw new InvalidSupplierShippingTimeException(sprintf('L\'id %s non è valido', var_export($shippingTimeId, true)));
    }
  }
}
