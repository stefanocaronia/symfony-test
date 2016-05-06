<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Product;

class AddProductController extends Controller {

	/**
     * @Route("/add/{name}/{desc}")
     */
	public function addAction($name,$desc) {
		
		$product = new Product();
		$product->setName($name);
		$product->setPrice(12.4);
		$product->setDescription($desc);		
		$product->setCreated(new \DateTime('now'));
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($product);
		$em->flush();
		 
		return new Response(
            "<html><body>".$product->getId()."</body></html"
        );
	}
}