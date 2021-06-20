<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller\Admin
 *
 * @Route("/admin/products", name="admin_")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="admin_product")
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll()??[];
        return $this->render('admin/product/index.html.twig', compact($products));
    }

    /**
     * @Route("/create", name="create_products")
     * @return Response
     */
    public function create()
    {
        return $this->render('admin/product/create.html.twig');
    }

    /**
     * @Route("/store", name="store_products", methods={"POST"})
     */
    public function store(Request $request)
    {
        dd($request->request->all());
    }
}
