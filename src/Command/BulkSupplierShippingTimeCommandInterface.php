<?php

namespace Module\Cp_SupplierShippingTime\Command;

interface BulkSupplierShippingTimeCommandInterface
{
  public function getSupplierShippingTimeIds(): array;

  public function setSupplierShippingTimeIds(array $shippingTimeIds): BulkSupplierShippingTimeCommandInterface;
}
