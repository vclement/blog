<?php


// src/ArticleBundle/Controller/ArticleController.php


namespace ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ArticleController extends Controller
{

	// C'est la fonction qui renvoie la première page du site. 
	//C'est la page d'accueil, 
	//mais c'est aussi la page qui permet de voir tout les articles.
	
    public function indexAction($page){
    	//Maintenant on va commencer la page d'accueil du blog.
    	
    	//Si la page est inférieur à 1, il y a une erreur
    	if($page < 1){
    		// On déclenche l'exeption et on ouvre une page personnalisé d'erreur 404
    		throw new NotFoundHttpException('Page "'.$page.'" innexistante.');
    	}
    	
    	// Puis on récupèrera tout les articles de blog qui sont déjà crée
    	
    	// Notre liste d'annonce en dur
		$listArticles = array(
		  array(
			'title'   => 'Recherche développpeur Symfony2',
			'id'      => 1,
			'author'  => 'Alexandre',
			'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
			'date'    => new \Datetime()),
		  array(
			'title'   => 'Mission de webmaster',
			'id'      => 2,
			'author'  => 'Hugo',
			'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
			'date'    => new \Datetime()),
		  array(
			'title'   => 'Offre de stage webdesigner',
			'id'      => 3,
			'author'  => 'Mathieu',
			'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
			'date'    => new \Datetime())
		);
    	
    	// Mais pour le moment on va simplement utiliser le template
    	return $this->render('ArticleBundle:ArticleBlog:index.html.twig', array('listArticles' => $listArticles
    	));
    }
	
		
	// La route fait appel à ArticleBundle:ArticleBlog:view,
	// on doit donc définir la méthode viewAction.
	// Cette méthode nous permet de voir un article en particulier.
	public function voirAction($id){
		// On récupère chaque article grâce à son id.
		
		return $this->render('ArticleBundle:ArticleBlog:index.html.twig', array(
  'listArticles' => array()
));
	}


		// La méthode addAction, va permettre l'ajout d'un article sur notre site de blog.		
	public function ajoutAction(Request $request){
		
		// C'est ici que l'on gère l'ajout du formulaire.
		$session = $request->getSession();
		
		//On vérifie que l'utilisateur a bien utilisé la méthode POST
    	if('POST' == $request->getMethod()){
			//Ici on a l'interface de création de l'article puis après l'envoie, on affiche l'article qui vient d'être crée.
			$request->getSession()->getFlashBag()->add('notice', 'Article créé.');
			
			//Puis on va redirige vers l'article.
			return $this->redirect($this->generateUrl('blog_voir', array('id' => 5)));		
		}
		
		// En cas d'absence de méthode POST on redirige vers le formulaire.
		return $this->render('ArticleBundle:ArticleBlog:ajout.html.twig');
	}
	
	
	// La fonction suivante va modifier un article qui a déjà été crée.
	public function modifieAction(){
		// D'abord on récupère l'id de l'article à modifier.
		
		// Puis une fois modifier, on envoie les modifications.
		if('POST' == $request->getMethod()){
			$request->getSession()->getFlashBag()->add('notice', 'Article modifié.');
			return $this->redirect($this->generateUrl('blog_voir', array('id' => 5)));
		}
		
		return $this->render('ArticleBundle:ArticleBlog:modifie.html.twig');
	}
    
    
    // Cette fonction permet de supprimer un article qui a déjà été créée
    public function supprimeAction(){
    	// Tout d'abord, il faudra récupérer l'id de l'article.
    	
    	// Ensuite, on gère la suppression de la base de donnée.
    	
    	return $this->render('ArticleBundle:ArticleBlog:supprime.html.twig');    	
    }
    
    public function menuAction($limit)
	{
	// On fixe en dur une liste ici, bien entendu par la suite
	// on la récupérera depuis la BDD !
	 $listArticles = array(
      array('id' => 2, 'title' => 'Ouverture du blog'),
      array('id' => 5, 'title' => 'Mon premier article'),
      array('id' => 9, 'title' => 'Ce qui va suive dans ce blog')
    );

	return $this->render('ArticleBundle:ArticleBlog:menu.html.twig', array(
	  // Tout l'intérêt est ici : le contrôleur passe les variables nécessaires au template !
	  'listArticles' => $listArticles
	));
	}
   
}

