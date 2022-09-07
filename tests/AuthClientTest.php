<?php

namespace Microgen\Tests;

use Microgen\MicrogenClient;
use PHPUnit\Framework\TestCase;

final class AuthClientTest extends TestCase
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
  }

  public function testLoginError(): void
  {
    $res = self::$microgen->auth->login([
      'email' => Config::EMAIL,
      'password' => Config::PASSWORD . '1'
    ]);

    $token = self::$microgen->auth->token();

    $this->assertEquals(401, $res['status']);
    $this->assertEmpty($token);
  }

  public function testLoginSuccess(): void
  {
    $res = self::$microgen->auth->login([
      'email' => Config::EMAIL,
      'password' => Config::PASSWORD
    ]);

    $token = self::$microgen->auth->token();

    $this->assertEquals(200, $res['status']);
    $this->assertEquals(Config::EMAIL, $res['user']['email']);
    $this->assertEquals($token, $res['token']);
  }

  public function testToken(): void
  {
    $token = self::$microgen->auth->token();

    $this->assertNotNull($token);
  }

  public function testGetProfile(): void
  {
    $res = self::$microgen->auth->user();

    $this->assertEquals(200, $res['status']);
    $this->assertEquals(Config::EMAIL, $res['user']['email']);
  }

  public function testUpdateProfile(): void
  {
    $res = self::$microgen->auth->update([
      'lastName' => 'Tester'
    ]);

    $this->assertEquals(200, $res['status']);
    $this->assertEquals(Config::EMAIL, $res['user']['email']);
    $this->assertEquals('Tester', $res['user']['lastName']);
  }

  public function testLogout(): void
  {
    $token = self::$microgen->auth->token();
    $res = self::$microgen->auth->logout();

    $this->assertEquals(200, $res['status']);
    $this->assertEquals($token, $res['token']);
  }
}
