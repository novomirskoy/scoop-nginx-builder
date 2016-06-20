<?php

namespace Novomirskoy\ScoopNginxBuilder\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\LogicException;

/**
 * Class Generate
 * @package Novomirskoy\ScoopNginxBuilder\Command
 */
class Generate extends Command
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('builder:generate')
            ->addArgument(
                'version',
                InputArgument::REQUIRED,
                'Версия nginx'
            )
            ->addArgument(
                'hash',
                InputArgument::REQUIRED,
                'Хеш файла'
            );
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
        $version = $input->getArgument('version');
        $hash = $input->getArgument('hash');

        $data = [
            'homepage' => 'http://nginx.org',
            'version' => $version,
            'license' => 'BSD',
            'url' => "http://nginx.org/download/nginx-{$version}.zip",
            'hash' => $hash,
            'extract_dir' => "nginx-{$version}",
            'bin' => 'nginx.exe',
        ];

        file_put_contents(__DIR__ . "/../../build/nginx-{$version}.json", json_encode($data, JSON_PRETTY_PRINT));
    }
}
