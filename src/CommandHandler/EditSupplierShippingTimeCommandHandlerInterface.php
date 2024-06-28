<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\CommandHandler;

use Module\Cp_SupplierShippingTime\Command\EditSupplierShippingTimeCommand;
use Module\Cp_SupplierShippingTime\ValueObject\SupplierShippingTimeId;

interface EditSupplierShippingTimeCommandHandlerInterface
{
  public function handle(EditSupplierShippingTimeCommand $commnad): SupplierShippingTimeId;
}
