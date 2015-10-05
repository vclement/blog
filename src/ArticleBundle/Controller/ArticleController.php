<?php


// src/ArticleBundle/Controller/ArticleController.php


namespace ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class ArticleController extends Controller
{

    public function indexAction()

    {
    	$content = $this
    		->get('templating')
    		->render('ArticleBundle:ArticleBlog:index.html.twig');
    	return new Response($content);
    
		//Pour faire un hello world decommenter la ligne ci-dessous.
		//return new Response("Hello World !");
    }
}

