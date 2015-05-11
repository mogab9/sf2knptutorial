<?php
// From app_dev.php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$loader = require_once __DIR__.'/app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/app/AppKernel.php';

$kernel   = new AppKernel('dev', true);
$kernel->loadClassCache();
$request  = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

// Not from app_dev.php
// add custom request

// container setup
$container = $kernel->getContainer();
$container->enterScope('request');
$container->set('request', $request);

// request
/*
$templating = $container->get('templating');

echo $templating->render(
    'EventBundle:Default:index.html.twig',
    array('name'=>'Vader', 'count'=>3)
);
*/

/*
use Yoda\EventBundle\Entity\Event;

$event = new Event();
$event->setName('Darth\'s surprise birthday party! Yeah!');
$event->setLocation('Deathstar');
$event->setTime(new \DateTime('04-05-2016 12:30:00'));
$event->setDetails('Every Jedy can come!');

$em = $container->get('doctrine')->getManager();
$em->persist($event);
$em->flush();
*/


