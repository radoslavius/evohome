<?php

namespace AppBundle\Command;

use AppBundle\Entity\Temperature;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PullDataCommand extends ContainerAwareCommand {
    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
            ->setName('evohome:pull_data')
            ->setDescription('Pull data from evohome');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $temperatures = $this->getContainer()->get('evohome')->getTemperatures();
        $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Temperature::class)->saveData($temperatures);
    }
}
