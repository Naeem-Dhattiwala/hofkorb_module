<?php

namespace Hofkorb\Filter\Observer;

use Magento\Framework\Event\ObserverInterface;

class Productoptions implements ObserverInterface
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var \Hofkorb\Filter\Helper\Product
     */
    protected $productHelper;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Hofkorb\Filter\Helper\Product $productHelper
    )
    {
        $this->productRepository = $productRepository;
        $this->productHelper     = $productHelper;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product  = $observer->getProduct();
        $_product = $this->productRepository->getById($product->getId());
        $this->productHelper->updateProducer($_product);
    }
}
