<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\CommandHandler;

use Doctrine\ORM\EntityManagerInterface;
use Module\Cp_SupplierShippingTime\Command\BulkSupplierShippingTimeCommandInterface;
use Module\Cp_SupplierShippingTime\Exception\InvalidBulkSupplierShippingTimeException;
use Module\Cp_SupplierShippingTime\Exception\InvalidSupplierShippingTimeException;
use Module\Cp_SupplierShippingTime\Repository\SupplierShippingTimeRepository;

class BulkDeleteSupplierShippingTimeCommandHandler implements BulkDeleteSupplierShippingTimeCommandHandlerInterface
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

  /**
   * @param BulkSupplierShippingTimeCommandInterface $command
   * @return mixed
   */
  public function handle(BulkSupplierShippingTimeCommandInterface $command)
  {
    try {
      foreach ($command->getSupplierShippingTimeIds() as $shippingTimeId) {
        $supplierShippingTime = $this->repository->findOneBy([
          'id' => $shippingTimeId->getValue()
        ]);

        if (!$supplierShippingTime) {
          throw new InvalidSupplierShippingTimeException('Il tempo di consegna [' . $shippingTimeId->getValue() . '] non è valido');
        }

        $this->entityManager->remove($supplierShippingTime);
        $this->entityManager->flush();
      }
    } catch (InvalidBulkSupplierShippingTimeException $e) {
      throw new InvalidBulkSupplierShippingTimeException(
        sprintf('Errore nell\'eliminazione dei tempi di consegna: %s', $e->getMessage())
      );
    }
  }
}
