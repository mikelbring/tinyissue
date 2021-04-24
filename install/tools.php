<?php
namespace Acme\FooBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

class BarCommand extends Command {

    protected function configure() {
        $this
            ->setName('foo:bar-cmd')
            ->setDescription('Test command')
            ->addOption('baz', null, InputOption::VALUE_NONE, 'Test option');
        ;
    }

    /**
     * Execute the command
     * The environment option is automatically handled.
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln('Test command');
    }
}