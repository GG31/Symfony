<?php

namespace Blogger\BlogCoursIhmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($page)
    {
    	if( $page < 1 )
    	{
      	// On déclenche une exception NotFoundHttpException
      	// Cela va afficher la page d'erreur 404 (on pourra personnaliser cette page plus tard d'ailleurs)
      	throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
    	}
        $articles = array(
    array(
      'titre'   => 'Article 1 par défaut dans array.0',
      'id'      => 1,
      'auteur'  => 'winzou',
      'contenu' => 'Ce weekend était trop bien. Blabla…',
      'date'    => new \Datetime()),
    array(
      'titre'   => 'Article 2 par défaut dans array.1',
      'id'      => 2,
      'auteur' => 'winzou',
      'contenu' => 'Bientôt prêt pour le jour J. Blabla…',
      'date'    => new \Datetime()),
    array(
      'titre'   => 'Article 3 par défaut dans array.2',
      'id'      => 3,
      'auteur' => 'M@teo21',
      'contenu' => '+500% sur 1 an, fabuleux. Blabla…',
      'date'    => new \Datetime())
        );
        // Puis modifiez la ligne du render comme ceci, pour prendre en compte nos articles :
        $antispam = $this->get('blogger_blog_cours_ihm.Article');
        if($antispam->isSpam("p")){
          throw new \Exception('SPAM !');
        }
        return $this->render('BloggerBlogCoursIhmBundle:Default:index.html.twig', array(
        'articles' => $articles
        ));
    }

    public function contactAction()
    {
    	return $this->render('BloggerBlogCoursIhmBundle:Default:contact.html.twig');
    }

    public function articleAction($id)
    {
        $article = array(
          'titre'   => 'Article par défaut de articleAction !',
          'id'      => 1,
          'auteur'  => 'winzou',
          'contenu' => 'Ce weekend était trop bien. Blabla…',
          'date'    => new \Datetime()
        );
     
        // Puis modifiez la ligne du render comme ceci, pour prendre en compte nos articles :
        return $this->render('BloggerBlogCoursIhmBundle:Default:article.html.twig', array(
        'article' => $article
        ));
    }

    public function commentAction($id)
    {
    	return $this->render('BloggerBlogCoursIhmBundle:Default:comment.html.twig', array('id' => $id));
    }

    public function ajouterAction()
    {
    	/*if($this->get('request')->getMethod() == 'POST')
    	{
    		$this->get('session')->getFlashBag()->add('notice', 'Article bien enregistré');
    		return $this->render('BloggerBlogCoursIhmBundle:Default:article.html.twig', array('id' => 0));
    	}*/

    	return $this->render('BloggerBlogCoursIhmBundle:Default:ajouter.html.twig');
    }
}
