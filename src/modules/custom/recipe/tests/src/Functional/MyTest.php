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
     * A user account with the 'administrator' role.
     *
     * @var \Drupal\user\UserInterface
     */
    protected $adminUser;

    /**
     * {@inheritdoc}
     */
    public function setUp() :void
    {
        parent::setUp();

        // Create an admin user.
        $this->adminUser = $this->drupalCreateUser([
            'administer site configuration',
            'access content',
        ]);

        // Log in as the admin user.
        $this->drupalLogin($this->adminUser);
    }

    /**
     * Test to check if a page exists and contains expected content.
     */
    public function testPageContent()
    {
        // Visit a page.
        $this->drupalGet('admin/config'); // Replace with the path of the page to test.

        // Assert that the page is returned successfully (status code 200).
        $this->assertSession()->statusCodeEquals(403);

        // Check if specific text is present on the page.
        // $this->assertSession()->pageTextContains('Configuration'); // Replace with the text you expect.
    }
}
