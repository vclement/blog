<?php


// src/ArticleBundle/Controller/ArticleController.php


namespace ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class ArticleController extends Controller
{

    public function indexAction()

    {
    	//Pour faire un hello world decommenter la ligne ci-dessous.
		//return new Response("Hello World !");
		
		
    	$content = $this
    		->get('templating')
    		->render('ArticleBundle:ArticleBlog:index.html.twig', array('nom' => 'Toto'));
    	return new Response($content);
	}
	
		
	// La route fait appel à ArticleBundle:ArticleBlog:view,
	// on doit donc définir la méthode viewAction.
	// On donne à cette méthode l'argument $id, pour
	// correspondre au paramètre {id} de la route
	public function viewAction($id)
	{
		// $id vaut 5 si l'on a appelé l'URL /platform/advert/5

		// Ici, on récupèrera depuis la base de données
		// l'annonce correspondant à l'id $id.
		// Puis on passera l'annonce à la vue pour
		// qu'elle puisse l'afficher

		return new Response("Affichage de l'annonce d'id : ".$id);
	}

		// ... et la méthode indexAction que nous avons déjà créée
		
	public function addAction(){
		// Cette fonction permet l'ajout d'un article sur le blog
		
		return new Response("Ici se trouve la fonction pour ajouter un article dans le blog.");
	
	}
	
	public function modifieAction(){
		// Cette fonction permet la modification d'un article sur le blog
		
		return new Response("Ici se trouve la fonction pour modifier un article de blog");
	}
    
    public function delAction(){
    	// Cette fonction permet de modifier un article qui a déjà été créée
    	
    	return new Response("Ici se trouve la fonction pour supprimer un article");
    }
   
}

