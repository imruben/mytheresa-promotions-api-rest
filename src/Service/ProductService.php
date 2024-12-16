<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;

readonly class ProductService
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    public function getProductsByCategoryAndPriceLessThan(?string $categoryName, ?int $priceLessThan = null, int $limit = 5) : array
    {
        $products = $this->productRepository->findByCategoryNameAndPriceLessThan($categoryName, $priceLessThan, $limit);

        $productsResponse = [];

        foreach ($products as $product) {
            $productsResponse[] =
                [
                    'sku' => $product->getSku(),
                    'name' => $product->getName(),
                    'category' => $product->getCategory()?->getName(),
                    'price' => [
                        'original' => $product->getPrice(),
                        'final' => $this->getProductFinalPrice($product),
                        'discount_percentage' => $this->getProductDiscount($product)
                            ? $this->getProductDiscount($product) . '%'
                            : null,
                        'currency' => $product->getCurrency(),
                    ],
                ];
        }

        return $productsResponse;
    }

    private function getProductFinalPrice(Product $product) : int
    {
        $discount = $this->getProductDiscount($product);

        return (int) round($discount ? $product->getPrice() * (1 - $discount / 100) : $product->getPrice());
    }

    private function getProductDiscount(Product $product) : ?float
    {
        return max($product->getCategory()?->getDiscount(), $product->getDiscount());
    }
}
