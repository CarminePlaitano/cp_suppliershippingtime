<?php

namespace Module\Cp_SupplierShippingTime\CommandBuilder;

use Module\Cp_SupplierShippingTime\Command\AddSupplierShippingTimeCommand;
use Module\Cp_SupplierShippingTime\Command\EditSupplierShippingTimeCommand;
use Module\Cp_SupplierShippingTime\ValueObject\SupplierShippingTimeId;

interface SupplierShippingTimeCommandBuilderInterface
{
  public function buildAddCommand(array $data): AddSupplierShippingTimeCommand;
  public function buildUpdateCommand(SupplierShippingTimeId $shippingTimeId, array $data): EditSupplierShippingTimeCommand;
}
