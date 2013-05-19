<?php
// src/Blogger/StoreBundle/Entity/Article.php
namespace Blogger\BlogCoursIhmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
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
     * @var string $titre
     * @ORM\Column(type="string", length=300)
     * @Assert\NotBlank()
     */
    protected $titre;
    
    /**
     * @var string $auteur
     * @ORM\Column(type="string", length=100)
     * @Assert\MinLength(2)
     */
    protected $auteur;

    /**
     * @var text $content
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $content;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article", cascade={"remove"})
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
    
    public function __construct()
    {
        $this->titre = '';
        $this->auteur = '';
        $this->content = '';
        //$this->chiffre = $chiffre;
        $this->comments = new ArrayCollection();

        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    /*public function __construct($titre, $author, $content)
    {
        $this->titre = $titre;
        $this->author = $author;
        $this->content = $content;
        //$this->chiffre = $chiffre;
        $this->comments = new ArrayCollection();

        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }*/
    
    //--------------------  Methods  --------------------//

    /**
     * @ORM\PreUpdate
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

    public function getTitre(){
        return $this->titre;
    }

    public function setTitre($titre){
        $this->titre = $titre;
    }

    public function getAuteur(){
        return $this->auteur;
    }

    public function setAuteur($auteur){
        $this->auteur = $auteur;
    }

    public function getCreationDate(){
        return $this->creationDate;
    }

    public function getContent(){
        return $this->content;
    }

    public function setContent($content){
        $this->content = $content;
    }

    public function getId(){
        return $this->id;
    }
}
?>
