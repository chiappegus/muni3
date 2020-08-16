<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="buffy")
 * @ORM\Entity(repositoryClass="App\Repository\BuffyRepository")
 */
class Buffy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stock;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $precio;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pedido", inversedBy="menu")
     */
    private $pedidos;

    public function getId():  ? int
    {
        return $this->id;
    }

    public function getName() :  ? string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getStock():  ? int
    {
        return $this->stock;
    }

    public function setStock( ? int $stock) : self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPrecio() :  ? float
    {
        return $this->precio;
    }

    public function setPrecio( ? float $precio) : self
    {
        $this->precio = $precio;

        return $this;
    }

    public function __toString()
    {

        return $this->name;

    }

    public function getPedidos(): ?Pedido
    {
        return $this->pedidos;
    }

    public function setPedidos(?Pedido $pedidos): self
    {
        $this->pedidos = $pedidos;

        return $this;
    }

}
