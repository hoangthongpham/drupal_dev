<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/contrib/bootstrap_barrio/templates/layout/page.html.twig */
class __TwigTemplate_35d99cda9d0fd04b965c567d1f272b27 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'head' => [$this, 'block_head'],
            'featured' => [$this, 'block_featured'],
            'content' => [$this, 'block_content'],
            'footer' => [$this, 'block_footer'],
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 71
        $context["sidebar_first_exists"] =  !twig_test_empty(twig_trim_filter(twig_striptags($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 71), 71, $this->source)), "<img><video><audio><drupal-render-placeholder>")));
        // line 72
        $context["sidebar_second_exists"] =  !twig_test_empty(twig_trim_filter(twig_striptags($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 72), 72, $this->source)), "<img><video><audio><drupal-render-placeholder>")));
        // line 73
        echo "
<div id=\"page-wrapper\">
  <div id=\"page\">
    <header id=\"header\" class=\"header\" role=\"banner\" aria-label=\"";
        // line 76
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Site header"));
        echo "\">
      ";
        // line 77
        $this->displayBlock('head', $context, $blocks);
        // line 130
        echo "    </header>
    ";
        // line 131
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 131)) {
            // line 132
            echo "      <div class=\"highlighted\">
        <aside class=\"";
            // line 133
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null), 133, $this->source), "html", null, true);
            echo " section clearfix\" role=\"complementary\">
          ";
            // line 134
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 134), 134, $this->source), "html", null, true);
            echo "
        </aside>
      </div>
    ";
        }
        // line 138
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "featured_top", [], "any", false, false, true, 138)) {
            // line 139
            echo "      ";
            $this->displayBlock('featured', $context, $blocks);
            // line 146
            echo "    ";
        }
        // line 147
        echo "    <div id=\"main-wrapper\" class=\"layout-main-wrapper clearfix\">
      ";
        // line 148
        $this->displayBlock('content', $context, $blocks);
        // line 175
        echo "    </div>
    ";
        // line 176
        if (((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "featured_bottom_first", [], "any", false, false, true, 176) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "featured_bottom_second", [], "any", false, false, true, 176)) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "featured_bottom_third", [], "any", false, false, true, 176))) {
            // line 177
            echo "      <div class=\"featured-bottom\">
        <aside class=\"";
            // line 178
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null), 178, $this->source), "html", null, true);
            echo " clearfix\" role=\"complementary\">
          ";
            // line 179
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "featured_bottom_first", [], "any", false, false, true, 179), 179, $this->source), "html", null, true);
            echo "
          ";
            // line 180
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "featured_bottom_second", [], "any", false, false, true, 180), 180, $this->source), "html", null, true);
            echo "
          ";
            // line 181
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "featured_bottom_third", [], "any", false, false, true, 181), 181, $this->source), "html", null, true);
            echo "
        </aside>
      </div>
    ";
        }
        // line 185
        echo "    <footer class=\"site-footer\">
      ";
        // line 186
        $this->displayBlock('footer', $context, $blocks);
        // line 203
        echo "    </footer>
  </div>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page", "container", "navbar_top_attributes", "container_navbar", "navbar_attributes", "navbar_collapse_btn_data", "navbar_collapse_class", "navbar_offcanvas", "sidebar_collapse", "content_attributes", "sidebar_first_attributes", "sidebar_second_attributes"]);    }

    // line 77
    public function block_head($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 78
        echo "        ";
        if (((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "secondary_menu", [], "any", false, false, true, 78) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "top_header", [], "any", false, false, true, 78)) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "top_header_form", [], "any", false, false, true, 78))) {
            // line 79
            echo "          <nav";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["navbar_top_attributes"] ?? null), 79, $this->source), "html", null, true);
            echo ">
          ";
            // line 80
            if (($context["container_navbar"] ?? null)) {
                // line 81
                echo "          <div class=\"container\">
          ";
            }
            // line 83
            echo "              ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "secondary_menu", [], "any", false, false, true, 83), 83, $this->source), "html", null, true);
            echo "
              ";
            // line 84
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "top_header", [], "any", false, false, true, 84), 84, $this->source), "html", null, true);
            echo "
              ";
            // line 85
            if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "top_header_form", [], "any", false, false, true, 85)) {
                // line 86
                echo "                <div class=\"form-inline navbar-form ms-auto\">
                  ";
                // line 87
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "top_header_form", [], "any", false, false, true, 87), 87, $this->source), "html", null, true);
                echo "
                </div>
              ";
            }
            // line 90
            echo "          ";
            if (($context["container_navbar"] ?? null)) {
                // line 91
                echo "          </div>
          ";
            }
            // line 93
            echo "          </nav>
        ";
        }
        // line 95
        echo "        ";
        if (((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 95) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 95)) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header_form", [], "any", false, false, true, 95))) {
            // line 96
            echo "          <nav";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["navbar_attributes"] ?? null), 96, $this->source), "html", null, true);
            echo ">
            ";
            // line 97
            if (($context["container_navbar"] ?? null)) {
                // line 98
                echo "            <div class=\"container\">
            ";
            }
            // line 100
            echo "              ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 100), 100, $this->source), "html", null, true);
            echo "
              ";
            // line 101
            if ((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 101) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header_form", [], "any", false, false, true, 101))) {
                // line 102
                echo "                <button class=\"navbar-toggler collapsed\" type=\"button\" data-bs-toggle=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["navbar_collapse_btn_data"] ?? null), 102, $this->source), "html", null, true);
                echo "\" data-bs-target=\"#CollapsingNavbar\" aria-controls=\"CollapsingNavbar\" aria-expanded=\"false\" aria-label=\"Toggle navigation\"><span class=\"navbar-toggler-icon\"></span></button>
                <div class=\"";
                // line 103
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["navbar_collapse_class"] ?? null), 103, $this->source), "html", null, true);
                echo "\" id=\"CollapsingNavbar\">
                  ";
                // line 104
                if (($context["navbar_offcanvas"] ?? null)) {
                    // line 105
                    echo "                    <div class=\"offcanvas-header\">
                      <button type=\"button\" class=\"btn-close text-reset\" data-bs-dismiss=\"offcanvas\" aria-label=\"Close\"></button>
                    </div>
                    <div class=\"offcanvas-body\">
                  ";
                }
                // line 110
                echo "                  ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 110), 110, $this->source), "html", null, true);
                echo "
                  ";
                // line 111
                if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header_form", [], "any", false, false, true, 111)) {
                    // line 112
                    echo "                    <div class=\"form-inline navbar-form justify-content-end\">
                      ";
                    // line 113
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header_form", [], "any", false, false, true, 113), 113, $this->source), "html", null, true);
                    echo "
                    </div>
                  ";
                }
                // line 116
                echo "                  ";
                if (($context["navbar_offcanvas"] ?? null)) {
                    // line 117
                    echo "                    </div>
                  ";
                }
                // line 119
                echo "                </div>
              ";
            }
            // line 121
            echo "              ";
            if (($context["sidebar_collapse"] ?? null)) {
                // line 122
                echo "                <button class=\"navbar-toggler navbar-toggler-left collapsed\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#CollapsingLeft\" aria-controls=\"CollapsingLeft\" aria-expanded=\"false\" aria-label=\"Toggle navigation\"></button>
              ";
            }
            // line 124
            echo "            ";
            if (($context["container_navbar"] ?? null)) {
                // line 125
                echo "            </div>
            ";
            }
            // line 127
            echo "          </nav>
        ";
        }
        // line 129
        echo "      ";
    }

    // line 139
    public function block_featured($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 140
        echo "        <div class=\"featured-top\">
          <aside class=\"featured-top__inner section ";
        // line 141
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null), 141, $this->source), "html", null, true);
        echo " clearfix\" role=\"complementary\">
            ";
        // line 142
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "featured_top", [], "any", false, false, true, 142), 142, $this->source), "html", null, true);
        echo "
          </aside>
        </div>
      ";
    }

    // line 148
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 149
        echo "        <div id=\"main\" class=\"";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null), 149, $this->source), "html", null, true);
        echo "\">
          ";
        // line 150
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 150), 150, $this->source), "html", null, true);
        echo "
          <div class=\"row row-offcanvas row-offcanvas-left clearfix\">
              <main";
        // line 152
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["content_attributes"] ?? null), 152, $this->source), "html", null, true);
        echo ">
                <section class=\"section\">
                  <a href=\"#main-content\" id=\"main-content\" tabindex=\"-1\"></a>
                  ";
        // line 155
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 155), 155, $this->source), "html", null, true);
        echo "
                </section>
              </main>
            ";
        // line 158
        if (($context["sidebar_first_exists"] ?? null)) {
            // line 159
            echo "              <div";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["sidebar_first_attributes"] ?? null), 159, $this->source), "html", null, true);
            echo ">
                <aside class=\"section\" role=\"complementary\">
                  ";
            // line 161
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 161), 161, $this->source), "html", null, true);
            echo "
                </aside>
              </div>
            ";
        }
        // line 165
        echo "            ";
        if (($context["sidebar_second_exists"] ?? null)) {
            // line 166
            echo "              <div";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["sidebar_second_attributes"] ?? null), 166, $this->source), "html", null, true);
            echo ">
                <aside class=\"section\" role=\"complementary\">
                  ";
            // line 168
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 168), 168, $this->source), "html", null, true);
            echo "
                </aside>
              </div>
            ";
        }
        // line 172
        echo "          </div>
        </div>
      ";
    }

    // line 186
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 187
        echo "        <div class=\"";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container"] ?? null), 187, $this->source), "html", null, true);
        echo "\">
          ";
        // line 188
        if ((((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_first", [], "any", false, false, true, 188) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_second", [], "any", false, false, true, 188)) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_third", [], "any", false, false, true, 188)) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_fourth", [], "any", false, false, true, 188))) {
            // line 189
            echo "            <div class=\"site-footer__top clearfix\">
              ";
            // line 190
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_first", [], "any", false, false, true, 190), 190, $this->source), "html", null, true);
            echo "
              ";
            // line 191
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_second", [], "any", false, false, true, 191), 191, $this->source), "html", null, true);
            echo "
              ";
            // line 192
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_third", [], "any", false, false, true, 192), 192, $this->source), "html", null, true);
            echo "
              ";
            // line 193
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_fourth", [], "any", false, false, true, 193), 193, $this->source), "html", null, true);
            echo "
            </div>
          ";
        }
        // line 196
        echo "          ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_fifth", [], "any", false, false, true, 196)) {
            // line 197
            echo "            <div class=\"site-footer__bottom\">
              ";
            // line 198
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_fifth", [], "any", false, false, true, 198), 198, $this->source), "html", null, true);
            echo "
            </div>
          ";
        }
        // line 201
        echo "        </div>
      ";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "themes/contrib/bootstrap_barrio/templates/layout/page.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  394 => 201,  388 => 198,  385 => 197,  382 => 196,  376 => 193,  372 => 192,  368 => 191,  364 => 190,  361 => 189,  359 => 188,  354 => 187,  350 => 186,  344 => 172,  337 => 168,  331 => 166,  328 => 165,  321 => 161,  315 => 159,  313 => 158,  307 => 155,  301 => 152,  296 => 150,  291 => 149,  287 => 148,  279 => 142,  275 => 141,  272 => 140,  268 => 139,  264 => 129,  260 => 127,  256 => 125,  253 => 124,  249 => 122,  246 => 121,  242 => 119,  238 => 117,  235 => 116,  229 => 113,  226 => 112,  224 => 111,  219 => 110,  212 => 105,  210 => 104,  206 => 103,  201 => 102,  199 => 101,  194 => 100,  190 => 98,  188 => 97,  183 => 96,  180 => 95,  176 => 93,  172 => 91,  169 => 90,  163 => 87,  160 => 86,  158 => 85,  154 => 84,  149 => 83,  145 => 81,  143 => 80,  138 => 79,  135 => 78,  131 => 77,  123 => 203,  121 => 186,  118 => 185,  111 => 181,  107 => 180,  103 => 179,  99 => 178,  96 => 177,  94 => 176,  91 => 175,  89 => 148,  86 => 147,  83 => 146,  80 => 139,  77 => 138,  70 => 134,  66 => 133,  63 => 132,  61 => 131,  58 => 130,  56 => 77,  52 => 76,  47 => 73,  45 => 72,  43 => 71,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/contrib/bootstrap_barrio/templates/layout/page.html.twig", "/var/www/html/themes/contrib/bootstrap_barrio/templates/layout/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 71, "block" => 77, "if" => 131);
        static $filters = array("trim" => 71, "striptags" => 71, "render" => 71, "t" => 76, "escape" => 133);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'block', 'if'],
                ['trim', 'striptags', 'render', 't', 'escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
