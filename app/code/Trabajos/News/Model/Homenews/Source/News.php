<?php

namespace Trabajos\News\Model\Homenews\Source;

use Magento\Framework\Data\OptionSourceInterface;

class News implements OptionSourceInterface
{
    /**
     * @var \Trabajos\News\Model\ArticleFactory
     */
    protected $news;

    /**
     * Constructor
     *
     * @param \Trabajos\News\Model\ArticleFactory $news
     */
    public function __construct(\Trabajos\News\Model\ArticleFactory $news)
    {
        $this->news = $news;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->news->create()->getCollection()->setOrder('created_at', 'desc');;
        $options = [];
        $options[] = ['value' => '0', 'label' => __('Select...')];
        foreach ($collection as $key => $value) {
            $options[] = [
                'label' => $value->getTitle(),
                'value' => $value->getId(),
            ];
        }
        return $options;
    }
}
