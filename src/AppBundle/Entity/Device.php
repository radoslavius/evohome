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
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DeviceRepository")
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

    public function getColor() {
        return $this->genColorCodeFromText($this->name);
    }

    /*
     * Outputs a color (#000000) based Text input
     *
     * @param $text String of text
     * @param $min_brightness Integer between 0 and 100
     * @param $spec Integer between 2-10, determines how unique each color will be
     */
    private function genColorCodeFromText($text) {

        $min_brightness = 50;
        $spec = 7;

        $hash = md5($text);  //Gen hash of text
        $colors = array();
        for ($i = 0; $i < 3; $i++) {
            $colors[$i] = max(array(round(((hexdec(substr($hash, $spec * $i, $spec))) / hexdec(str_pad('', $spec, 'F'))) * 255), $min_brightness));
        } //convert hash into 3 decimal values between 0 and 255

        if ($min_brightness > 0)  //only check brightness requirements if min_brightness is about 100
        {
            while (array_sum($colors) / 3 < $min_brightness)  //loop until brightness is above or equal to min_brightness
            {
                for ($i = 0; $i < 3; $i++) {
                    $colors[$i] += 10;
                }
            }
        }    //increase each color by 10

        $output = '';

        for ($i = 0; $i < 3; $i++) {
            $output .= str_pad(dechex($colors[$i]), 2, 0, STR_PAD_LEFT);
        }  //convert each color to hex and append to output

        return '#' . $output;
    }
}