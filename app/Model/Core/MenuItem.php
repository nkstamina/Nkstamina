<?php
namespace Nkstamina\Model\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="coreMenuItem")
 */
class MenuItem
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Nkstamina\Model\Core\Menu", cascade={"persist"})
     */
    protected $menu;
    
    /**
     * @ORM\Column(name="link", type="string", length=255)
     */
    protected $link;
    
    /**
     * @ORM\Column(name="text", type="string", length=255)
     */    
    protected $text;

    /**
     * @ORM\Column(name="order", type="integer")
     */
    protected $order;
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setLink($link) {
        $this->link = $link;
    }
    
    public function getLink() {
        return $this->link;
    }
    
    public function setText($text) {
        $this->text = $text
    }
    
    public function getText() {
        return $this->text;
    }
}