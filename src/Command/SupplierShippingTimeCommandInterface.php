<?php

namespace Module\Cp_SupplierShippingTime\Command;

interface SupplierShippingTimeCommandInterface
{
  public function getPosition(): int;

  public function getSupplierId(): int;

  public function getMessage(): array;

  public function setPosition(int $position): SupplierShippingTimeCommandInterface;

  public function setSupplierId(int $supplier_id): SupplierShippingTimeCommandInterface;

  public function setMessage(array $message): SupplierShippingTimeCommandInterface;
}
