<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Module\Cp_SupplierShippingTime\Repository\SupplierShippingTimeRepository")
 * 
 */

class SupplierShippingTimeLang
{
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="Module\Cp_SupplierShippingTime\Entity\SupplierShippingTime", inversedBy="shippingTimeLangs")
   * @ORM\JoinColumn(name="id_supplier_shipping_time", referencedColumnName="id", nullable=false)
   */
  private $shippingTime;

  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="PrestaShopBundle\Entity\Lang")
   * @ORM\JoinColumn(name="id_lang", referencedColumnName="id_lang", nullable=false, onDelete="CASCADE")
   */
  private $lang;

  /**
   * @ORM\Column(name="message", type="string", length=255)
   */
  private $message;

  /**
   * @return mixed
   */
  public function getShippingTime()
  {
    return $this->shippingTime;
  }

  /**
   * @param mixed $shippingTime
   * @return SupplierShippingTimeLang
   */
  public function setShippingTime(SupplierShippingTime $shippingTime): SupplierShippingTimeLang
  {
    $this->shippingTime = $shippingTime;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getLang()
  {
    return $this->lang;
  }

  /**
   * @param mixed $lang
   * @return SupplierShippingTimeLang
   */
  public function setLang($lang): SupplierShippingTimeLang
  {
    $this->lang = $lang;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getMessage()
  {
    return $this->message;
  }

  /**
   * @param mixed $message
   * @return SupplierShippingTimeLang
   */
  public function setMessage(string $message): SupplierShippingTimeLang
  {
    $this->message = $message;
    return $this;
  }
}
