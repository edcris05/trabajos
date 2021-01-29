<?php

namespace Trabajos\News\Model\Article\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * @var \Trabajos\News\Model\Article
     */
    protected $article;

    /**
     * Constructor
     *
     * @param \Trabajos\News\Model\Article $article
     */
    public function __construct(\Trabajos\News\Model\Article $article)
    {
        $this->article = $article;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->article->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
