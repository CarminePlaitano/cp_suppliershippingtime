<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\CommandHandler;

use Module\Cp_SupplierShippingTime\CommandHandler\AddSupplierShippingTimeCommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use PrestaShopBundle\Entity\Repository\LangRepository;
use Module\Cp_SupplierShippingTime\Command\AddSupplierShippingTimeCommand;
use Module\Cp_SupplierShippingTime\ValueObject\SupplierShippingTimeId;
use Module\Cp_SupplierShippingTime\Entity\SupplierShippingTime as SupplierShippingTimeEntity;
use Module\Cp_SupplierShippingTime\Entity\SupplierShippingTimeLang as SupplierShippingTimeLangEntity;
use Module\Cp_SupplierShippingTime\Exception\CannotAddSupplierShippingTimeException;

final class AddSupplierShippingTimeCommandHandler implements AddSupplierShippingTimeCommandHandlerInterface
{
  /**
   * @var LangRepository
   */
  private $langRepository;

  /**
   * @var EntityManagerInterface
   */
  private $entityManager;

  public function __construct(LangRepository $langRepository, EntityManagerInterface $entityManager)
  {
    $this->langRepository = $langRepository;
    $this->entityManager = $entityManager;
  }

  /**
   * @param AddSupplierShippingTimeCommand
   * @return SupplierShippingTimeId
   * @throws CannotAddSupplierShippingTimeException
   */
  public function handle(AddSupplierShippingTimeCommand $command): SupplierShippingTimeId
  {
    $entity = new SupplierShippingTimeEntity();
    $this->createSupplierShippingTimeCommand($entity, $command);
    return new SupplierShippingTimeId($entity->getId());
  }

  private function createSupplierShippingTimeCommand(SupplierShippingTimeEntity $shippingTime, AddSupplierShippingTimeCommand $command)
  {
    try {
      $shippingTime->setPosition($command->getPosition());
      $shippingTime->setSupplierId($command->getSupplierId());

      $languages = $this->langRepository->findAll();

      foreach ($languages as $language) {
        $shippingTimeLang = new SupplierShippingTimeLangEntity();
        $shippingTimeLang->setShippingTime($shippingTime);
        $shippingTimeLang->setLang($language);
        if (isset($command->getMessage()[$language->getId()])) {
          $shippingTimeLang->setMessage($command->getMessage()[$language->getId()]);
        }
        $shippingTime->addShippingTimeLangs($shippingTimeLang);
      }

      $this->entityManager->persist($shippingTime);
      $this->entityManager->flush();
    } catch (CannotAddSupplierShippingTimeException $e) {
      throw new CannotAddSupplierShippingTimeException(
        sprintf('Errore: impossibile aggiungere la fascia di tempo di consegna. %s', $e->getMessage())
      );
    }
  }
}
