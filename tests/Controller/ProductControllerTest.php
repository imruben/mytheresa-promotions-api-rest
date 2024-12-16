<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testGetProducts() : void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/products', [
            'category' => 'boots',
            'priceLessThan' => 90000,
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(200);

        $responseContent = $client->getResponse()->getContent();
        $expectedResponseContent = '{"products":[{"sku":"000001","name":"BV Lean leather ankle boots","category":"boots","price":{"original":89000,"final":62300,"discount_percentage":"30%","currency":"EUR"}},{"sku":"000003","name":"Ashlington leather ankle boots","category":"boots","price":{"original":71000,"final":49700,"discount_percentage":"30%","currency":"EUR"}}]}';

        self::assertEquals($expectedResponseContent, $responseContent);
    }
}
