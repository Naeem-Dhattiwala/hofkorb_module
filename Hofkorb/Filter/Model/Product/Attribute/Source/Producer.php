<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Hofkorb\Filter\Model\Product\Attribute\Source;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Eav\Model\Entity\Attribute\Source\SourceInterface;
use Magento\Framework\Data\OptionSourceInterface;

class Producer extends AbstractSource implements OptionSourceInterface, SourceInterface
{
    const PRODUCER_CATEGORY_ID = 43;

    /**
     * @var CategoryCollectionFactory
     */
    private $collectionFactory;

    /**
     * Category constructor.
     *
     * @param CategoryCollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function getAllOptions()
    {
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToSelect('*')
                   ->addCategoriesFilter(['in' => static::PRODUCER_CATEGORY_ID])
                   ->addAttributeToSort('name', 'ASC');

        $options[] = [
            'value' => '',
            'label' => __('Please Select')
        ];
        foreach ($collection as $product) {
            $options[] = [
                'value' => $product->getId(),
                'label' => $product->getName()
            ];
        }
        return $options;
    }
}

