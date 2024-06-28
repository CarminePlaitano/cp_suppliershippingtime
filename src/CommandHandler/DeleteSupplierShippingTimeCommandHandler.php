<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\CommandHandler;

use Doctrine\ORM\EntityManagerInterface;
use Module\Cp_SupplierShippingTime\Command\DeleteSupplierShippingTimeCommandInterface;
use Module\Cp_SupplierShippingTime\Exception\CannotDeleteSupplierShippingTimeException;
use Module\Cp_SupplierShippingTime\Repository\SupplierShippingTimeRepository;
use Module\Cp_SupplierShippingTime\ValueObject\SupplierShippingTimeId;

class DeleteSupplierShippingTimeCommandHandler implements DeleteSupplierShippingTimeCommandHandlerInterface
{
  /**
   * @var SupplierShippingTimeRepository
   */
  private $repository;

  /**
   * @var EntityManagerInterface
   */
  private $entityManager;

  public function __construct(
    SupplierShippingTimeRepository $repository,
    EntityManagerInterface $entityManager
  ) {
    $this->repository = $repository;
    $this->entityManager = $entityManager;
  }

  public function handle(DeleteSupplierShippingTimeCommandInterface $command): SupplierShippingTimeId
  {
    try {
      $shippingTime = $this->repository->findOneBy([
        'id' => $command->getShippingTimeId()->getValue()
      ]);

      if ($shippingTime) {
        $this->entityManager->remove($shippingTime);
        $this->entityManager->flush();
      }

      return $command->getShippingTimeId();
    } catch (CannotDeleteSupplierShippingTimeException $e) {
      throw new CannotDeleteSupplierShippingTimeException(
        sprintf('Impossibile eliminare tempo di consegna. %s', $e->getMessage())
      );
    }
  }
}
