<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager) : void
    {
        $categories = [
            [
                'name' => 'boots',
                'discount' => '30.00',
            ],
            [
                'name' => 'sandals',
                'discount' => null,
            ],
            [
                'name' => 'sneakers',
                'discount' => null,
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = new Category();
            $category->setName($categoryData['name']);
            $category->setDiscount($categoryData['discount']);
            $manager->persist($category);

            $this->addReference('category-' . $categoryData['name'], $category);
        }

        $manager->flush();
    }
}
