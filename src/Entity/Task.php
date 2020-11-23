<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    const STATUS_NEW = "NEW";

    const STATUS_PROCESSING = "PROCESSING";

    const STATUS_DONE = "DONE";

    const STATUS_ERROR = "ERROR";

    const AVAILABLE_STATUSES =  [
        self::STATUS_NEW,
        self::STATUS_PROCESSING,
        self::STATUS_DONE,
        self::STATUS_ERROR
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $http_code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if(!in_array($status, self::AVAILABLE_STATUSES)){
            throw new \InvalidArgumentException("Status not valid please use one of: "
                . implode(" ,", self::AVAILABLE_STATUSES));
        }
        $this->status = $status;

        return $this;
    }

    public function setHttpCode(int $http_code): void
    {
        $this->http_code = $http_code;
    }
}
