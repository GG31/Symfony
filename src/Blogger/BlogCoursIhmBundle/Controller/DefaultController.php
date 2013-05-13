<?php

namespace Blogger\BlogCoursIhmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogCoursIhmBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    function createAction()
    {
      $product = new Article('Le titre', 'L\'auteur', 'Un petit contenu');
      /*$product->setName('A Foo Bar');
      $product->setPrice('19.99');
      $product->setDescription('Lorem ipsum dolor');*/

      $em = $this->getDoctrine()->getManager();
      $em->persist($product);
      $em->flush();

      return new Response('Created product id '.$product->getId());
    }
    public function indexAction($page)
    {
    	if( $page < 1 )
    	{
      	// On déclenche une exception NotFoundHttpException
      	// Cela va afficher la page d'erreur 404 (on pourra personnaliser cette page plus tard d'ailleurs)
      	throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
    	}
        /*$articles = array(
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
        );*/

        // Puis modifiez la ligne du render comme ceci, pour prendre en compte nos articles :
        /*$antispam = $this->get('blogger_blog_cours_ihm.Article');
        if($antispam->isSpam()){
          throw new \Exception('SPAM !');
        }*/
        $entityManager = $this->getDoctrine()->getManager();
        //$article = $entityManager->find('BloggerBlogCoursIhmBundle:Article', $id);
        $repository = $entityManager->getRepository('BloggerBlogCoursIhmBundle:Article');
        $articles = $repository->findAll();
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
        /*$article = array(
          'titre'   => 'Article par défaut de articleAction !',
          'id'      => 1,
          'auteur'  => 'winzou',
          'contenu' => 'Ce weekend était trop bien. Blabla…',
          'date'    => new \Datetime()
        );*/
        $entityManager = $this->getDoctrine()->getManager();
        //$article = $entityManager->find('BloggerBlogCoursIhmBundle:Article', $id);
        $repository = $entityManager->getRepository('BloggerBlogCoursIhmBundle:Article');
        $article = $repository->find($id);
        if($article==null){
          throw $this->createNotFoundException('Article[id='.$id.'] inexistant');
        }
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
      $article = new Article('Second !', 'auteur2', 'contenu : LOL');
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($article);
      $entityManager->flush();
    	return $this->render('BloggerBlogCoursIhmBundle:Default:ajouter.html.twig');
    }
}
