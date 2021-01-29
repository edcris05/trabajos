<?php
namespace Trabajos\News\Model\ResourceModel\Homenews;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Trabajos\News\Model\Homenews', 'Trabajos\News\Model\ResourceModel\Homenews');
    }
}
