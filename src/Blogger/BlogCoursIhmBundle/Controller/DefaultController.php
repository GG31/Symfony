<?php

namespace Blogger\BlogCoursIhmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogCoursIhmBundle\Entity\Article;
use Blogger\BlogCoursIhmBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Response;
use Blogger\BlogCoursIhmBundle\Form\ArticleType;
use Blogger\BlogCoursIhmBundle\Form\CommentType;

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

        $entityManager = $this->getDoctrine()->getManager();
        //$article = $entityManager->find('BloggerBlogCoursIhmBundle:Article', $id);
        $repository = $entityManager->getRepository('BloggerBlogCoursIhmBundle:Article');
        $date = new \Datetime();
        $articles = $repository->findBy(array(), null, 12, 12*($page-1));
        return $this->render('BloggerBlogCoursIhmBundle:Default:index.html.twig', array(
        'articles' => $articles, 'page' => $page
        ));
    
    }

    public function contactAction()
    {
    	return $this->render('BloggerBlogCoursIhmBundle:Default:contact.html.twig');
    }

    public function articleAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        //$article = $entityManager->find('BloggerBlogCoursIhmBundle:Article', $id);
        $repository = $entityManager->getRepository('BloggerBlogCoursIhmBundle:Article');
        $article = $repository->find($id);
        if($article==null){
          throw $this->createNotFoundException('Article[id='.$id.'] inexistant');
        }
        // Puis modifiez la ligne du render comme ceci, pour prendre en compte nos articles :

        //$article = $entityManager->find('BloggerBlogCoursIhmBundle:Article', $id);
        $repository = $entityManager->getRepository('BloggerBlogCoursIhmBundle:Comment');
        $date = new \Datetime();
        $comments = $repository->findByArticle(array('article' => $article), array('creationDate' => 'desc'));

          $comment = new Comment();
          $comment->setArticle($article);
          $form = $this->createForm(new CommentType, $comment);
          $request = $this->get('request');
          if($request->getMethod() == 'POST'){
            $form->bind($request);
            if($form->isValid()){
              $entityManager->persist($comment);
              $entityManager->flush();
              $comments = $repository->findByArticle(array('article' => $article), array('creationDate' => 'desc'));
              return $this->render('BloggerBlogCoursIhmBundle:Default:article.html.twig', array('article'=> $article, 'comments' => $comments, 'form'=>$form->createView()));
            }
          }
        
        return $this->render('BloggerBlogCoursIhmBundle:Default:article.html.twig', array(
        'article' => $article, 'comments' => $comments, 'form'=>$form->createView()));
    }

    public function commentAction($id)
    {
    	return $this->render('BloggerBlogCoursIhmBundle:Default:comment.html.twig', array('id' => $id));
    }

    public function ajouterAction()
    {
      $article = new Article();
      /*$formBuilder = $this->createFormBuilder($article);
      $formBuilder 
                    -> add('titre', 'text')
                    -> add('auteur', 'text')
                    -> add('content', 'textarea');
      $form = $formBuilder->getForm();*/

      
      $form = $this->createForm(new ArticleType, $article);
      $request = $this->get('request');
      if($request->getMethod() == 'POST'){
        $form->bind($request);
        if($form->isValid()){
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($article);
          $entityManager->flush();
          $comment = new Comment();
          $comment->setArticle($article);
          $form = $this->createForm(new CommentType, $comment);
          $repository = $entityManager->getRepository('BloggerBlogCoursIhmBundle:Comment');
          $comments = $repository->findByArticle(array('article' => $article), array('creationDate' => 'desc'));
          return $this->render('BloggerBlogCoursIhmBundle:Default:article.html.twig', array('article'=> $article, 'comments' => $comments, 'form'=>$form->createView()));
        }
      }
      return $this->render('BloggerBlogCoursIhmBundle:Default:ajouter.html.twig', array('form'=>$form->createView()));
    }

    public function supprimerAction($id){
      $entityManager=$this->getDoctrine()->getManager();
      $article=$entityManager->getRepository('BloggerBlogCoursIhmBundle:Article')->find($id);
      $entityManager->remove($article);
      $entityManager->flush();
      return $this->indexAction(1);
    }

    public function modifierAction($id){
      $entityManager=$this->getDoctrine()->getManager();
      $article=$entityManager->getRepository('BloggerBlogCoursIhmBundle:Article')->find($id);
      $form = $this->createForm(new ArticleType, $article);
      $request = $this->get('request');
      if($request->getMethod() == 'POST'){
        $form->bind($request);
        if($form->isValid()){
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($article);
          $entityManager->flush();
          $comment = new Comment();
          $comment->setArticle($article);
          $form = $this->createForm(new CommentType, $comment);
          $repository = $entityManager->getRepository('BloggerBlogCoursIhmBundle:Comment');
          $comments = $repository->findByArticle(array('article' => $article), array('creationDate' => 'desc'));
          return $this->render('BloggerBlogCoursIhmBundle:Default:article.html.twig', array('article'=> $article, 'comments' => $comments, 'form'=>$form->createView()));
        }
      }
      return $this->render('BloggerBlogCoursIhmBundle:Default:modifier.html.twig', array('form'=>$form->createView()));
    }
}
