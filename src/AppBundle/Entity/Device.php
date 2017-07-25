<?php
/**
 * Created by PhpStorm.
 * User: radek
 * Date: 25.7.17
 * Time: 9:22
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Device {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var \AppBundle\Entity\Temperature[]|\Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Temperature", mappedBy="device")
     */
    private $temperatures;

    /**
     * Device constructor.
     *
     * @param string $name
     */
    public function __construct($name = NULL) {
        if (isset($name)) {
            $this->name = $name;
        }
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Device
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Device
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

}