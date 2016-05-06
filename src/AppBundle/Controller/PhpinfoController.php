<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class PhpinfoController extends Controller {

	/**
     * @Route("/info")
     */
	public function indexAction() {
		return new Response(
            '<html><body>'.phpinfo().'</body></html>'
        );
	}
	/**
     * @Route("/info/ciao/{name}")
     */
	public function ciaoAction($name) {
		return $this->render('info.html.twig',array('name' => $name));
	}
}