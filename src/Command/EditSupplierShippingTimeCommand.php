<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\Command;

final class EditSupplierShippingTimeCommand extends AbstractSupplierShippingTimeCommand implements EditSupplierShippingTimeCommandInterface
{
  use SupplierShippingTimeIdentifierTraitCommand;
}
