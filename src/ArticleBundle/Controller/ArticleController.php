<?php


// src/ArticleBundle/Controller/ArticleController.php


namespace ArticleBundle\Controller;

use ArticleBundle\Entity\Article;
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
    	//Maintenant on va commencer la page d'accueil du blog
    	
    	// Puis on récupèrera tout les articles de blog qui sont déjà crée
    	
    	// Pour récupérer la liste de toutes les annonces : on utilise findAll()
   		$listArticles = $this->getDoctrine()
      ->getManager()
      ->getRepository('ArticleBundle:Article')
      ->findAll()
    ;
    	
    	// Mais pour le moment on va simplement utiliser le template
    	return $this->render('ArticleBundle:ArticleBlog:index.html.twig', array('listArticles' => $listArticles));
    	
    }
	
		
	// La route fait appel à ArticleBundle:ArticleBlog:view,
	// on doit donc définir la méthode viewAction.
	// Cette méthode nous permet de voir un article en particulier.
	public function voirAction($id)
	{
		// On récupère le repository
		$repository = $this->getDoctrine()
		  ->getManager()
		  ->getRepository('ArticleBundle:Article')
		;

		// On récupère l'entité correspondante à l'id $id
		$article = $repository->find($id);

		// $advert est donc une instance de ArticleBundle\Entity\Article
		// ou null si l'id $id  n'existe pas, d'où ce if :
		if (null === $article) {
		  throw new NotFoundHttpException("L'article d'id ".$id." n'existe pas.");
		}

		// Le render ne change pas, on passait avant un tableau, maintenant un objet
		return $this->render('ArticleBundle:ArticleBlog:voir.html.twig', array(
		  'article' => $article));
	
	}


		// La méthode addAction, va permettre l'ajout d'un article sur notre site de blog.		
	public function ajoutAction(Request $request)
	{
		// Création de l'entité
		$article = new Article();
		$article->setDate(new \Datetime());
		$article->setTitle('Mettre le titre ici');
		$article->setAuthor('Qui êtes-vous ?');
		$article->setContent("Mettez ici la description de l'article.");
		
		// On peut ne pas définir ni la date ni la publication,
		// car ces attributs sont définis automatiquement dans le constructeur

		// On crée le formbuilder grace au service form factory
		$formBuilder = $this->get('form.factory')->createBuilder('form', $article);
		
		//On ajoute les champs de l'entité que l'on veut à notre formulaire
		$formBuilder
			->add('title',       'text')
			->add('content',     'textarea')
			->add('author',      'text')
			->add('published',   'checkbox')
			->add('save',        'submit')
		;
		//A partir du formbuilder on génère le formulaire
		$form = $formBuilder->getForm();
		
		$form->HandleRequest($request);
		
		if($form->isValid()) {
			//On l'enregistre en base de donnée
			$em = $this->getDoctrine()->getManager();
			$em->persist($article);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Article enregistré.');
			
			return $this->redirect($this->generateUrl('article_voir', array('id' => $article->getId())));
		}

		// Reste de la méthode qu'on avait déjà écrit
		//if ($request->isMethod('POST')) {
		//  $request->getSession()->getFlashBag()->ajout('article', 'Article bien enregistré.');
		// return $this->redirect($this->generateUrl('article_voir', array('id' => $article->getId())));}

		return $this->render('ArticleBundle:ArticleBlog:ajout.html.twig', array('form' => $form->createView(), ));
	}
    
    
    // Cette fonction permet de supprimer un article qui a déjà été créée
    public function supprimeAction(Request $request){
    	// Tout d'abord, il faudra récupérer l'id de l'article.
    	$article = new Article();
    	
    	$article->getId();
    	// Ensuite, on gère la suppression de la base de donnée.
    	
    	return $this->render('ArticleBundle:ArticleBlog:supprime.html.twig');    	
    }
    
    public function menuAction($limit = 3)
	{
		$listArticles = $this->getDoctrine()
		  ->getManager()
		  ->getRepository('ArticleBundle:Article')
		  ->findBy(
		    array(),                 // Pas de critère
		    array('date' => 'desc'), // On trie par date décroissante
		    $limit,                  // On sélectionne $limit annonces
		    0                        // À partir du premier
		);

		return $this->render('ArticleBundle:ArticleBlog:menu.html.twig', array(
		  'listArticles' => $listArticles
		));
	}
	
	public function modifieAction($id, Request $request)
	{
	// Voilà la fonction qui permet de modifier un article
	$em = $this->getDoctrine()->getManager();

	$article = $em->getRepository('ArticleBundle:Article')->find($id);
	
	$formBuilder = $this->get('form.factory')->createBuilder('form', $article);
	$form = $formBuilder->getForm();
		
	$form->HandleRequest($request);

	return $this->render('ArticleBundle:ArticleBlog:modifie.html.twig', array(
	  'article' => $article
	));
	}

}

