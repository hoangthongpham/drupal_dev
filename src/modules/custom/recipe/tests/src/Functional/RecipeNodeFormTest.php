<?php

namespace Drupal\Tests\recipe\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests the functionality of the Recipe content type.
 *
 * @group recipe
 */
class RecipeNodeFormTest extends BrowserTestBase
{
    /**
     * Theme to enable.
     *
     * @var string
     */
    protected $defaultTheme = 'stark';

    /**
     * Modules to enable.
     *
     * @var array
     */
    protected static $modules = ['node', 'rules'];

    /**
     * A user with permissions to create and view Recipe content.
     *
     * @var \Drupal\user\Entity\User
     */
    protected $recipeUser;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create an article content type that we will use for testing.
        $type = $this->container->get('entity_type.manager')->getStorage('node_type')
        ->create([
            'type' => 'article',
            'name' => 'Article',
        ]);
        $type->save();
        $this->container->get('router.builder')->rebuild();
    }

    /**
     * Tests that the reaction rule listing page works.
     */
    public function testReactionRulePage()
    {
        $account = $this->drupalCreateUser(['administer rules']);
        $this->drupalLogin($account);

        $this->drupalGet('admin/config/workflow/rules');
        $this->assertSession()->statusCodeEquals(200);

        // Test that there is an empty reaction rule listing.
        $this->assertSession()->pageTextContains('There is no Reaction Rule yet.');
    }
}
