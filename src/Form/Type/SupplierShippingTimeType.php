<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\Form\Type;

use Module\Cp_SupplierShippingTime\Repository\SupplierShippingTimeRepository;
use PrestaShopBundle\Form\Admin\Type\TranslateType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use PrestaShopBundle\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SupplierShippingTimeType extends TranslatorAwareType
{
  /**
   * @var SupplierShippingTimeRepository
   */
  private $repository;

  public function __construct(
    TranslatorInterface $translator,
    array $locales,
    SupplierShippingTimeRepository $repository
  ) {
    parent::__construct($translator, $locales);
    $this->repository = $repository;
  }

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    parent::buildForm($builder, $options);

    $builder
      ->add('position', NumberType::class, [
        'required' => true,
        'label' => $this->trans('Posizione', 'Modules.Cp_SupplierShippingTime.Admin')
      ])
      ->add('message', TranslateType::class, [
        'type' => TextType::class,
        'required' => true,
        'locales' => $this->locales,
        'hideTabs' => false,
        'label' => $this->trans('Fascia di tempo', 'Modules.Cp_SupplierShippingTime.Admin')
      ])
      ->add('supplier_id', ChoiceType::class, [
        'choices' => $this->repository->getSuppliers(),
        'label' => $this->trans('Fornitore', 'Modules.Cp_SupplierShippingTime.Admin')
      ]);
  }
}
