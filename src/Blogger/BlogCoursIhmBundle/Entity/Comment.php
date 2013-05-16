<?php
// src/Blogger/StoreBundle/Entity/Comment.php
namespace Blogger\BlogCoursIhmBundle\Entity;

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
     * @ORM\Column(type="text")
     */
    protected $content;

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
        $this->content='';
        $this->author='';
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

    public function getAuteur(){
        return $this->auteur;
    }

    public function setAuteur($auteur){
        $this->auteur=$auteur;
    }

    public function getContent(){
        return $this->content;
    }

    public function setContent($content){
        $this->content=$content;
    }

    public function getArticle(){
        return $this->article;
    }

    public function setArticle($article){
        $this->article=$article;
    }

    public function getCreationDate(){
        return $this->creationDate;
    }

}

?>
