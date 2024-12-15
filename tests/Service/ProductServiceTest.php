<?php

namespace App\Tests\Service;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    public function testGetProductsByCategoryAndPriceLessThan(): void
    {
        $mockProduct = $this->createMock(Product::class);
        $mockProduct->method('getSku')->willReturn('TEST123');
        $mockProduct->method('getName')->willReturn('Test Product');
        $mockProduct->method('getPrice')->willReturn(100);
        $mockProduct->method('getCurrency')->willReturn('USD');

        $mockCategory = $this->createMock(Category::class);
        $mockCategory->method('getName')->willReturn('Test Category');
        $mockCategory->method('getDiscount')->willReturn('10.00');

        $mockProduct->method('getCategory')->willReturn($mockCategory);
        $mockProduct->method('getDiscount')->willReturn(5);

        $mockRepository = $this->createMock(ProductRepository::class);
        $mockRepository
            ->method('findByCategoryNameAndPriceLessThan')
            ->with('Test Category', 200, 5)
            ->willReturn([$mockProduct]);

        $productService = new ProductService($mockRepository);

        $result = $productService->getProductsByCategoryAndPriceLessThan('Test Category', 200, 5);

        $expected = [
            [
                'sku' => 'TEST123',
                'name' => 'Test Product',
                'category' => 'Test Category',
                'price' => [
                    'original' => 100,
                    'final' => 90.0,
                    'discount_percentage' => '10%',
                    'currency' => 'USD',
                ],
            ],
        ];

        $this->assertEquals($expected, $result);
    }
}
