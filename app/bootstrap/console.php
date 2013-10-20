<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

$app['console'] = function () use ($app) {
    $console = new Application($app['app.name'], $app['app.version']);

    $console
        ->register('my-command')
        ->setDefinition(array(
            // new InputOption('some-option', null, InputOption::VALUE_NONE, 'Some help'),
        ))
        ->setDescription('My command description')
        ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
            // do something
        });

    return $console;
};
