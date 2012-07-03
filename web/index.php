<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->get('/', function () use ($app) {
    // im setting up my birtday date
    $birthDate  = new \DateTime('1985/10/26');
    $now        = new \DateTime('now');
    $daysOld    = $birthDate->diff($now)->format("%y years, %m months and %d days");
    return $app['twig']->render('index.twig', array('birthDate' => $daysOld));
});
$app['debug'] = true;
$app->run();