<?php

declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;
use App\Exceptions\Container\NotFoundException;

class Container implements ContainerInterface
{
  private array $entries = [];

  public function get(string $id)
  {
    if (!$this->has($id)) {
      throw new NotFoundException('Class ' . $id . 'has no binding.');
    }

    $entry = $this->entries[$id];

    return $entry($this);
  }

  public function has($id): bool
  {
    return isset($this->entries[$id]);
  }

  public function set(string $id, callable $concrete): void
  {
    $this->entries[$id] = $concrete;
  }

}