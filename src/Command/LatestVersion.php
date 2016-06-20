<?php

namespace Novomirskoy\ScoopNginxBuilder\Command;

use GuzzleHttp\Client;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class LatestVersion
 * @package Novomirskoy\ScoopNginxBuilder\Command
 */
class LatestVersion extends Command
{
    /**
     * @var RequestInterface
     */
    protected $request;
    
    /**
     * Constructor.
     *
     * @param string|null $name The name of the command; passing null means it must be set in configure()
     *
     * @throws LogicException When the command name is empty
     */
    public function __construct(RequestInterface $request, $name = null)
    {
        $this->request = $request;
        
        parent::__construct($name);
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('builder:latest-version');
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
        $versions = [];

        $client = new Client();
        
        try {
            $response = $client->send($this->request);

            $html = (string)$response->getBody();

            $crawler = new Crawler($html);

            $crawler
                ->filter('a')
                ->each(function (Crawler $node, $i) use ($output, &$versions) {
                    $href = $node->attr('href');

                    if (preg_match('/^nginx-[0-9]+\.[0-9]+\.[0-9]+\.zip$/i', $href)) {

                        preg_match('/([\d]+.[\d]+.[\d]+)/', $href, $matches);
                        $version = $matches[0];
                        
                        $versions[$version] = $href;
                    }

                });
        } catch (\Exception $e) {
            $output->writeln('<error>Произошла ошибка</error>');
            $output->writeln($e->getMessage());
        }

        uksort($versions, function ($v1, $v2) {
            return version_compare($v1, $v2);
        });
        
        end($versions);
        
        $output->writeln(sprintf('Последняя версия: %s', key($versions)));
    }
}
