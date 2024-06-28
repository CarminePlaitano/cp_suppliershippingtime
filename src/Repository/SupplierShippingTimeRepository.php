<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\Repository;

use Doctrine\ORM\EntityRepository;

class SupplierShippingTimeRepository extends EntityRepository
{
  public function getSuppliers()
  {
    $query = new \DbQuery();
    $query->from('supplier')
      ->select('name, id_supplier');

    $suppliers = \Db::getInstance()->executeS($query);
    $data = [];

    foreach ($suppliers as $supplier) {
      $data[$supplier['name']] = $supplier['id_supplier'];
    }

    return $data;
  }
}
