<?php
namespace Trabajos\DeletePendingOrders\Cron;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;

/**
 * Class CancelOrderPending
 */
class CancelOrderPending
{

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var FilterGroup
     */
    private $filterGroup;

    /**
     * @var OrderManagementInterface
     */
    private $orderManagement;

    /**
     * CancelOrderPending constructor.
     *
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param FilterGroup $filterGroup
     * @param OrderManagementInterface $orderManagement
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        FilterGroup $filterGroup,
        OrderManagementInterface $orderManagement
    ) {
        $this->orderRepository       = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder         = $filterBuilder;
        $this->filterGroup           = $filterGroup;
        $this->orderManagement       = $orderManagement;
    }

    /**
     * @throws \Exception
     */
    public function execute()
    {
        $today          = date("Y-m-d h:i:s");
        $to             = strtotime('-3 days', strtotime($today));
        $to             = date('Y-m-d h:i:s', $to);

        $filterGroupDate      = $this->filterGroup;
        $filterGroupStatus    = clone($filterGroupDate);

        $filterDate      = $this->filterBuilder
            ->setField('updated_at')
            ->setConditionType('to')
            ->setValue($to)
            ->create();
        $filterStatus    = $this->filterBuilder
            ->setField('status')
            ->setConditionType('eq')
            ->setValue('pending')
            ->create();

        $filterGroupDate->setFilters([$filterDate]);
        $filterGroupStatus->setFilters([$filterStatus]);

        $searchCriteria = $this->searchCriteriaBuilder->setFilterGroups(
            [$filterGroupDate, $filterGroupStatus]
        );
        $searchResults  = $this->orderRepository->getList($searchCriteria->create());

        /** @var Order $order */
        foreach ($searchResults->getItems() as $order) {
            $this->orderManagement->cancel($order->getId());
        }
    }
}