<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
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
     * @Route("/", name="index_products")
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('admin/product/index.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/edit/{product}", name="edit_products")
     */
    public function edit($product, Request $request)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($product);
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var Product $product */
            $product = $form->getData();
            $product->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Product updated successfully');
            return $this->redirectToRoute('admin_edit_products', ['product' => $product->getId()]);
        }
        return $this->render('admin/product/edit.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/create", name="create_products")
     * @return Response
     */
    public function create(Request $request)
    {
        $form = $this->createForm(ProductType::class, new Product());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Product $product */
            $product = $form->getData();
            $product->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
            $product->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

            $this->getDoctrine()->getManager()->persist($product);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Product created successfully');
            return $this->redirectToRoute('admin_index_products');
        }
        return $this->render('admin/product/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/store", name="store_products", methods={"POST"})
     */
    public function store(Request $request)
    {
        try {
            $data = $request->request->all();
            $product = new Product();

            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setBody($data['body']);
            $product->setSlug($data['slug']);
            $product->setPrice($data['price']);

            $product->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
            $product->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();

            $this->addFlash('success', 'Product created successfully');

            return $this->redirectToRoute('admin_index_products');
        } catch (\Exception $exception) {
            die($exception->getMessage());
        }
    }

    /**
     * @Route("/remove/{product}", name="remove_products")
     * @param $product
     */
    public function remove($product)
    {
        try {
            $product = $this->getDoctrine()->getRepository(Product::class)->find($product);

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($product);
            $manager->flush();

            $this->addFlash('success', 'Product removed successfully');

            return $this->redirectToRoute('admin_index_products');
        } catch (\Exception $exception) {
            die($exception->getMessage());
        }
    }
}
