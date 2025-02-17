<?php

namespace app\modules\orders\DTO;

final readonly class Orders
{
    public int $id;
    public string $username;
    public string $link;
    public int $quantity;
    public string $serviceCount;
    public string $serviceName;
    public string $status;
    public string $createdAt;
    public string $mode;

    public function __construct(
        $id,
        $username,
        $link,
        $quantity,
        $serviceCount,
        $serviceName,
        $status,
        $mode,
        $createdAt
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->link = $link;
        $this->quantity = $quantity;
        $this->serviceCount = $serviceCount;
        $this->serviceName = $serviceName;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->mode = $mode;
    }
}