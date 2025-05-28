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

/* themes/contrib/gin/templates/views/views-view-table.html.twig */
class __TwigTemplate_e5b23b5e1ad7cdd36789b7244978120a extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 35
        $context["classes"] = [0 => "views-table", 1 => "views-view-table", 2 => ("cols-" . twig_length_filter($this->env, $this->sandbox->ensureToStringAllowed(        // line 38
($context["header"] ?? null), 38, $this->source))), 3 => ((        // line 39
($context["responsive"] ?? null)) ? ("responsive-enabled") : ("")), 4 => ((        // line 40
($context["sticky"] ?? null)) ? ("sticky-enabled position-sticky") : (""))];
        // line 43
        echo "
";
        // line 44
        $macros["macros"] = $this->macros["macros"] = $this;
        // line 45
        echo "
";
        // line 87
        echo "
";
        // line 88
        if ((($context["header"] ?? null) && ($context["sticky"] ?? null))) {
            // line 89
            echo "  <table class=\"gin--sticky-table-header syncscroll\" name=\"gin-sticky-header\" hidden>
    ";
            // line 90
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["macros"], "macro_table_header", [($context["header"] ?? null), ($context["fields"] ?? null), ($context["sticky"] ?? null)], 90, $context, $this->getSourceContext()));
            echo "
  </table>
";
        }
        // line 93
        echo "<div class=\"gin-table-scroll-wrapper gin-horizontal-scroll-shadow syncscroll\" name=\"gin-sticky-header\">
  <table";
        // line 94
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 94), 94, $this->source), "html", null, true);
        echo ">
    ";
        // line 95
        if (($context["caption_needed"] ?? null)) {
            // line 96
            echo "      <caption>
      ";
            // line 97
            if (($context["caption"] ?? null)) {
                // line 98
                echo "        ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["caption"] ?? null), 98, $this->source), "html", null, true);
                echo "
      ";
            } else {
                // line 100
                echo "        ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 100, $this->source), "html", null, true);
                echo "
      ";
            }
            // line 102
            echo "      ";
            if ( !twig_test_empty(($context["summary_element"] ?? null))) {
                // line 103
                echo "        ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["summary_element"] ?? null), 103, $this->source), "html", null, true);
                echo "
      ";
            }
            // line 105
            echo "      </caption>
    ";
        }
        // line 107
        echo "    ";
        if (($context["header"] ?? null)) {
            // line 108
            echo "      ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["macros"], "macro_table_header", [($context["header"] ?? null), ($context["fields"] ?? null)], 108, $context, $this->getSourceContext()));
            echo "
    ";
        }
        // line 110
        echo "    <tbody>
      ";
        // line 111
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["rows"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 112
            echo "        <tr";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["row"], "attributes", [], "any", false, false, true, 112), 112, $this->source), "html", null, true);
            echo ">
          ";
            // line 113
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["row"], "columns", [], "any", false, false, true, 113));
            foreach ($context['_seq'] as $context["key"] => $context["column"]) {
                // line 114
                echo "            ";
                if (twig_get_attribute($this->env, $this->source, $context["column"], "default_classes", [], "any", false, false, true, 114)) {
                    // line 115
                    echo "              ";
                    // line 116
                    $context["column_classes"] = [0 => "views-field"];
                    // line 120
                    echo "              ";
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["column"], "fields", [], "any", false, false, true, 120));
                    foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
                        // line 121
                        echo "                ";
                        $context["column_classes"] = twig_array_merge($this->sandbox->ensureToStringAllowed(($context["column_classes"] ?? null), 121, $this->source), [0 => ("views-field-" . $this->sandbox->ensureToStringAllowed($context["field"], 121, $this->source))]);
                        // line 122
                        echo "              ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 123
                    echo "            ";
                }
                // line 124
                echo "            <td";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["column"], "attributes", [], "any", false, false, true, 124), "addClass", [0 => ($context["column_classes"] ?? null)], "method", false, false, true, 124), 124, $this->source), "html", null, true);
                echo ">";
                // line 125
                if (twig_get_attribute($this->env, $this->source, $context["column"], "wrapper_element", [], "any", false, false, true, 125)) {
                    // line 126
                    echo "<";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "wrapper_element", [], "any", false, false, true, 126), 126, $this->source), "html", null, true);
                    echo ">
                ";
                    // line 127
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["column"], "content", [], "any", false, false, true, 127));
                    foreach ($context['_seq'] as $context["_key"] => $context["content"]) {
                        // line 128
                        echo "                  ";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["content"], "separator", [], "any", false, false, true, 128), 128, $this->source), "html", null, true);
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["content"], "field_output", [], "any", false, false, true, 128), 128, $this->source), "html", null, true);
                        echo "
                ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['content'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 130
                    echo "                </";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "wrapper_element", [], "any", false, false, true, 130), 130, $this->source), "html", null, true);
                    echo ">";
                } else {
                    // line 132
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["column"], "content", [], "any", false, false, true, 132));
                    foreach ($context['_seq'] as $context["_key"] => $context["content"]) {
                        // line 133
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["content"], "separator", [], "any", false, false, true, 133), 133, $this->source), "html", null, true);
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["content"], "field_output", [], "any", false, false, true, 133), 133, $this->source), "html", null, true);
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['content'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                }
                // line 136
                echo "            </td>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['column'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 138
            echo "        </tr>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 140
        echo "    </tbody>
  </table>
</div>
";
    }

    // line 46
    public function macro_table_header($__header__ = null, $__fields__ = null, $__gin_is_sticky__ = null, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "header" => $__header__,
            "fields" => $__fields__,
            "gin_is_sticky" => $__gin_is_sticky__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start(function () { return ''; });
        try {
            // line 47
            echo "  <thead>
    <tr>
      ";
            // line 49
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["header"] ?? null));
            foreach ($context['_seq'] as $context["key"] => $context["column"]) {
                // line 50
                echo "        ";
                if (twig_get_attribute($this->env, $this->source, $context["column"], "default_classes", [], "any", false, false, true, 50)) {
                    // line 51
                    echo "          ";
                    // line 52
                    $context["column_classes"] = [0 => "views-field", 1 => ("views-field-" . $this->sandbox->ensureToStringAllowed((($__internal_compile_0 =                     // line 54
($context["fields"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[$context["key"]] ?? null) : null), 54, $this->source)), 2 => ((twig_in_filter("bulk-form", (($__internal_compile_1 =                     // line 55
($context["fields"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1[$context["key"]] ?? null) : null))) ? ("gin--sticky-bulk-select") : (""))];
                    // line 58
                    echo "        ";
                }
                // line 59
                echo "        <th";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["column"], "attributes", [], "any", false, false, true, 59), "addClass", [0 => ($context["column_classes"] ?? null)], "method", false, false, true, 59), "setAttribute", [0 => "scope", 1 => "col"], "method", false, false, true, 59), 59, $this->source), "html", null, true);
                echo ">
          ";
                // line 60
                if (((($context["gin_is_sticky"] ?? null) && twig_get_attribute($this->env, $this->source, ($context["fields"] ?? null), $context["key"], [], "array", true, true, true, 60)) && twig_in_filter("bulk-form", (($__internal_compile_2 = ($context["fields"] ?? null)) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2[$context["key"]] ?? null) : null)))) {
                    // line 61
                    echo "            <input
              type=\"checkbox\"
              class=\"form-checkbox form-boolean form-boolean--type-checkbox\"
              title=\"";
                    // line 64
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Select all rows in this table"));
                    echo "\"
            />
          ";
                }
                // line 67
                if (twig_get_attribute($this->env, $this->source, $context["column"], "wrapper_element", [], "any", false, false, true, 67)) {
                    // line 68
                    echo "<";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "wrapper_element", [], "any", false, false, true, 68), 68, $this->source), "html", null, true);
                    echo ">";
                    // line 69
                    if (twig_get_attribute($this->env, $this->source, $context["column"], "url", [], "any", false, false, true, 69)) {
                        // line 70
                        echo "<a href=\"";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "url", [], "any", false, false, true, 70), 70, $this->source), "html", null, true);
                        echo "\" title=\"";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "title", [], "any", false, false, true, 70), 70, $this->source), "html", null, true);
                        echo "\" rel=\"nofollow\">";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "content", [], "any", false, false, true, 70), 70, $this->source), "html", null, true);
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "sort_indicator", [], "any", false, false, true, 70), 70, $this->source), "html", null, true);
                        echo "</a>";
                    } else {
                        // line 72
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "content", [], "any", false, false, true, 72), 72, $this->source), "html", null, true);
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "sort_indicator", [], "any", false, false, true, 72), 72, $this->source), "html", null, true);
                    }
                    // line 74
                    echo "</";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "wrapper_element", [], "any", false, false, true, 74), 74, $this->source), "html", null, true);
                    echo ">";
                } else {
                    // line 76
                    if (twig_get_attribute($this->env, $this->source, $context["column"], "url", [], "any", false, false, true, 76)) {
                        // line 77
                        echo "<a href=\"";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "url", [], "any", false, false, true, 77), 77, $this->source), "html", null, true);
                        echo "\" title=\"";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "title", [], "any", false, false, true, 77), 77, $this->source), "html", null, true);
                        echo "\" rel=\"nofollow\">";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "content", [], "any", false, false, true, 77), 77, $this->source), "html", null, true);
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "sort_indicator", [], "any", false, false, true, 77), 77, $this->source), "html", null, true);
                        echo "</a>";
                    } else {
                        // line 79
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "content", [], "any", false, false, true, 79), 79, $this->source), "html", null, true);
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["column"], "sort_indicator", [], "any", false, false, true, 79), 79, $this->source), "html", null, true);
                    }
                }
                // line 82
                echo "</th>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['column'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 84
            echo "    </tr>
  </thead>
";

            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    public function getTemplateName()
    {
        return "themes/contrib/gin/templates/views/views-view-table.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  321 => 84,  314 => 82,  309 => 79,  299 => 77,  297 => 76,  292 => 74,  288 => 72,  278 => 70,  276 => 69,  272 => 68,  270 => 67,  264 => 64,  259 => 61,  257 => 60,  252 => 59,  249 => 58,  247 => 55,  246 => 54,  245 => 52,  243 => 51,  240 => 50,  236 => 49,  232 => 47,  217 => 46,  210 => 140,  203 => 138,  196 => 136,  188 => 133,  184 => 132,  179 => 130,  169 => 128,  165 => 127,  160 => 126,  158 => 125,  154 => 124,  151 => 123,  145 => 122,  142 => 121,  137 => 120,  135 => 116,  133 => 115,  130 => 114,  126 => 113,  121 => 112,  117 => 111,  114 => 110,  108 => 108,  105 => 107,  101 => 105,  95 => 103,  92 => 102,  86 => 100,  80 => 98,  78 => 97,  75 => 96,  73 => 95,  69 => 94,  66 => 93,  60 => 90,  57 => 89,  55 => 88,  52 => 87,  49 => 45,  47 => 44,  44 => 43,  42 => 40,  41 => 39,  40 => 38,  39 => 35,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/contrib/gin/templates/views/views-view-table.html.twig", "/var/www/html/themes/contrib/gin/templates/views/views-view-table.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 35, "import" => 44, "if" => 88, "for" => 111, "macro" => 46);
        static $filters = array("length" => 38, "escape" => 94, "merge" => 121, "t" => 64);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'import', 'if', 'for', 'macro'],
                ['length', 'escape', 'merge', 't'],
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
