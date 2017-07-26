<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Device;
use AppBundle\Entity\Temperature;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {
    /**
     * @Route("/", name="homepage")
     * @Template(":default:index.html.twig")
     */
    public function indexAction(Request $request) {
        $qb = $this->getDoctrine()->getRepository(Device::class)->createQueryBuilder('d', 'd.id');
        $devices = $qb
            ->getQuery()
            ->getResult();

        $qb = $this->getDoctrine()->getRepository(Temperature::class)->createQueryBuilder('t');
        $temperatures = $qb
            ->orderBy('t.device', 'ASC')
            ->addOrderBy('t.inserted', 'ASC')
            ->where('t.inserted > :datetime')
            ->setParameter('datetime', new \DateTime('-1 days'), \Doctrine\DBAL\Types\Type::DATETIME)
            ->getQuery()
            ->getResult();


        $data = [];
        /** @var Temperature $temperature */
        foreach ($temperatures as $temperature) {
            $data[$temperature->getDevice()->getId()][$temperature->getInserted()->format('H:i')] = $temperature->getTemperature();
        }

        return [
            'data' => $data,
            'devices' => $devices,
        ];
    }
}
