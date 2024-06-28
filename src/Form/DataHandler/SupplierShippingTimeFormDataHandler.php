<?php

namespace Module\Cp_SupplierShippingTime\Form\DataHandler;

use Module\Cp_SupplierShippingTime\CommandBuilder\SupplierShippingTimeCommandBuilderInterface;
use Module\Cp_SupplierShippingTime\ValueObject\SupplierShippingTimeId;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataHandler\FormDataHandlerInterface;

final class SupplierShippingTimeFormDataHandler implements FormDataHandlerInterface
{
  /**
   * @var CommandBusInterface
   */
  private $commandBus;

  /**
   * @var SupplierShippingTimeCommandBuilderInterface
   */
  private $builder;

  public function __construct(
    CommandBusInterface $commandBus,
    SupplierShippingTimeCommandBuilderInterface $builder
  ) {
    $this->commandBus = $commandBus;
    $this->builder = $builder;
  }

  /**
   * @param array $data
   * @return mixed
   */
  public function create(array $data)
  {
    $command = $this->builder->buildAddCommand($data);
    $shippingTimeId = $this->commandBus->handle($command);
    return $shippingTimeId;
  }

  /**
   * @param $id
   * @param array $data
   * @return mixed
   */
  public function update($id, array $data)
  {
    $command = $this->builder->buildUpdateCommand(new SupplierShippingTimeId($id), $data);
    $shippingTimeId = $this->commandBus->handle($command);
    return $shippingTimeId;
  }
}
