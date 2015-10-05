<?php


// src/OC/PlatformBundle/Controller/BlogController.php


namespace ArticleBundle\Controller;

use Symfony\Component\HttpFoundation\Response;


class BlogController
{

    public function indexAction()

    {
		return new Response("Hello World !");
    }
}

