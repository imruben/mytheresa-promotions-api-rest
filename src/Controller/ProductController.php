<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    #[Route('/products', name: 'app_product')]
    public function getProducts(Request $request) : JsonResponse
    {
        $category = $request->query->get('category');
        $priceLessThan = $request->query->get('priceLessThan');

        $products = $this->productService->getProductsByCategoryAndPriceLessThan($category, $priceLessThan);

        return new JsonResponse(['products' => $products]);
    }
}
