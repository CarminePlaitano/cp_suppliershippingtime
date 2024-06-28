<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\Grid\Definition\Factory;

use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\BulkActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\LinkRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\SubmitRowAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\IdentifierColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\BulkDeleteActionTrait;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShopBundle\Form\Admin\Type\SearchAndResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SupplierShippingTimeDefinitionFactory extends AbstractGridDefinitionFactory
{
  use BulkDeleteActionTrait;

  const GRID_ID = 'supplier_shipping_time';

  /**
   * {@inheritdoc}
   */
  protected function getId()
  {
    return self::GRID_ID;
  }

  /**
   * {@inheritdoc}
   */
  protected function getName()
  {
    return $this->trans('Tempi di consegna', [], 'Modules.Cp_SupplierShippingTime.Admin');
  }

  /**
   * {@inheritdoc}
   */
  protected function getColumns()
  {
    return (new ColumnCollection())
      ->add(
        (new IdentifierColumn('id'))
          ->setName($this->trans('ID', [], 'Admin.Global'))
          ->setOptions([
            'identifier_field' => 'id',
            'bulk_field' => 'id',
            'with_bulk_field' => true,
            'clickable' => false,
          ])
      )
      ->add(
        (new DataColumn('message'))
          ->setName($this->trans('Messaggio', [], 'Admin.Global'))
          ->setOptions([
            'field' => 'message',
          ])
      )
      ->add(
        (new DataColumn('supplier_id'))
          ->setName($this->trans('Id Fornitore', [], 'Admin.Global'))
          ->setOptions([
            'field' => 'supplier_id',
          ])
      )
      ->add(
        (new DataColumn('position'))
          ->setName($this->trans('Posizione', [], 'Admin.Global'))
          ->setOptions([
            'field' => 'position',
          ])
      )
      ->add(
        (new ActionColumn('actions'))
          ->setName($this->trans('Azioni', [], 'Admin.Global'))
          ->setOptions([
            'actions' => (new RowActionCollection())
              ->add(
                (new LinkRowAction('edit'))
                  ->setName($this->trans('Modifica', [], 'Admin.Actions'))
                  ->setIcon('edit')
                  ->setOptions([
                    'route' => 'cp_suppliershippingtime_controller_edit',
                    'route_param_name' => 'idSupplierShippingTime',
                    'route_param_field' => 'id',
                    'clickable_row' => true,
                  ])
              )
              ->add((new SubmitRowAction('delete'))
                  ->setName($this->trans('Elimina', [], 'Modules.CpSupplierShippingTime.Admin'))
                  ->setIcon('delete')
                  ->setOptions([
                    'route' => 'cp_suppliershippingtime_controller_delete',
                    'route_param_name' => 'idSupplierShippingTime',
                    'route_param_field' => 'id',
                    'confirm_message' => $this->trans(
                      'Delete selected item?',
                      [],
                      'Admin.Notifications.Warning'
                    ),
                  ])
              )
          ])
      );
  }

  /**
   * {@inheritdoc}
   */
  protected function getFilters()
  {
    return (new FilterCollection())
      ->add(
        (new Filter('id', TextType::class))
          ->setTypeOptions([
            'required' => false,
            'attr' => [
              'placeholder' => $this->trans('ID', [], 'Admin.Global'),
            ],
          ])
          ->setAssociatedColumn('id')
      )
      ->add(
        (new Filter('position', TextType::class))
          ->setTypeOptions([
            'required' => false,
            'attr' => [
              'placeholder' => $this->trans('Posizione', [], 'Admin.Global'),
            ],
          ])
          ->setAssociatedColumn('position')
      )
      ->add(
        (new Filter('message', TextType::class))
          ->setTypeOptions([
            'required' => false,
            'attr' => ['placeholder' => $this->trans('Messaggio', [], 'Modules.Global')],
          ])
          ->setAssociatedColumn('message')
      )
      ->add(
        (new Filter('supplier_id', TextType::class))
          ->setTypeOptions([
            'required' => false,
            'attr' => ['placeholder' => $this->trans('Id Fornitore', [], 'Modules.Global')],
          ])
          ->setAssociatedColumn('supplier_id')
      )
      ->add(
        (new Filter('actions', SearchAndResetType::class))
          ->setTypeOptions([
            'reset_route' => 'admin_common_reset_search_by_filter_id',
            'reset_route_params' => [
              'filterId' => self::GRID_ID,
            ],
            'redirect_route' => 'cp_suppliershippingtime_controller_configure',
          ])
          ->setAssociatedColumn('actions')
      );
  }

  protected function getBulkActions()
  {
    return (new BulkActionCollection())
      ->add($this->buildBulkDeleteAction('cp_suppliershippingtime_controller_bulk_delete'));
  }
}
