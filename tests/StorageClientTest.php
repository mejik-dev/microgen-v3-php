<?php

namespace Microgen\Tests;

use Microgen\MicrogenClient;
use PHPUnit\Framework\TestCase;

final class StorageClientTest extends TestCase
{
  public static MicrogenClient $microgen;

  /**
   * @beforeClass
   */
  public static function setUpClient(): void
  {
    self::$microgen = new MicrogenClient([
      'apiKey' => Config::API_KEY
    ]);

    self::$microgen->auth->login([
      'email' => Config::EMAIL,
      'password' => Config::PASSWORD
    ]);
  }

  public function testUpload()
  {
    $file = fopen(__DIR__ . '/icon.png', 'r');
    $res = self::$microgen->storage->upload($file);

    $this->assertEquals(200, $res['status']);
  }
}
