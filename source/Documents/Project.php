<?php

namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Project
{
    /** @ODM\Id */
    private $id;

    /** @ODM\Field(type="string") */
    private $name;

    public function __construct($name) { $this->name = $name; }

    public function getId(): ?string { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }
}