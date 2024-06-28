<?php

declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
  exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
  require_once __DIR__ . '/vendor/autoload.php';
}

use Module\Cp_SupplierShippingTime\Controller\Admin\ConfigureController;
// use PrestaShop\PrestaShop\Core\Search\Filters\SupplierFilters;
// use Doctrine\DBAL\Query\QueryBuilder;
// use Doctrine\ORM\EntityRepository;
// use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\DataColumn;
// use PrestaShop\PrestaShop\Core\Grid\Definition\GridDefinitionInterface;
// use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
// use Symfony\Component\Form\Extension\Core\Type\TextType;

class Cp_SupplierShippingTime extends Module
{
  public function __construct()
  {
    $this->name = 'cp_suppliershippingtime';
    $this->version = '1.0.0';
    $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_,];
    $this->author = 'Carmine Plaitano';

    parent::__construct();

    $this->displayName = 'Tempi di consegna - Fornitori';
    $this->description = 'Modulo per la creazione e l\'assegnazione dei tempi di consegna dei fornitori';

    $tabNames = [];
    foreach (Language::getLanguages(true) as $lang) {
      $tabNames[$lang['locale']] = $this->trans('Tempi di consegna - Fornitori', [], 'Modules.CpSupplierShippingTime.Admin', $lang['locale']);
    }

    $this->tabs = [
      [
        'route_name' => 'cp_suppliershippingtime_controller_configure',
        'class_name' => ConfigureController::CP_TAB_CLASS_NAME,
        'visible' => true,
        'name' => $tabNames,
        'icon' => 'time_to_leave',
        'parent_class_name' => 'AdminParentShipping',
      ]
    ];
  }

  public function install()
  {
    return parent::install() and
      $this->installDB();
  }

  public function installDB()
  {
    $sqlShippingTime  = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'supplier_shipping_time` (
      `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `position` INT(11) UNSIGNED NOT NULL,
      `supplier_id` INT(11) UNSIGNED NOT NULL,
      PRIMARY KEY(`id`)
      ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8mb4';

    $sqlShippingTimeLang  = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'supplier_shipping_time_lang` (
      `id_supplier_shipping_time` INT(11) UNSIGNED NOT NULL,
      `id_lang` INT(11) UNSIGNED NOT NULL,
      `message` VARCHAR(255) NOT NULL,
      PRIMARY KEY(`id_supplier_shipping_time`, `id_lang`)
      ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8mb4';

    $db = Db::getInstance();

    if (!$db->execute($sqlShippingTime))
      return false;

    if (!$db->execute($sqlShippingTimeLang))
      return false;

    return true;
  }

  public function uninstall()
  {
    return parent::uninstall() and
      $this->uninstallDB();
  }

  public function uninstallDB()
  {
    $sqlShippingTime = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'supplier_shipping_time`';

    $sqlShippingTimeLang = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'supplier_shipping_time_lang`';

    $db = Db::getInstance();

    if (!$db->execute($sqlShippingTime))
      return false;

    if (!$db->execute($sqlShippingTimeLang))
      return false;

    return true;
  }

  public function getContent()
  {
    Tools::redirectAdmin(
      $this->context->link->getAdminLink(ConfigureController::CP_TAB_CLASS_NAME)
    );
  }

  public function isUsingNewTranslationSystem()
  {
    return true;
  }
}
