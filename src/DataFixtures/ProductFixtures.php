<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager) : void
    {
        $bootsCategory = $this->getReference('category-boots', Category::class);
        $sandalsCategory = $this->getReference('category-sandals', Category::class);
        $sneakersCategory = $this->getReference('category-sneakers', Category::class);

        $productsData = [
            [
                'sku' => '000001',
                'name' => 'BV Lean leather ankle boots',
                'category' => $bootsCategory,
                'price' => 89000,
                'discount' => null,
            ],
            [
                'sku' => '000002',
                'name' => 'BV Lean leather ankle boots',
                'category' => $bootsCategory,
                'price' => 99000,
                'discount' => null,
            ],
            [
                'sku' => '000003',
                'name' => 'Ashlington leather ankle boots',
                'category' => $bootsCategory,
                'price' => 71000,
                'discount' => '15.00',
            ],
            [
                'sku' => '000004',
                'name' => 'Naima embellished suede sandals',
                'category' => $sandalsCategory,
                'price' => 79500,
                'discount' => null,
            ],
            [
                'sku' => '000005',
                'name' => 'Nathane leather sneakers',
                'category' => $sneakersCategory,
                'price' => 59000,
                'discount' => null,
            ],
        ];

        foreach ($productsData as $productData) {
            $product = new Product();
            $product->setSku($productData['sku']);
            $product->setName($productData['name']);
            $product->setPrice($productData['price']);
            $product->setDiscount($productData['discount']);
            $product->setCategory($productData['category']);
            $product->setCurrency('EUR');

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
