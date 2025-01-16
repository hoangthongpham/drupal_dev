<?php

namespace Drupal\Tests\homepage\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;

/**
 * Simple test to ensure that asserts pass.
 *
 * @group phpunit_common
 */
class CommonUnitTest extends UnitTestCase {

  /**
   * Test addition of two numbers.
   */
  public function testAddition() {
    $a = 2;
    $b = 3;
    $sum = $a + $b;
    $this->assertEquals(5, $sum, 'The addition result should be 5.');
  }

   /**
   * Test getting configuration value.
   */
  public function testGetConfigValue() {
    // Mocking ConfigFactoryInterface.
    $configFactory = $this->createMock(ConfigFactoryInterface::class);
    $config = $this->createMock(ImmutableConfig::class);
    $config->expects($this->once())
      ->method('get')
      ->with('example.setting')
      ->willReturn('expected_value');

    $configFactory->expects($this->once())
      ->method('get')
      ->with('custom_module.settings')
      ->willReturn($config);

    $result = $config->get('example.setting');
    $this->assertEquals('expected_value', $result);
  }
}