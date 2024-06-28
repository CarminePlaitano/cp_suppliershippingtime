<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\CommandHandler;

use Module\Cp_SupplierShippingTime\Command\DeleteSupplierShippingTimeCommandInterface;
use Module\Cp_SupplierShippingTime\ValueObject\SupplierShippingTimeId;

interface DeleteSupplierShippingTimeCommandHandlerInterface
{
  public function handle(DeleteSupplierShippingTimeCommandInterface $commnad): SupplierShippingTimeId;
}
