<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Item {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $ItemId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $Name;

    /**
     * @ORM\Column(type="integer")
     */
    public $Anzahl;
}
