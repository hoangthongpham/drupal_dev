<?php

namespace Drupal\Tests\homepage\Unit;

use Drupal\homepage\Controller\HomepageController;
use Drupal\Tests\UnitTestCase;

/**
 * Simple test to ensure that asserts pass.
 *
 * @group phpunit_home
 */
class HomepageUnitTest extends UnitTestCase {

  protected $unit;

  /**
   * Before a test method is run, setUp() is invoked.
   * Create new unit object.
   */
  public function setUp() :void {
    $this->unit = new HomepageController;
  }

  /**
   * @covers Drupal\phpunit_example\Unit::setLength
   */
  public function testSetLength() {

    $this->assertEquals(1, $this->unit->getLength());
    $this->unit->setLength(9);
    $this->assertEquals(9, $this->unit->getLength());
  }

  /**
   * @covers Drupal\phpunit_example\Unit::getLength
   */
  public function testGetLength() {

    $this->unit->setLength(9);
    $this->assertNotEquals(10, $this->unit->getLength());
  }

  /**
   * Once test method has finished running, whether it succeeded or failed, tearDown() will be invoked.
   * Unset the $unit object.
   */
  public function tearDown() :void{
    unset($this->unit);
  }

}