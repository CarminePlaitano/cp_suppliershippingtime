<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\Controller\Admin;

use Module\Cp_SupplierShippingTime\Grid\Definition\Factory\SupplierShippingTimeDefinitionFactory;
use Module\Cp_SupplierShippingTime\Command\DeleteSupplierShippingTimeCommand;
use Module\Cp_SupplierShippingTime\Command\BulkDeleteSupplierShippingTimeCommand;
use Module\Cp_SupplierShippingTime\Exception\InvalidSupplierShippingTimeException;
use Module\Cp_SupplierShippingTime\Grid\Filters\SupplierShippingTimeFilters;
use Module\Cp_SupplierShippingTime\ValueObject\SupplierShippingTimeId;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use PrestaShopBundle\Service\Grid\ResponseBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfigureController extends FrameworkBundleAdminController
{
  const CP_TAB_CLASS_NAME = 'AdminCpSupplierShippingTime';

  /**
   * List quotes
   * 
   * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))")
   *
   * @param SupplierShippingTimeFilters $filters
   *
   * @return Response
   */

  public function indexAction(SupplierShippingTimeFilters $filters)
  {
    $gridFactory = $this->get('cp_suppliershippingtime.grid.grid_factory');
    $grid = $gridFactory->getGrid($filters);

    return $this->render(
      '@Modules/cp_suppliershippingtime/views/templates/admin/configure.html.twig',
      [
        'enableSidebar' => true,
        'layoutTitle' => $this->trans('Tempi di consegna - Fornitori', 'Modules.Cp_SupplierShippingTime.Admin'),
        'supplierShippingTimeGrid' => $this->presentGrid($grid),
        'layoutHeaderToolbarBtn' => $this->getIndexToolBarButtons(),
      ]
    );
  }

  public function searchAction(Request $request): RedirectResponse
  {
    /**
     * @var ResponseBuilder $responseBuilder
     */
    $responseBuilder = $this->get('prestashop.bundle.grid.response_builder');

    return $responseBuilder->buildSearchResponse(
      $this->get('cp_suppliershippingtime.grid.definition.factory'),
      $request,
      SupplierShippingTimeDefinitionFactory::GRID_ID,
      'cp_suppliershippingtime_controller_configure'
    );
  }

  public function createAction(Request $request)
  {
    $formBuilder = $this->get('cp_suppliershippingtime.form.identifiable.object.builder');
    $form = $formBuilder->getForm();
    $form->handleRequest($request);

    $formHandler = $this->get('cp_suppliershippingtime.form.identifiable.object.handler');
    $result = $formHandler->handle($form);
    if ($result->getIdentifiableObjectId() !== null) {
      $this->addFlash('success', $this->trans('Tempo di consegna aggiunto con successo', 'Modules.Cp_SupplierShippingTime.Admin'));
      return $this->redirectToRoute('cp_suppliershippingtime_controller_configure');
    }

    return $this->render(
      '@Modules/cp_suppliershippingtime/views/templates/admin/create.html.twig',
      [
        'enableSidebar' => true,
        'layoutTitle' => $this->trans('Crea tempo di consegna - Fornitori', 'Modules.Cp_SupplierShippingTime.Admin'),
        'layoutHeaderToolbarBtn' => $this->getCreateToolBarButtons(),
        'supplierShippingTimeForm' => $form->createView()
      ]
    );
  }

  public function editAction($idSupplierShippingTime, Request $request)
  {
    $formBuilder = $this->get('cp_suppliershippingtime.form.identifiable.object.builder');
    $form = $formBuilder->getFormFor($idSupplierShippingTime);
    $form->handleRequest($request);

    $formHandler = $this->get('cp_suppliershippingtime.form.identifiable.object.handler');
    $result = $formHandler->handleFor($idSupplierShippingTime, $form);

    if ($result->getIdentifiableObjectId() !== null) {
      $this->addFlash('success', $this->trans('Tempo di consegna modificato con successo', 'Modules.Cp_SupplierShippingTime.Admin'));
      return $this->redirectToRoute('cp_suppliershippingtime_controller_configure');
    }

    return $this->render(
      '@Modules/cp_suppliershippingtime/views/templates/admin/create.html.twig',
      [
        'enableSidebar' => true,
        'layoutTitle' => $this->trans('Modifica tempo di consegna - Fornitori', 'Modules.Cp_SupplierShippingTime.Admin'),
        'layoutHeaderToolbarBtn' => $this->getCreateToolBarButtons(),
        'supplierShippingTimeForm' => $form->createView()
      ]
    );
  }

  public function deleteAction(int $idSupplierShippingTime, Request $request)
  {
    $response = $this->getCommandBus()->handle(new DeleteSupplierShippingTimeCommand(new SupplierShippingTimeId($idSupplierShippingTime)));
    if ($response) {
      $this->addFlash(
        'success',
        $this->trans('Tempo di consegna eliminato con successo', 'Modules.Cp_SupplierShippingTime.Admin')
      );
    } else {
      $this->addFlash(
        'error',
        $this->trans('Non è estato possibile eliminare questo tempo di consegna', 'Modules.Cp_SupplierShippingTime.Admin')
      );
    }
    return $this->redirectToRoute('cp_suppliershippingtime_controller_configure');
  }

  public function deleteBulkAction(Request $request)
  {
    $shippingTimeToDelete = $request->request->get('supplier_shipping_time_id');

    try {
      if (!empty($shippingTimeToDelete)) {
        $shippingTimeToDelete = array_map(function ($shippingTime) {
          return (int) $shippingTime;
        }, $shippingTimeToDelete);

        $this->getCommandBus()->handle(new BulkDeleteSupplierShippingTimeCommand($shippingTimeToDelete));

        $this->addFlash(
          'success',
          $this->trans('Tempi di consegna eliminati con successo', 'Modules.Cp_SupplierShippingTime.Admin')
        );

        return $this->redirectToRoute('cp_suppliershippingtime_controller_configure');
      }
    } catch (InvalidSupplierShippingTimeException $e) {
      throw new InvalidSupplierShippingTimeException(
        sprintf('Tempi di consegna selezionati non validi: %s', $e->getMessage())
      );
    }
  }

  public function getIndexToolBarButtons()
  {
    return [
      'add' => [
        'desc' => $this->trans('Aggiungi tempo di consegna', 'Modules.Cp_SupplierShippingTime.Admin'),
        'icon' => 'add_circle_outline',
        'href' => $this->generateUrl('cp_suppliershippingtime_controller_create')
      ],
    ];
  }

  public function getCreateToolBarButtons()
  {
    return [
      'add' => [
        'desc' => $this->trans('Lista tempi di consegna', 'Modules.Cp_SupplierShippingTime.Admin'),
        'icon' => 'view_compact',
        'href' => $this->generateUrl('cp_suppliershippingtime_controller_configure')
      ]
    ];
  }
}
