<?php

namespace Module\Cp_SupplierShippingTime\Command;

abstract class AbstractSupplierShippingTimeCommand implements SupplierShippingTimeCommandInterface
{
  /**
   * @var int
   */
  private $position = 1;

  /**
   * @var int
   */
  private $supplier_id;

  /**
   * @var string[]
   */
  private $message;

  public function getPosition(): int
  {
    return $this->position;
  }

  public function setPosition(int $position): SupplierShippingTimeCommandInterface
  {
    $this->position = $position;
    return $this;
  }

  public function getSupplierId(): int
  {
    return $this->supplier_id;
  }

  public function setSupplierId(int $supplier_id): SupplierShippingTimeCommandInterface
  {
    $this->supplier_id = $supplier_id;
    return $this;
  }

  public function getMessage(): array
  {
    return $this->message;
  }

  public function setMessage(array $message): SupplierShippingTimeCommandInterface
  {
    $this->message = $message;
    return $this;
  }
}
