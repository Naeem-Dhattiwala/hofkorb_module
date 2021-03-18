<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Hofkorb\Filter\Setup\Patch\Data;

use Hofkorb\Filter\Model\Product\Attribute\Source\Producer;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class ApplyProducerToAllProducts implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected $productCollection;
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var \Hofkorb\Filter\Helper\Product
     */
    protected $productHelper;

    /**
     * Constructor
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
     * @param \Magento\Catalog\Api\ProductRepositoryInterface                $productRepository
     * @param \Hofkorb\Filter\Helper\Product                                 $productHelper
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Hofkorb\Filter\Helper\Product $productHelper
    ) {
        $this->productCollection = $collectionFactory->create();
        $this->productRepository = $productRepository;
        $this->productHelper = $productHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $products = $this->productCollection->addCategoriesFilter(['nin' => Producer::PRODUCER_CATEGORY_ID]);
        foreach ($products->getItems() as $item) {
            try {
                $product = $this->productRepository->getById($item->getId());
                $this->productHelper->updateProducer($product);
            } catch (\Exception $e) {

            }
        }
    }

    public function revert()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
        
        ];
    }
}

