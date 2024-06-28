<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\CommandHandler;

use Module\Cp_SupplierShippingTime\Command\AddSupplierShippingTimeCommand;
use Module\Cp_SupplierShippingTime\ValueObject\SupplierShippingTimeId;

interface AddSupplierShippingTimeCommandHandlerInterface
{
  public function handle(AddSupplierShippingTimeCommand $command): SupplierShippingtimeId;
}
