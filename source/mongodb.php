<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use MongoDB\Client;

if ( ! file_exists($file = __DIR__.'/vendor/autoload.php')) {
    throw new \Exception("Install deps to use this script...");
}

$loader = require_once $file;
$loader->add('Documents', $_SERVER['DOCUMENT_ROOT']);

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$client = new Client('mongodb://mongodb', [], ['typeMap' => DocumentManager::CLIENT_TYPEMAP]);

$config = new Configuration();
$config->setProxyDir(__DIR__ . '/vendor/Proxies');
$config->setProxyNamespace('Proxies');
$config->setHydratorDir(__DIR__ . '/vendor/Hydrators');
$config->setHydratorNamespace('Hydrators');
$config->setDefaultDB('t4w_db');
$config->setMetadataDriverImpl(AnnotationDriver::create($_SERVER['DOCUMENT_ROOT']. '/Documents'));

$dm = DocumentManager::create($client, $config);