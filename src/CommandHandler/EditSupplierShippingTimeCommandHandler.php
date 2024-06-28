<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\CommandHandler;

use Module\Cp_SupplierShippingTime\CommandHandler\EditSupplierShippingTimeCommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use PrestaShopBundle\Entity\Repository\LangRepository;
use Module\Cp_SupplierShippingTime\Command\EditSupplierShippingTimeCommand;
use Module\Cp_SupplierShippingTime\ValueObject\SupplierShippingTimeId;
use Module\Cp_SupplierShippingTime\Entity\SupplierShippingTime as SupplierShippingTimeEntity;
use Module\Cp_SupplierShippingTime\Entity\SupplierShippingTimeLang as SupplierShippingTimeLangEntity;
use Module\Cp_SupplierShippingTime\Exception\CannotUpdateSupplierShippingTimeException;
use Module\Cp_SupplierShippingTime\Repository\SupplierShippingTimeRepository;

final class EditSupplierShippingTimeCommandHandler implements EditSupplierShippingTimeCommandHandlerInterface
{
  /**
   * @var LangRepository
   */
  private $langRepository;

  /**
   * @var SupplierShippingTimeRepository
   */
  private $repository;

  /**
   * @var EntityManagerInterface
   */
  private $entityManager;

  public function __construct(
    LangRepository $langRepository,
    SupplierShippingTimeRepository $repository,
    EntityManagerInterface $entityManager
  ) {
    $this->langRepository = $langRepository;
    $this->repository = $repository;
    $this->entityManager = $entityManager;
  }

  /**
   * @param EditSupplierShippingTimeCommand
   * @return SupplierShippingTimeId
   * @throws CannotUpdateSupplierShippingTimeException
   */
  public function handle(EditSupplierShippingTimeCommand $command): SupplierShippingTimeId
  {
    $entity = $this->repository->find($command->getShippingTimeId()->getValue());
    $this->updateSupplierShippingTimeCommand($entity, $command);
    return new SupplierShippingTimeId($entity->getId());
  }

  private function updateSupplierShippingTimeCommand(SupplierShippingTimeEntity $shippingTime, EditSupplierShippingTimeCommand $command)
  {
    try {
      $shippingTime->setPosition($command->getPosition());
      $shippingTime->setSupplierId($command->getSupplierId());

      $languages = $this->langRepository->findAll();

      foreach ($languages as $language) {
        $shippingTimeLang = null;

        foreach ($shippingTime->getShippingTimeLangs() as $stl) {
          if ($stl->getLang()->getId() == $language->getId()) {
            $shippingTimeLang = $stl;
          }
        }

        if (null === $shippingTimeLang) {
          $shippingTimeLang = new SupplierShippingTimeLangEntity();
        }

        $shippingTimeLang->setShippingTime($shippingTime);
        $shippingTimeLang->setLang($language);
        if (isset($command->getMessage()[$language->getId()])) {
          $shippingTimeLang->setMessage($command->getMessage()[$language->getId()]);
        }

        $shippingTime->addShippingTimeLangs($shippingTimeLang);
      }

      $this->entityManager->persist($shippingTime);
      $this->entityManager->flush();
    } catch (CannotUpdateSupplierShippingTimeException $e) {
      throw new CannotUpdateSupplierShippingTimeException(
        sprintf('Errore: impossibile modificare la fascia di tempo di consegna. %s', $e->getMessage())
      );
    }
  }
}
