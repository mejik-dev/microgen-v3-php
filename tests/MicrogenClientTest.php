<?php

namespace Microgen\Tests;

use Microgen\MicrogenClient;
use PHPUnit\Framework\TestCase;

final class MicrogenClientTest extends TestCase
{
  public function testCreateClientError(): void
  {
    $this->expectException(\Exception::class);

    $microgen = new MicrogenClient([]);
    $this->assertNull($microgen);
  }

  public function testCreateClientSuccess(): void
  {
    $microgen = new MicrogenClient([
      'apiKey' => Config::API_KEY
    ]);

    $this->assertNotNull($microgen);
    $this->assertInstanceOf(MicrogenClient::class, $microgen);
  }
}
