<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Module\Cp_SupplierShippingTime\Entity\SupplierShippingTimeLang;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Module\Cp_SupplierShippingTime\Repository\SupplierShippingTimeRepository")
 * 
 */

class SupplierShippingTime
{
  /**
   * @ORM\Id
   * @ORM\Column(name="id", type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="position", type="integer")
   */
  private $position;

  /**
   * @ORM\Column(name="supplier_id", type="integer")
   */
  private $supplier_id;

  /**
   * @ORM\OneToMany(targetEntity="Module\Cp_SupplierShippingTime\Entity\SupplierShippingTimeLang", cascade={"persist", "remove"}, mappedBy="shippingTime")
   */
  private $shippingTimeLangs;

  public function __construct()
  {
    $this->shippingTimeLangs = new ArrayCollection();
  }

  /**
   * @return int
   */
  public function getId(): int
  {
    return $this->id;
  }

  /**
   * @return int
   */
  public function getPosition(): int
  {
    return $this->position;
  }

  /**
   * @param int $position
   */
  public function setPosition(int $position): void
  {
    $this->position = $position;
  }

  /**
   * @return int
   */
  public function getSupplierId(): int
  {
    return $this->supplier_id;
  }

  /**
   * @param int $supplier_id
   */
  public function setSupplierId(int $supplier_id): void
  {
    $this->supplier_id = $supplier_id;
  }

  public function getShippingTimeLangs()
  {
    return $this->shippingTimeLangs;
  }

  public function addShippingTimeLangs(SupplierShippingTimeLang $shippingTimeLang): SupplierShippingTime
  {
    $this->shippingTimeLangs[] = $shippingTimeLang;
    $shippingTimeLang->setShippingTime($this);
    return $this;
  }
}
