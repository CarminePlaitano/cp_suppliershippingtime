<?php

namespace Module\Cp_SupplierShippingTime\CommandHandler;

use Module\Cp_SupplierShippingTime\Command\BulkSupplierShippingTimeCommandInterface;

interface BulkDeleteSupplierShippingTimeCommandHandlerInterface
{
  /**
   * @param BulkSupplierShippingTimeCommandInterface $command
   * @return mixed
   */
  public function handle(BulkSupplierShippingTimeCommandInterface $command);
}
