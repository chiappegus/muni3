<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PedidoRepository")
 */
class Pedido
{

    use TimestampableEntity;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Buffy", inversedBy="pedidos")
     */
    private $menu;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="integer" ,nullable=true)
     */
    private $PrecioPedido;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $restaurant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Persona", inversedBy="pedidos")
     */
    private $Persona;

    public function getId():  ? int
    {
        return $this->id;
    }

    public function getMenu() :  ? Buffy
    {
        return $this->menu;
    }

    public function setMenu( ? Buffy $menu) : self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getCantidad() :  ? int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad) : self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getPrecioPedido():  ? int
    {
        return $this->PrecioPedido;
    }

    public function setPrecioPedido(int $PrecioPedido) : self
    {
        $this->PrecioPedido = $PrecioPedido;

        return $this;
    }

    public function getRestaurant():  ? string
    {
        return $this->restaurant;
    }

    public function setRestaurant( ? string $restaurant) : self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Sets createdAt.
     *
     * @param  \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        // throw new \Exception('Method setCreatedAt() is not implemented.');

        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        if (!$this->createdAt) {

            $this->createdAt = new \DateTime;

            return $this->createdAt;
        };

        return $this->createdAt;
        // throw new \Exception('Method getCreatedAt() is not implemented.');
    }

    /**
     * Sets updatedAt.
     *
     * @param  \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {

        // throw new \Exception('Method setUpdatedAt() is not implemented.');
        $this->updatedAt = new \DateTime;

        // $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        if (!$this->updatedAt) {

            $this->updatedAt = new \DateTime;

            return $this->updatedAt;
        };
        return $this->updatedAt;
        // return $updatedAt;
        //dd($this->updatedAt, $this->createdAt);
        // throw new \Exception('Method getUpdatedAt() is not implemented.');
    }

    public function getPersona(): ?Persona
    {
        return $this->Persona;
    }

    public function setPersona(?Persona $Persona): self
    {
        $this->Persona = $Persona;

        return $this;
    }
}
