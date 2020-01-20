<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Product;
use App\Form\ProductType;
/**
 * Movie controller.
 * @Route("/api", name="api_")
 */
class ProductController extends FOSRestController
{
    /**
     * Lists all Product.
     * @Rest\Get("/product")
     *
     * @return Response
     */
    public function getProductAction()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findall();
        return $this->handleView($this->view($products));
    }

    /**
     * Remove Product.
     * @Rest\Delete("/product")
     *
     * @param Request $request
     * @return Response
     */
    public function deleteProductAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $data = json_decode($request->getContent(), true);
        $product = $repository->find($data['id']);
        $this->getDoctrine()->getManager()->remove($product);
        $this->getDoctrine()->getManager()->flush();
        return $this->handleView($this->view($product));
    }


    /**
     * Update Product.
     * @Rest\Put("/product")
     *
     * @param Request $request
     * @return Response
     */
    public function putProductAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $data = json_decode($request->getContent(), true);
        $product = $repository->find($data['id']);
        $product->setName($data['name']);
        $this->getDoctrine()->getManager()->persist($product);
        $this->getDoctrine()->getManager()->flush();
        return $this->handleView($this->view($product));

    }


    /**
     * Create Product.
         * @Rest\Post("/product")
     *
     * @return Response
     */
    public function postProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
}