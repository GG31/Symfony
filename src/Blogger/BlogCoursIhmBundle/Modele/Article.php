<?php
// src/Blogger/StoreBundle/Entity/Article.php
namespace Blogger\BlogCoursIhmBundle\Modele;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Blogger\BlogCoursIhmBundle\Modele\ArticleRepository")
 * @ORM\Table(name="article")
 */
class Article
{
    //---------------  Fields declaration  ---------------//
  
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=300)
     */
    protected $title;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $author;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\OneToMany(targetEntity="Comments", mappedBy="article")
     */
    protected $comments;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $creationDate;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $lastModified;
    
    //------------------  Constructors  ------------------//
    
    public function __construct($title, $author, $content)
    {
        $this->title = $title;
        $this->author = $author;
        $this->content = $content;
        //$this->chiffre = $chiffre;
        $this->comments = new ArrayCollection();

        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }
    
    //--------------------  Methods  --------------------//

    /**
     * @ORM\preUpdate
     */
    public function setUpdatedValue()
    {
       $this->setUpdated(new \DateTime());
    }

    public function setCreated($creationDate){
        $this->creationDate = $creationDate;
    }

    public function setUpdated($date){
        $this->lastModified=$date;
    }

    public function isSpam(){
        if($this->chiffre==0){
            return true;
        }
        return false;
    }
}
?>
