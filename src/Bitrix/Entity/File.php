<?php

namespace App\Bitrix\Entity;

use App\Bitrix\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileRepository::class)]
#[ORM\Table(name: '`b_file`')]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'ID')]
    private ?int $id = null;

    #[ORM\Column(name: 'SUBDIR', length: 255, nullable: true)]
    private ?string $subdir = null;

    #[ORM\Column(name: 'FILE_NAME', length: 255)]
    private ?string $fileName = null;

    #[ORM\Column(name: 'ORIGINAL_NAME', length: 255)]
    private ?string $originalName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubdir(): ?string
    {
        return $this->subdir;
    }

    public function setSubdir(?string $subdir): static
    {
        $this->subdir = $subdir;
        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): static
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): static
    {
        $this->originalName = $originalName;
        return $this;
    }

    public function getPath(): string
    {
        return sprintf('/upload/%s/%s', $this->getSubdir(), $this->getFileName());
    }
}
