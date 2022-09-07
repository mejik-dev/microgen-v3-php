<?php

namespace Microgen\Tests;

use Microgen\MicrogenClient;
use PHPUnit\Framework\TestCase;

final class QueryClientTest extends TestCase
{
  public static MicrogenClient $microgen;
  public static string $id;

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

  public function testCreateError()
  {
    $res = self::$microgen->service(Config::SERVICE_NAME)->create([]);

    $this->assertNotEquals(201, $res['status']);
  }

  public function testCreate()
  {
    $res = self::$microgen->service(Config::SERVICE_NAME)->create([
      'name' => 'first'
    ]);

    self::$id = $res['data']['_id'];

    $this->assertEquals(201, $res['status']);
    $this->assertArrayHasKey('_id', $res['data']);
  }

  public function testFind()
  {
    $res = self::$microgen->service(Config::SERVICE_NAME)->find();

    $this->assertEquals(200, $res['status']);
    $this->assertIsArray($res['data']);
  }

  public function testFindError()
  {
    $res = self::$microgen->service(Config::SERVICE_NAME . '1')->find();

    $this->assertEquals(404, $res['status']);
    $this->assertArrayHasKey('error', $res);
    $this->assertArrayHasKey('message', $res['error']);
  }

  public function testGetById()
  {
    $res = self::$microgen->service(Config::SERVICE_NAME)->getById(self::$id);

    $this->assertEquals(200, $res['status']);
    $this->assertEquals(self::$id, $res['data']['_id']);
  }

  public function testUpdateById()
  {
    $res = self::$microgen->service(Config::SERVICE_NAME)->updateById(self::$id, [
      'name' => 'edited'
    ]);

    $this->assertEquals(200, $res['status']);
    $this->assertEquals(self::$id, $res['data']['_id']);
    $this->assertEquals('edited', $res['data']['name']);
  }

  public function testDeleteById()
  {
    $res = self::$microgen->service(Config::SERVICE_NAME)->deleteById(self::$id);

    $this->assertEquals(200, $res['status']);
    $this->assertEquals(self::$id, $res['data']['_id']);
  }

  public function testCount()
  {
    $res = self::$microgen->service(Config::SERVICE_NAME)->count();

    $this->assertEquals(200, $res['status']);
  }
}
