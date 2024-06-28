<?php

namespace Module\Cp_SupplierShippingTime\Command;

use Module\Cp_SupplierShippingTime\ValueObject\SupplierShippingTimeId;

interface SupplierShippingTimeIdentifierCommandInterface
{
  public function getShippingTimeId(): SupplierShippingTimeId;
}
