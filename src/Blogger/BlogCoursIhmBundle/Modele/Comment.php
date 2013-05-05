<?php
// src/Blogger/StoreBundle/Entity/Comment.php
namespace Blogger\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class Comment
{
    //---------------  Fields declaration  ---------------//
  
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $auteur;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $approved;

    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="comments")
     * @ORM\JoinColumn(name="blog_id", referencedColumnName="id")
     */
    protected $article;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $creationDate;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $lastModified;
    
    //------------------  Constructors  ------------------//
    
    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());

        $this->setApproved(true);
    }
    
    //--------------------  Methods  --------------------//

    /**
     * @ORM\preUpdate
     */
    public function setUpdatedValue()
    {
       $this->setUpdated(new \DateTime());
    }

    public function setUpdated($lastModified){
        $this->lastModified = $lastModified;
    }

    public function setApproved($approved){
        $this->approved = $approved;
    }

    public function setCreated($creationDate){
        $this->creationDate = $creationDate;
    }
}









// src/Acme/StoreBundle/Controller/DefaultController.php

// ...
use Acme\StoreBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

public function createAction()
{
    $product = new Product();
    $product->setName('A Foo Bar');
    $product->setPrice('19.99');
    $product->setDescription('Lorem ipsum dolor');

    $em = $this->getDoctrine()->getManager();
    $em->persist($product);
    $em->flush();

    return new Response('Created product id '.$product->getId());
}

?>
