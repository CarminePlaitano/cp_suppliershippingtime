<?php

declare(strict_types=1);

namespace Module\Cp_SupplierShippingTime\Grid\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\DoctrineSearchCriteriaApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Query\Filter\DoctrineFilterApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;
use PrestaShop\PrestaShop\Core\Grid\Query\Filter\SqlFilters;

/**
 * Defines all required sql statements to render supplier shipping time list.
 */
class SupplierShippingTimeQueryBuilder extends AbstractDoctrineQueryBuilder
{
  /**
   * @var DoctrineSearchCriteriaApplicatorInterface
   */
  private $searchCriteriaApplicator;

  /**
   * @var int
   */
  private $contextLanguageId;

  /**
   * @var DoctrineFilterApplicatorInterface
   */
  private $filterApplicator;

  public function __construct(
    Connection $connection,
    string $dbPrefix,
    DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator,
    int $contextLanguageId,
    DoctrineFilterApplicatorInterface $filterApplicator
  ) {
    parent::__construct($connection, $dbPrefix);
    $this->searchCriteriaApplicator = $searchCriteriaApplicator;
    $this->contextLanguageId = $contextLanguageId;
    $this->filterApplicator = $filterApplicator;
  }

  /**
   * @param SearchCriteriaInterface $searchCriteria
   * @return QueryBuilder
   */
  public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria)
  {
    $qb = $this->getQueryBuilder($searchCriteria->getFilters());
    $qb
      ->select('sst.`id`, sst.`position`, sst.`supplier_id`')
      ->addSelect('sstl.`id_lang`, sstl.`message`');

    $this->searchCriteriaApplicator
      ->applyPagination($searchCriteria, $qb);
    // ->applySorting($searchCriteria, $qb);

    return $qb;
  }

  /**
   * @param SearchCriteriaInterface $searchCriteria
   * @return QueryBuilder
   */
  public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria)
  {
    $qb = $this->getQueryBuilder($searchCriteria->getFilters());
    $qb->select('COUNT(sst.`id`)');

    return $qb;
  }

  /**
   * Gets query builder.
   *
   * @param array $filterValues
   *
   * @return QueryBuilder
   */
  private function getQueryBuilder(array $filterValues): QueryBuilder
  {
    $qb = $this->connection
      ->createQueryBuilder()
      ->from($this->dbPrefix . 'supplier_shipping_time', 'sst')
      ->leftJoin(
        'sst',
        $this->dbPrefix . 'supplier_shipping_time_lang',
        'sstl',
        'sst.`id` = sstl.`id_supplier_shipping_time`'
      )
      ->andWhere('sstl.`id_lang` = :id_lang')
      ->setParameter('id_lang', $this->contextLanguageId);

    $sqlFilters = new SqlFilters();
    $sqlFilters
      ->addFilter(
        'id',
        'sst.`id`',
        SqlFilters::WHERE_STRICT
      )
      ->addFilter(
        'position',
        'sst.`position`',
        SqlFilters::WHERE_STRICT
      )
      ->addFilter(
        'supplier_id',
        'sst.`supplier_id`',
        SqlFilters::WHERE_STRICT
      )
      ->addFilter(
        'message',
        'sstl.`message`',
        SqlFilters::WHERE_LIKE
      );

    $this->filterApplicator->apply($qb, $sqlFilters, $filterValues);

    foreach ($filterValues as $filterName => $filter) {
      if ('position' === $filterName) {
        $qb->andWhere('sst.`position` = :position');
        $qb->setParameter('position', $filter);
        continue;
      }

      if ('supplier_id' === $filterName) {
        $qb->andWhere('sst.`supplier_id` = :supplier_id');
        $qb->setParameter('supplier_id', $filter);
        continue;
      }

      if ('message' === $filterName) {
        $qb->andWhere('sstl.`message` LIKE :message');
        $qb->setParameter('message', '%' . $filter . '%');
        continue;
      }
    }

    return $qb;
  }
}
