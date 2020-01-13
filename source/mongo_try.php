<?php

use Documents\Project;

require_once $_SERVER['DOCUMENT_ROOT']."/mongodb.php";

$project = new Project('First project');
$dm->persist($project);
$project = new Project('Second  project');
$dm->persist($project);
$dm->flush();

$projects = $dm->getRepository(Project::class)->findAll();

echo "<pre>";
print_r($projects);
echo "</pre>";