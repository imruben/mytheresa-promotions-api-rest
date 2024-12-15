<?php

namespace App\Tests\Service;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    public function testGetProductsByCategoryAndPriceLessThanWithCategoryDiscount(): void
    {
        $mockProduct = $this->createMock(Product::class);
        $mockProduct->expects($this->once())->method('getSku')->willReturn('SKU01234');
        $mockProduct->expects($this->once())->method('getName')->willReturn('black boots');
        $mockProduct->expects($this->atLeastOnce())->method('getPrice')->willReturn(100000);
        $mockProduct->expects($this->once())->method('getCurrency')->willReturn('EUR');

        $mockCategory = $this->createMock(Category::class);
        $mockCategory->expects($this->once())->method('getName')->willReturn('boots');
        $mockCategory->expects($this->atLeastOnce())->method('getDiscount')->willReturn(15.00);

        $mockProduct->expects($this->atLeastOnce())->method('getCategory')->willReturn($mockCategory);
        $mockProduct->expects($this->atLeastOnce())->method('getDiscount')->willReturn(30.00);

        $mockRepository = $this->createMock(ProductRepository::class);
        $mockRepository
            ->expects($this->once())
            ->method('findByCategoryNameAndPriceLessThan')
            ->with('boots', 200, 5)
            ->willReturn([$mockProduct]);

        $productService = new ProductService($mockRepository);

        $result = $productService->getProductsByCategoryAndPriceLessThan('boots', 200, 5);

        $expected = [
            [
                'sku' => 'SKU01234',
                'name' => 'black boots',
                'category' => 'boots',
                'price' => [
                    'original' => 100000,
                    'final' => 70000,
                    'discount_percentage' => '30%',
                    'currency' => 'EUR',
                ],
            ],
        ];

        $this->assertEquals($expected, $result);
    }

    public function testGetProductsByCategoryAndPriceLessThanWithProductDiscount(): void
    {
        $mockProduct = $this->createMock(Product::class);
        $mockProduct->expects($this->once())->method('getSku')->willReturn('SKU01234');
        $mockProduct->expects($this->once())->method('getName')->willReturn('black boots');
        $mockProduct->expects($this->atLeastOnce())->method('getPrice')->willReturn(100000);
        $mockProduct->expects($this->once())->method('getCurrency')->willReturn('EUR');


        $mockCategory = $this->createMock(Category::class);
        $mockCategory->expects($this->once())->method('getName')->willReturn('boots');
        $mockCategory->expects($this->atLeastOnce())->method('getDiscount')->willReturn(null);

        $mockProduct->expects($this->atLeastOnce())->method('getCategory')->willReturn($mockCategory);
        $mockProduct->expects($this->atLeastOnce())->method('getDiscount')->willReturn(8.00);

        $mockRepository = $this->createMock(ProductRepository::class);
        $mockRepository
            ->expects($this->once())
            ->method('findByCategoryNameAndPriceLessThan')
            ->with('boots', 200, 5)
            ->willReturn([$mockProduct]);

        $productService = new ProductService($mockRepository);

        $result = $productService->getProductsByCategoryAndPriceLessThan('boots', 200, 5);

        $expected = [
            [
                'sku' => 'SKU01234',
                'name' => 'black boots',
                'category' => 'boots',
                'price' => [
                    'original' => 100000,
                    'final' => 92000,
                    'discount_percentage' => '8%',
                    'currency' => 'EUR',
                ],
            ],
        ];

        $this->assertEquals($expected, $result);
    }
}
