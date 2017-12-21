<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;

/**
 * Useless
 *
 * @ORM\Table(name="useless")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UselessRepository")
 */
class Useless
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="meh", type="string", length=255, nullable=true)
     */
    private $meh;

    /**
     * @var string
     *
     * @ORM\Column(name="whatever", type="string", length=255, nullable=true)
     */
    private $whatever;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set meh
     *
     * @param string $meh
     *
     * @return Useless
     */
    public function setMeh($meh)
    {
        $this->meh = $meh;

        return $this;
    }

    /**
     * Get meh
     *
     * @return string
     */
    public function getMeh()
    {
        return $this->meh;
    }

    /**
     * Set whatever
     *
     * @param string $whatever
     *
     * @return Useless
     */
    public function setWhatever($whatever)
    {
        $this->whatever = $whatever;

        return $this;
    }

    /**
     * Get whatever
     *
     * @return string
     */
    public function getWhatever()
    {
        return $this->whatever;
    }
}

