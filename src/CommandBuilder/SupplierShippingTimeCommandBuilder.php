<?php

namespace Module\Cp_SupplierShippingTime\CommandBuilder;

use Module\Cp_SupplierShippingTime\Command\AddSupplierShippingTimeCommand;
use Module\Cp_SupplierShippingTime\Command\EditSupplierShippingTimeCommand;
use Module\Cp_SupplierShippingTime\Command\SupplierShippingTimeCommandInterface;
use Module\Cp_SupplierShippingTime\ValueObject\SupplierShippingTimeId;

class SupplierShippingTimeCommandBuilder implements SupplierShippingTimeCommandBuilderInterface
{
  /**
   * @param array $data
   * @return AddSupplierShippingTimeCommand
   */
  public function buildAddCommand(array $data): AddSupplierShippingTimeCommand
  {
    $command = new AddSupplierShippingTimeCommand();
    $this->build($command, $data);
    return $command;
  }

  /**
   * @param array $data
   * @return EditSupplierShippingTimeCommand
   */
  public function buildUpdateCommand(SupplierShippingTimeId $shippingTimeId, array $data): EditSupplierShippingTimeCommand
  {
    $command = new EditSupplierShippingTimeCommand($shippingTimeId);
    $this->build($command, $data);
    return $command;
  }

  private function build(SupplierShippingTimeCommandInterface $command, array $data)
  {
    if (isset($data['position'])) {
      $command->setPosition((int)$data['position'] ?? 1);
    }

    if (isset($data['supplier_id'])) {
      $command->setSupplierId((int)$data['supplier_id']);
    }

    if (isset($data['message'])) {
      $command->setMessage($data['message']);
    }
  }
}
