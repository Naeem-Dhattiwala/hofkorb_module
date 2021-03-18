<?php
/**
 * @author        Theodor Flavian Hanu <th@cloudlab.at>.
 * @copyright     Copyright(c) 2021 CloudLab AG (http://cloudlab.ag)
 * @link          http://www.cloudlab.ag
 */

namespace Hofkorb\Filter\Helper;

class Product
{
    public function updateProducer($product)
    {
        $relatedProducts = $product->getRelatedProducts();
        $producer        = null;
        if (!empty($relatedProducts)) {
            foreach ($relatedProducts as $relatedProduct) {
                if ($relatedProduct->getPosition() == 1) {
                    $producer = $relatedProduct->getId();
                    break;
                }
            }
        }
        $product->addAttributeUpdate('producer', $producer, 0);
    }
}
