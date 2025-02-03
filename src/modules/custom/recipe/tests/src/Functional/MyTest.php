<?php

namespace Drupal\Tests\recipe\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test case to verify the functionality of your custom module.
 *
 * @group your_module
 */
class MyTest extends BrowserTestBase
{

    /**
     * {@inheritdoc}
     */
    protected $profile = 'standard';

    /**
     * Tài khoản người dùng test.
     *
     * @var \Drupal\user\Entity\User
     */
    protected $user;

    /**
     * {@inheritdoc}
     */

    /**
     * Thiết lập test.
     */
    protected function setUp(): void {
        parent::setUp();

        // Tạo tài khoản user có quyền truy cập.
        $this->user = $this->drupalCreateUser(['access content']);
    }

    /**
     * Kiểm tra xem trang chính có tải đúng không.
     */
    public function testHomePageLoads() {
        // Đăng nhập với tài khoản test.
        $this->drupalLogin($this->user);

        // Truy cập trang chủ.
        $this->drupalGet('<front>');
        $this->assertSession()->statusCodeEquals(200);
    }
}
