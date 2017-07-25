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
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TemeratureRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Temperature {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Device
     * @ORM\ManyToOne(targetEntity="Device", inversedBy="temperatures")
     */
    private $device;

    /**
     * @var float
     * @ORM\Column(name="temperature", type="float", nullable=false)
     */
    private $temperature;

    /**
     * @var \DateTime
     * @ORM\Column(name="inserted", type="datetime", nullable=true)
     */
    private $inserted;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersistPreUpdate() {
        if ($this->inserted === NULL) {
            $this->inserted = new \DateTime();
        }
    }

    /**
     * Temperature constructor.
     *
     * @param Device $device
     * @param float $temperature
     */
    public function __construct(Device $device = NULL, $temperature = NULL) {
        if (isset($device)) {
            $this->device = $device;
        }
        if (isset($temperature)) {
            $this->temperature = $temperature;
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
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return Device
     */
    public function getDevice() {
        return $this->device;
    }

    /**
     * @param Device $device
     */
    public function setDevice($device) {
        $this->device = $device;
    }

    /**
     * @return float
     */
    public function getTemperature() {
        return $this->temperature;
    }

    /**
     * @param float $temperature
     */
    public function setTemperature($temperature) {
        $this->temperature = $temperature;
    }

    /**
     * @return \DateTime
     */
    public function getInserted() {
        return $this->inserted;
    }

    /**
     * @param \DateTime $inserted
     *
     * @return Temperature
     */
    public function setInserted($inserted) {
        $this->inserted = $inserted;
        return $this;
    }

}