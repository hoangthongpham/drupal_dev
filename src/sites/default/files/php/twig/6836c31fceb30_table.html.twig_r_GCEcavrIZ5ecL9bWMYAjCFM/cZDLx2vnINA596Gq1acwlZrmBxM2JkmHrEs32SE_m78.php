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

/* themes/contrib/gin/templates/dataset/table.html.twig */
class __TwigTemplate_aeac4b6ebdd4491db7fb605b8d578339 extends \Twig\Template
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
        // line 42
        echo "
";
        // line 43
        $macros["macros"] = $this->macros["macros"] = $this;
        // line 44
        echo "
";
        // line 80
        echo "
<div class=\"layer-wrapper gin-layer-wrapper\">
  ";
        // line 82
        if (($context["header"] ?? null)) {
            // line 83
            echo "    ";
            if (($context["sticky"] ?? null)) {
                // line 84
                echo "      <table class=\"gin--sticky-table-header syncscroll\" name=\"gin-sticky-header\" hidden>
        ";
                // line 85
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["macros"], "macro_table_header", [($context["header"] ?? null)], 85, $context, $this->getSourceContext()));
                echo "
      </table>
    ";
            }
            // line 88
            echo "  <div class=\"gin-table-scroll-wrapper gin-horizontal-scroll-shadow syncscroll\" name=\"gin-sticky-header\">
  ";
        }
        // line 90
        echo "    <table";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["attributes"] ?? null), 90, $this->source), "html", null, true);
        echo ">
      ";
        // line 91
        if (($context["caption"] ?? null)) {
            // line 92
            echo "        <caption>";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["caption"] ?? null), 92, $this->source), "html", null, true);
            echo "</caption>
      ";
        }
        // line 94
        echo "
      ";
        // line 95
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["colgroups"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["colgroup"]) {
            // line 96
            echo "        ";
            if (twig_get_attribute($this->env, $this->source, $context["colgroup"], "cols", [], "any", false, false, true, 96)) {
                // line 97
                echo "          <colgroup";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["colgroup"], "attributes", [], "any", false, false, true, 97), 97, $this->source), "html", null, true);
                echo ">
            ";
                // line 98
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["colgroup"], "cols", [], "any", false, false, true, 98));
                foreach ($context['_seq'] as $context["_key"] => $context["col"]) {
                    // line 99
                    echo "              <col";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["col"], "attributes", [], "any", false, false, true, 99), 99, $this->source), "html", null, true);
                    echo " />
            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['col'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 101
                echo "          </colgroup>
        ";
            } else {
                // line 103
                echo "          <colgroup";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["colgroup"], "attributes", [], "any", false, false, true, 103), 103, $this->source), "html", null, true);
                echo " />
        ";
            }
            // line 105
            echo "      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['colgroup'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 106
        echo "
      ";
        // line 107
        if (($context["header"] ?? null)) {
            // line 108
            echo "        ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["macros"], "macro_table_header", [($context["header"] ?? null)], 108, $context, $this->getSourceContext()));
            echo "
      ";
        }
        // line 110
        echo "
      ";
        // line 111
        if (($context["rows"] ?? null)) {
            // line 112
            echo "        <tbody>
          ";
            // line 113
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["rows"] ?? null));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                // line 114
                echo "            ";
                // line 115
                $context["row_classes"] = [0 => (( !                // line 116
($context["no_striping"] ?? null)) ? (twig_cycle([0 => "odd", 1 => "even"], $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, true, 116), 116, $this->source))) : (""))];
                // line 119
                echo "            <tr";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["row"], "attributes", [], "any", false, false, true, 119), "addClass", [0 => ($context["row_classes"] ?? null)], "method", false, false, true, 119), 119, $this->source), "html", null, true);
                echo ">
              ";
                // line 120
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["row"], "cells", [], "any", false, false, true, 120));
                foreach ($context['_seq'] as $context["_key"] => $context["cell"]) {
                    // line 121
                    echo "                <";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["cell"], "tag", [], "any", false, false, true, 121), 121, $this->source), "html", null, true);
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["cell"], "attributes", [], "any", false, false, true, 121), 121, $this->source), "html", null, true);
                    echo ">";
                    // line 122
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["cell"], "content", [], "any", false, false, true, 122), 122, $this->source), "html", null, true);
                    // line 123
                    echo "</";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["cell"], "tag", [], "any", false, false, true, 123), 123, $this->source), "html", null, true);
                    echo ">
              ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cell'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 125
                echo "            </tr>
          ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['length'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 127
            echo "        </tbody>
      ";
        } elseif (        // line 128
($context["empty"] ?? null)) {
            // line 129
            echo "        <tbody>
          <tr class=\"odd\">
            <td colspan=\"";
            // line 131
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["header_columns"] ?? null), 131, $this->source), "html", null, true);
            echo "\" class=\"empty message\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["empty"] ?? null), 131, $this->source), "html", null, true);
            echo "</td>
          </tr>
        </tbody>
      ";
        }
        // line 135
        echo "      ";
        if (($context["footer"] ?? null)) {
            // line 136
            echo "        <tfoot>
          ";
            // line 137
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["footer"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                // line 138
                echo "            <tr";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["row"], "attributes", [], "any", false, false, true, 138), 138, $this->source), "html", null, true);
                echo ">
              ";
                // line 139
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["row"], "cells", [], "any", false, false, true, 139));
                foreach ($context['_seq'] as $context["_key"] => $context["cell"]) {
                    // line 140
                    echo "                <";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["cell"], "tag", [], "any", false, false, true, 140), 140, $this->source), "html", null, true);
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["cell"], "attributes", [], "any", false, false, true, 140), 140, $this->source), "html", null, true);
                    echo ">";
                    // line 141
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["cell"], "content", [], "any", false, false, true, 141), 141, $this->source), "html", null, true);
                    // line 142
                    echo "</";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["cell"], "tag", [], "any", false, false, true, 142), 142, $this->source), "html", null, true);
                    echo ">
              ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cell'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 144
                echo "            </tr>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 146
            echo "        </tfoot>
      ";
        }
        // line 148
        echo "    </table>
  ";
        // line 149
        if (($context["header"] ?? null)) {
            // line 150
            echo "  </div>
  ";
        }
        // line 152
        echo "</div>
";
    }

    // line 45
    public function macro_table_header($__header__ = null, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "header" => $__header__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start(function () { return ''; });
        try {
            // line 46
            echo "  <thead>
    <tr>
      ";
            // line 48
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["header"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["cell"]) {
                // line 49
                echo "        ";
                if (twig_in_filter("<a", $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_get_attribute($this->env, $this->source, $context["cell"], "content", [], "any", false, false, true, 49))))) {
                    // line 50
                    echo "          ";
                    // line 51
                    $context["cell_classes"] = [0 => "th__item", 1 => ((twig_get_attribute($this->env, $this->source,                     // line 53
$context["cell"], "active_table_sort", [], "any", false, false, true, 53)) ? ("is-active") : ("")), 2 => ((twig_in_filter("select-all", twig_get_attribute($this->env, $this->source,                     // line 54
$context["cell"], "attributes", [], "any", false, false, true, 54))) ? ("gin--sticky-bulk-select") : (""))];
                    // line 57
                    echo "        ";
                } else {
                    // line 58
                    echo "          ";
                    // line 59
                    $context["cell_classes"] = [0 => ((\Drupal\Component\Utility\Html::getClass($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source,                     // line 60
$context["cell"], "content", [], "any", false, false, true, 60), 60, $this->source)))) ? (("th__" . \Drupal\Component\Utility\Html::getClass($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["cell"], "content", [], "any", false, false, true, 60), 60, $this->source))))) : ("")), 1 => ((twig_get_attribute($this->env, $this->source,                     // line 61
$context["cell"], "active_table_sort", [], "any", false, false, true, 61)) ? ("is-active") : ("")), 2 => ((twig_in_filter("select-all", twig_get_attribute($this->env, $this->source,                     // line 62
$context["cell"], "attributes", [], "any", false, false, true, 62))) ? ("gin--sticky-bulk-select") : (""))];
                    // line 65
                    echo "        ";
                }
                // line 66
                echo "        <";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["cell"], "tag", [], "any", false, false, true, 66), 66, $this->source), "html", null, true);
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["cell"], "attributes", [], "any", false, false, true, 66), "addClass", [0 => ($context["cell_classes"] ?? null)], "method", false, false, true, 66), 66, $this->source), "html", null, true);
                echo ">";
                // line 67
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["cell"], "content", [], "any", false, false, true, 67), 67, $this->source), "html", null, true);
                // line 68
                if (twig_in_filter("gin--sticky-bulk-select", ($context["cell_classes"] ?? null))) {
                    // line 69
                    echo "            <input
              type=\"checkbox\"
              class=\"form-checkbox form-boolean form-boolean--type-checkbox\"
              title=\"";
                    // line 72
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Select all rows in this table"));
                    echo "\"
            />
          ";
                }
                // line 75
                echo "        </";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["cell"], "tag", [], "any", false, false, true, 75), 75, $this->source), "html", null, true);
                echo ">
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cell'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 77
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
        return "themes/contrib/gin/templates/dataset/table.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  357 => 77,  348 => 75,  342 => 72,  337 => 69,  335 => 68,  333 => 67,  328 => 66,  325 => 65,  323 => 62,  322 => 61,  321 => 60,  320 => 59,  318 => 58,  315 => 57,  313 => 54,  312 => 53,  311 => 51,  309 => 50,  306 => 49,  302 => 48,  298 => 46,  285 => 45,  280 => 152,  276 => 150,  274 => 149,  271 => 148,  267 => 146,  260 => 144,  251 => 142,  249 => 141,  244 => 140,  240 => 139,  235 => 138,  231 => 137,  228 => 136,  225 => 135,  216 => 131,  212 => 129,  210 => 128,  207 => 127,  192 => 125,  183 => 123,  181 => 122,  176 => 121,  172 => 120,  167 => 119,  165 => 116,  164 => 115,  162 => 114,  145 => 113,  142 => 112,  140 => 111,  137 => 110,  131 => 108,  129 => 107,  126 => 106,  120 => 105,  114 => 103,  110 => 101,  101 => 99,  97 => 98,  92 => 97,  89 => 96,  85 => 95,  82 => 94,  76 => 92,  74 => 91,  69 => 90,  65 => 88,  59 => 85,  56 => 84,  53 => 83,  51 => 82,  47 => 80,  44 => 44,  42 => 43,  39 => 42,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/contrib/gin/templates/dataset/table.html.twig", "/var/www/html/themes/contrib/gin/templates/dataset/table.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("import" => 43, "if" => 82, "for" => 95, "set" => 115, "macro" => 45);
        static $filters = array("escape" => 90, "render" => 49, "clean_class" => 60, "t" => 72);
        static $functions = array("cycle" => 116);

        try {
            $this->sandbox->checkSecurity(
                ['import', 'if', 'for', 'set', 'macro'],
                ['escape', 'render', 'clean_class', 't'],
                ['cycle']
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
