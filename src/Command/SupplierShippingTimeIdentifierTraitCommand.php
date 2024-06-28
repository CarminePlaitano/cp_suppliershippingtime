<?php

namespace Module\Cp_SupplierShippingTime\Command;

use Module\Cp_SupplierShippingTime\ValueObject\SupplierShippingTimeId;

trait SupplierShippingTimeIdentifierTraitCommand
{
  /**
   * @var SupplierShippingTimeId
   */
  private $shippingTimeId;

  public function __construct(SupplierShippingTimeId $shippingTimeId)
  {
    $this->shippingTimeId = $shippingTimeId;
  }

  public function getShippingTimeId(): SupplierShippingTimeId
  {
    return $this->shippingTimeId;
  }
}
