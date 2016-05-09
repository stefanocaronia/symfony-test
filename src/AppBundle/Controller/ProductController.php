<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ProductType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Product;

class ProductController extends Controller {

	/**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
		// arrivando alla root del sito, redirect su lista prodotti
		return $this->redirectToRoute('product_list');
    }

    /**
     * @Route("/product/create", name="product_create")
     */
    public function createAction(Request $request)
    {
		// istanzio un nuovo prodotto con la data di creazione attuale
		$product = new Product();
		$product->setCreated(new \DateTime('now'));

		// creo il form di edit prodotto
		$form = $this->createForm(ProductType::class, $product);
		$form->add('save', SubmitType::class, array(
			'label' => 'Aggiungi',
			'attr' => array('class'=>'btn-default btn-lg'),
		));

		// importo i nuovi valori nel form
		$form->handleRequest($request);

		// se vengo dal form submit
		if ($form->isSubmitted() && $form->isValid()) {

			// trasformo la stringa lista tag in un array per memorizzarla nel db
			$product->setTags(array_map("trim", explode(",", $product->getTags())));

			// se c'è faccio l'upload dell'immagine
			$product->uploadImage();

			// salvo il nuovo prodotto
			$db = $this->getDoctrine()->getManager();
			$db->persist($product);
			$db->flush();

			// vado alla lista prodotti
			return $this->redirectToRoute('product_list');
		}

		// al primo atterraggio, mostro il form di creazione prodotto
        return $this->render('create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/product/{id}/edit", name="product_edit", requirements={
	 *		"id": "\d+"
	 * })
     */
    public function editAction($id, Request $request)
	{

		// ottengo il repository della tabella prodotti
		$repository = $this->getDoctrine()->getRepository('AppBundle:Product');

		// ottengo il prodotto con l'id richiesta
		$product = $repository->findOneBy(["id"=>$id]);

		// se non esiste il prodotto vado alla lista
		if (!$product) {
			return $this->redirectToRoute('product_list');
		}

		 // converto la lista tag in una stringa
		$product->setTags(implode(", ", $product->getTags()));

		// creo il form di edit prodotto
		$form = $this->createForm(ProductType::class, $product);
		$form->add('save', SubmitType::class, array(
			'label' => 'Salva',
			'attr' => array('class'=>'btn-default btn-lg'),
		));

		// importo i nuovi valori nel form
		$form->handleRequest($request);

		// se vengo dal form submit
		if ($form->isSubmitted() && $form->isValid()) {

			// trasformo la stringa lista tag in un array per memorizzarla nel db
			$product->setTags(array_map("trim", explode(",", $product->getTags())));

			// se c'è faccio l'upload dell'immagine
			$product->uploadImage();

			// salvo il prodotto
			$db = $this->getDoctrine()->getManager();
			$db->persist($product);
			$db->flush();

			// vado alla lista prodotti
			return $this->redirectToRoute('product_list');
		}

		// al primo atterraggio, mostro il form di edit
        return $this->render('edit.html.twig', array(
            'form' => $form->createView(),
            'product' => $product,
        ));
    }

    /**
     * @Route("/product/{id}/delete", name="product_delete", requirements={
	 *     "id": "\d+"
	 * })
     */
    public function deleteAction($id, Request $request)
	{

		// ottengo il repository della tabella prodotti
		$repository = $this->getDoctrine()->getRepository('AppBundle:Product');

		// ottengo il prodotto con l'id richiesta
		$product = $repository->findOneBy(["id"=>$id]);

		// se non esiste il prodotto vado alla lista
		if (!$product) {
			return $this->redirectToRoute('product_list');
		}

		// se c'era un immagine prodotto la elimino
		if (is_file($product->getAbsoluteImagePath())) {
			unlink($product->getAbsoluteImagePath());
		}

		$db = $this->getDoctrine()->getManager();

		// elimino il prodotto
		$db->remove($product);
		$db->flush();

		// vado alla lista prodotti
        return $this->redirectToRoute('product_list');
    }

    /**
     * @Route("/product/list", name="product_list")
     */
    public function listAction(Request $request)
	{

		// ottengo il repository della tabella prodotti
		$repository = $this->getDoctrine()->getRepository('AppBundle:Product');

		// ottengo la lista prodotti ordinata per data di creazione
		$products = $repository->findBy([], ['created' => 'ASC']);

		// mostro la lista prodotti
        return $this->render('list.html.twig', array(
            'products' => $products,
        ));
    }
}
