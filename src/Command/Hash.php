<?php

namespace Novomirskoy\ScoopNginxBuilder\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Hash
 * @package Novomirskoy\ScoopNginxBuilder\Command
 */
class Hash extends Command
{
    /**
     * Constructor.
     *
     * @param string|null $name The name of the command; passing null means it must be set in configure()
     *
     * @throws LogicException When the command name is empty
     */
    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('builder:hash')
            ->addArgument(
                'version',
                InputArgument::REQUIRED,
                'Какая версия nginx вас интересует'
            )
            ->addOption(
                'algorithm',
                null,
                InputOption::VALUE_OPTIONAL,
                'Используемуй алгоритм хеширования',
                'sha256'
            )
        ;
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @param InputInterface $input An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int null or 0 if everything went fine, or an error code
     *
     * @throws LogicException When this abstract method is not implemented
     *
     * @see setCode()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hash = hash_file(
            $input->getOption('algorithm'),
            "http://nginx.org/download/nginx-{$input->getArgument('version')}.zip"
        );
        
        $output->writeln(sprintf('Хеш: %s', $hash));
    }
}
