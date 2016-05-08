<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ProductType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Product;

class ProductController extends Controller
{
    /**
     * @Route("/product/create", name="product_create")
     */
    public function createAction(Request $request)
    {
		
		$product = new Product();
		$product->setCreated(new \DateTime('now'));
		
		$form = $this->createForm(ProductType::class, $product);
		
		$form->add('save', SubmitType::class, array('label' => 'Aggiungi','attr' => array('class'=>'btn-default btn-lg')));
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$db = $this->getDoctrine()->getManager();
			$TAGS = explode(",",$product->getTags());
			$TAGS = array_map("trim",$TAGS);
			$product->setTags($TAGS);			
			$product->uploadImage();			
			$db->persist($product);
			$db->flush();

			return $this->redirect($this->generateUrl('product_list'));
		}

        return $this->render('create.html.twig', array(
            'form' => $form->createView()
        ));		
    }
	
    /**
     * @Route("/product/{id}/edit", name="product_edit", requirements={
	 *     "id": "\d+"
	 * })
     */
    public function editAction($id, Request $request)
    {
		
		$repository = $this->getDoctrine()->getRepository('AppBundle:Product');
		$product = $repository->findOneBy(["id"=>$id]);
		$TAGS = implode(", ",$product->getTags());
		$product->setTags($TAGS);
		$oldimage = $product->impath;
		
		$form = $this->createForm(ProductType::class, $product);
		
		$form->add('save', SubmitType::class, array('label' => 'Salva','attr' => array('class'=>'btn-default btn-lg')));
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$db = $this->getDoctrine()->getManager();
			$TAGS = explode(",",$product->getTags());
			$TAGS = array_map("trim",$TAGS);
			$product->setTags($TAGS);
			$product->uploadImage();
			$db->persist($product);
			$db->flush();
			return $this->redirect($this->generateUrl('product_list'));
		}

        return $this->render('edit.html.twig', array(
            'form' => $form->createView(),			
            'product' => $product,
			'oldimage' => $oldimage			
        ));		
    }
	
    /**
     * @Route("/product/{id}/delete", name="product_delete", requirements={
	 *     "id": "\d+"
	 * })
     */
    public function deleteAction($id, Request $request)
    {
		
		$repository = $this->getDoctrine()->getRepository('AppBundle:Product');
		$product = $repository->findOneBy(["id"=>$id]);
		
		$db = $this->getDoctrine()->getManager();
		if (is_file($product->getAbsoluteImagePath()))
			unlink($product->getAbsoluteImagePath());
		$db->remove($product);
		$db->flush();
		
		$products = $repository->findBy([],['created' => 'ASC']);
		
        return $this->redirectToRoute('product_list');		
    }
	
    /**
     * @Route("/product/list", name="product_list")
     */
    public function listAction(Request $request)
    {
		
		$repository = $this->getDoctrine()->getRepository('AppBundle:Product');
		$products = $repository->findBy([],['created' => 'ASC']);

        return $this->render('list.html.twig', array(
            'products' => $products,
        ));		
    }	
}
