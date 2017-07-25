<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Device;
use AppBundle\Entity\Temperature;
use Doctrine\ORM\EntityRepository;

class TemeratureRepository extends EntityRepository {

    public function saveData($temperatures) {
        foreach ($temperatures as $deviceName => $temperature) {
            $device = $this->getEntityManager()->getRepository(Device::class)->findOneBy(['name' => $deviceName]);
            if (is_null($device)) {
                $device = new Device($deviceName);
                $this->getEntityManager()->persist($device);
            }
            $t = new Temperature($device, $temperature);
            $this->getEntityManager()->persist($t);
            $this->getEntityManager()->flush();
        }
    }
}