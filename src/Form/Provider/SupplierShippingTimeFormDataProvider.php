<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\Form\Provider;

use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataProvider\FormDataProviderInterface;
use Module\Cp_SupplierShippingTime\Repository\SupplierShippingTimeRepository;
use Module\Cp_SupplierShippingTime\Entity\SupplierShippingTime as SupplierShippingTimeEntity;
use Module\Cp_SupplierShippingTime\Entity\SupplierShippingTimeLang as SupplierShippingTimeLangEntity;

class SupplierShippingTimeFormDataProvider implements FormDataProviderInterface
{
  /**
   * @var SupplierShippingTimeRepository
   */
  private $repository;

  public function __construct(SupplierShippingTimeRepository $repository)
  {
    $this->repository = $repository;
  }

  /**
   * @param $id
   * @return mixed
   */
  public function getData($supplierShippingTimeId)
  {
    /**
     * @var SupplierShippingTimeEntity $supplierShippingTime
     */
    $supplierShippingTime = $this->repository->find($supplierShippingTimeId);
    $data = [
      'position' => $supplierShippingTime->getPosition(),
      'supplier_id' => $supplierShippingTime->getSupplierId(),
    ];

    /**
     * @var SupplierShippingTimeLangEntity
     */
    foreach ($supplierShippingTime->getShippingTimeLangs() as $shippingTimeLang) {
      $data['message'][$shippingTimeLang->getLang()->getId()] = $shippingTimeLang->getMessage();
    }

    return $data;
  }

  /**
   * @return mixed
   */
  public function getDefaultData()
  {
    return [];
  }
}
