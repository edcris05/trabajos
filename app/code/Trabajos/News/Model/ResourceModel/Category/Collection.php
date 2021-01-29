<?php
namespace Trabajos\News\Model\ResourceModel\Category;

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
        $this->_init('Trabajos\News\Model\Category', 'Trabajos\News\Model\ResourceModel\Category');
    }
}
