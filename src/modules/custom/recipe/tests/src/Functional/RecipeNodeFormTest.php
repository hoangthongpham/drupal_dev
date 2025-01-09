<?php

namespace Drupal\Tests\recipe\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test case for adding a node of type "recipe".
 *
 * @group recipe
 */
class RecipeNodeFormTest extends BrowserTestBase {


  /**
   * Theme to enable.
   *
   * @var string
   */
  protected $defaultTheme = 'bootstrap_barrio_subtheme';
  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = ['node', 'recipe'];

  /**
   * A user with permission to create and manage recipe nodes.
   *
   * @var \Drupal\user\Entity\User
   */
  protected $recipeUser;

  /**
   * Set up the environment for the test.
   */
  protected function setUp(): void {
    parent::setUp();

    // Create a user with permissions to create and edit recipe nodes.
    $this->recipeUser = $this->drupalCreateUser([
      'create recipe content',
      'edit own recipe content',
      'access content',
    ]);
  }

  /**
   * Tests the recipe add form.
   */
  public function testRecipeNodeAddForm() {
    // Log in as the user with recipe permissions.
    $this->drupalLogin($this->recipeUser);

    // Visit the add recipe form.
    $this->drupalGet('node/add/recipe');

    // Assert that the page contains the expected form elements.
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->fieldExists('title[0][value]');
    $this->assertSession()->fieldExists('body[0][value]');
    
    // Submit the form with test data.
    $edit = [
      'title[0][value]' => 'Test Recipe',
      'body[0][value]' => 'This is a test recipe body content.',
    ];
    $this->submitForm($edit, ('Save'));

    // Assert that the node was created.
    $this->assertSession()->pageTextContains('Test Recipe has been created.');
  }

}
