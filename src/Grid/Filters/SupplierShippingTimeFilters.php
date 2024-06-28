<?php

/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it attraverso il world-wide-web, per favore invia una email a license@prestashop.com così possiamo inviarti una copia immediatamente.
 *
 * @autore PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\Grid\Filters;

use Module\Cp_SupplierShippingTime\Grid\Definition\Factory\SupplierShippingTimeDefinitionFactory;
use PrestaShop\PrestaShop\Core\Search\Filters;

class SupplierShippingTimeFilters extends Filters
{
  protected $filterId = SupplierShippingTimeDefinitionFactory::GRID_ID;

  /**
   * @return array
   */
  public static function getDefaults()
  {
    return [
      'limit' => 10,
      'offset' => 0,
      'sortBy' => 'id',
      'sortOrder' => 'asc',
      'filters' => [],
    ];
  }
}
