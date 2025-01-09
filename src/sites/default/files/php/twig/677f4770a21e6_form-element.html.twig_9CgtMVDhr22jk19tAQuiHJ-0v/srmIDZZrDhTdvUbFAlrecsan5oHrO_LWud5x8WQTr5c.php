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

/* themes/contrib/bootstrap_barrio/templates/form/form-element.html.twig */
class __TwigTemplate_6fab48ffab7915b75cb5c705fe78a471 extends Template
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
        // line 47
        echo "
";
        // line 49
        $context["label_attributes"] = ((($context["label_attributes"] ?? null)) ? (($context["label_attributes"] ?? null)) : ($this->extensions['Drupal\Core\Template\TwigExtension']->createAttribute()));
        // line 51
        echo "
";
        // line 52
        if ((($context["type"] ?? null) == "checkbox")) {
            // line 53
            echo "  ";
            $context["wrapperclass"] = (((($context["checkbox_style"] ?? null) != "form-button")) ? ("form-check") : (""));
            // line 54
            echo "  ";
            $context["labelclass"] = (((($context["checkbox_style"] ?? null) == "form-button")) ? ("btn btn-outline-primary") : ("form-check-label"));
            // line 55
            echo "  ";
            $context["inputclass"] = (((($context["checkbox_style"] ?? null) == "form-button")) ? ("btn-check") : ("form-check-input"));
        }
        // line 57
        echo "
";
        // line 58
        if ((($context["type"] ?? null) == "radio")) {
            // line 59
            echo "  ";
            $context["wrapperclass"] = (((($context["checkbox_style"] ?? null) != "form-button")) ? ("form-check") : (""));
            // line 60
            echo "  ";
            $context["labelclass"] = (((($context["checkbox_style"] ?? null) == "form-button")) ? ("btn btn-outline-primary") : ("form-check-label"));
            // line 61
            echo "  ";
            $context["inputclass"] = (((($context["checkbox_style"] ?? null) == "form-button")) ? ("btn-check") : ("form-check-input"));
        }
        // line 63
        echo "
";
        // line 65
        $context["classes"] = ["js-form-item", ("js-form-type-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(        // line 67
($context["type"] ?? null), 67, $this->source))), ((twig_in_filter(        // line 68
($context["type"] ?? null), ["checkbox", "radio"])) ? (\Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(($context["type"] ?? null), 68, $this->source))) : (("form-type-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(($context["type"] ?? null), 68, $this->source))))), ((twig_in_filter(        // line 69
($context["type"] ?? null), ["checkbox", "radio"])) ? (($context["wrapperclass"] ?? null)) : ("")), (((        // line 70
($context["checkbox_style"] ?? null) == "form-switch")) ? ("form-switch") : ("")), ((twig_in_filter(        // line 71
($context["type"] ?? null), ["checkbox"])) ? ("mb-3") : ("")), ("js-form-item-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(        // line 72
($context["name"] ?? null), 72, $this->source))), ("form-item-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(        // line 73
($context["name"] ?? null), 73, $this->source))), ((!twig_in_filter(        // line 74
($context["title_display"] ?? null), ["after", "before"])) ? ("form-no-label") : ("")), (((        // line 75
($context["disabled"] ?? null) == "disabled")) ? ("disabled") : ("")), ((        // line 76
($context["errors"] ?? null)) ? ("has-error") : (""))];
        // line 79
        echo "
";
        // line 80
        if ((($context["title_display"] ?? null) == "invisible")) {
            // line 81
            echo "  ";
            if (array_key_exists("labelclass", $context)) {
                // line 82
                echo "    ";
                $context["labelclass"] = ($this->sandbox->ensureToStringAllowed(($context["labelclass"] ?? null), 82, $this->source) . " visually-hidden");
                // line 83
                echo "  ";
            } else {
                // line 84
                echo "    ";
                $context["labelclass"] = "visually-hidden";
                // line 85
                echo "  ";
            }
        }
        // line 87
        echo "
";
        // line 89
        $context["description_classes"] = ["description", "text-muted", (((        // line 92
($context["description_display"] ?? null) == "invisible")) ? ("visually-hidden") : (""))];
        // line 95
        if (twig_in_filter(($context["type"] ?? null), ["checkbox", "radio"])) {
            // line 96
            echo "  <div";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [($context["classes"] ?? null)], "method", false, false, true, 96), 96, $this->source), "html", null, true);
            echo ">
    ";
            // line 97
            if ( !twig_test_empty(($context["prefix"] ?? null))) {
                // line 98
                echo "      <span class=\"field-prefix\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["prefix"] ?? null), 98, $this->source), "html", null, true);
                echo "</span>
    ";
            }
            // line 100
            echo "    ";
            if (((($context["description_display"] ?? null) == "before") && twig_get_attribute($this->env, $this->source, ($context["description"] ?? null), "content", [], "any", false, false, true, 100))) {
                // line 101
                echo "      <div";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["description"] ?? null), "attributes", [], "any", false, false, true, 101), 101, $this->source), "html", null, true);
                echo ">
        ";
                // line 102
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["description"] ?? null), "content", [], "any", false, false, true, 102), 102, $this->source), "html", null, true);
                echo "
      </div>
    ";
            }
            // line 105
            echo "    ";
            if (twig_in_filter(($context["label_display"] ?? null), ["before", "invisible"])) {
                // line 106
                echo "      <label ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["label_attributes"] ?? null), "addClass", [($context["labelclass"] ?? null)], "method", false, false, true, 106), "setAttribute", ["for", twig_get_attribute($this->env, $this->source, ($context["input_attributes"] ?? null), "id", [], "any", false, false, true, 106)], "method", false, false, true, 106), 106, $this->source), "html", null, true);
                echo ">
        ";
                // line 107
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(($context["input_title"] ?? null), 107, $this->source));
                echo "
      </label>
    ";
            }
            // line 110
            echo "    ";
            if ((($context["checkbox_style"] ?? null) == "form-button")) {
                // line 111
                echo "      <input";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["input_attributes"] ?? null), "addClass", [($context["inputclass"] ?? null)], "method", false, false, true, 111), "setAttribute", ["autocomplete", "off"], "method", false, false, true, 111), 111, $this->source), "html", null, true);
                echo ">
    ";
            } else {
                // line 113
                echo "      <input";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["input_attributes"] ?? null), "addClass", [($context["inputclass"] ?? null)], "method", false, false, true, 113), 113, $this->source), "html", null, true);
                echo ">
    ";
            }
            // line 115
            echo "    ";
            if ((($context["label_display"] ?? null) == "after")) {
                // line 116
                echo "      <label ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["label_attributes"] ?? null), "addClass", [($context["labelclass"] ?? null)], "method", false, false, true, 116), "setAttribute", ["for", twig_get_attribute($this->env, $this->source, ($context["input_attributes"] ?? null), "id", [], "any", false, false, true, 116)], "method", false, false, true, 116), 116, $this->source), "html", null, true);
                echo ">
        ";
                // line 117
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(($context["input_title"] ?? null), 117, $this->source));
                echo "
      </label>
    ";
            }
            // line 120
            echo "    ";
            if ( !twig_test_empty(($context["suffix"] ?? null))) {
                // line 121
                echo "      <span class=\"field-suffix\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["suffix"] ?? null), 121, $this->source), "html", null, true);
                echo "</span>
    ";
            }
            // line 123
            echo "    ";
            if (($context["errors"] ?? null)) {
                // line 124
                echo "      <div class=\"invalid-feedback form-item--error-message\">
        ";
                // line 125
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["errors"] ?? null), 125, $this->source), "html", null, true);
                echo "
      </div>
    ";
            }
            // line 128
            echo "    ";
            if ((twig_in_filter(($context["description_display"] ?? null), ["after", "invisible"]) && twig_get_attribute($this->env, $this->source, ($context["description"] ?? null), "content", [], "any", false, false, true, 128))) {
                // line 129
                echo "      <small";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["description"] ?? null), "attributes", [], "any", false, false, true, 129), "addClass", [($context["description_classes"] ?? null)], "method", false, false, true, 129), 129, $this->source), "html", null, true);
                echo ">
        ";
                // line 130
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["description"] ?? null), "content", [], "any", false, false, true, 130), 130, $this->source), "html", null, true);
                echo "
      </small>
    ";
            }
            // line 133
            echo "  </div>
";
        } else {
            // line 135
            echo "  <div";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [($context["classes"] ?? null), "mb-3", ((($context["float_label"] ?? null)) ? ("form-floating") : (""))], "method", false, false, true, 135), 135, $this->source), "html", null, true);
            echo ">
    ";
            // line 136
            if (twig_in_filter(($context["label_display"] ?? null), ["before", "invisible"])) {
                // line 137
                echo "      ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["label"] ?? null), 137, $this->source), "html", null, true);
                echo "
    ";
            }
            // line 139
            echo "    ";
            if (( !twig_test_empty(($context["prefix"] ?? null)) ||  !twig_test_empty(($context["suffix"] ?? null)))) {
                // line 140
                echo "      <div class=\"input-group";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(((($context["errors"] ?? null)) ? (" is-invalid") : ("")));
                echo "\">
    ";
            }
            // line 142
            echo "    ";
            if ( !twig_test_empty(($context["prefix"] ?? null))) {
                // line 143
                echo "      <div class=\"input-group-prepend\">
        <span class=\"field-prefix input-group-text\">";
                // line 144
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["prefix"] ?? null), 144, $this->source), "html", null, true);
                echo "</span>
      </div>
    ";
            }
            // line 147
            echo "    ";
            if (((($context["description_display"] ?? null) == "before") && twig_get_attribute($this->env, $this->source, ($context["description"] ?? null), "content", [], "any", false, false, true, 147))) {
                // line 148
                echo "      <div";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["description"] ?? null), "attributes", [], "any", false, false, true, 148), 148, $this->source), "html", null, true);
                echo ">
        ";
                // line 149
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["description"] ?? null), "content", [], "any", false, false, true, 149), 149, $this->source), "html", null, true);
                echo "
      </div>
    ";
            }
            // line 152
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["children"] ?? null), 152, $this->source), "html", null, true);
            echo "
    ";
            // line 153
            if ( !twig_test_empty(($context["suffix"] ?? null))) {
                // line 154
                echo "      <div class=\"input-group-append\">
        <span class=\"field-suffix input-group-text\">";
                // line 155
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["suffix"] ?? null), 155, $this->source), "html", null, true);
                echo "</span>
      </div>
    ";
            }
            // line 158
            echo "    ";
            if (( !twig_test_empty(($context["prefix"] ?? null)) ||  !twig_test_empty(($context["suffix"] ?? null)))) {
                // line 159
                echo "      </div>
    ";
            }
            // line 161
            echo "    ";
            if ((($context["label_display"] ?? null) == "after")) {
                // line 162
                echo "      ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["label"] ?? null), 162, $this->source), "html", null, true);
                echo "
    ";
            }
            // line 164
            echo "    ";
            if (($context["errors"] ?? null)) {
                // line 165
                echo "      <div class=\"invalid-feedback form-item--error-message\">
        ";
                // line 166
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["errors"] ?? null), 166, $this->source), "html", null, true);
                echo "
      </div>
    ";
            }
            // line 169
            echo "    ";
            if ((twig_in_filter(($context["description_display"] ?? null), ["after", "invisible"]) && twig_get_attribute($this->env, $this->source, ($context["description"] ?? null), "content", [], "any", false, false, true, 169))) {
                // line 170
                echo "      <small";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["description"] ?? null), "attributes", [], "any", false, false, true, 170), "addClass", [($context["description_classes"] ?? null)], "method", false, false, true, 170), 170, $this->source), "html", null, true);
                echo ">
        ";
                // line 171
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["description"] ?? null), "content", [], "any", false, false, true, 171), 171, $this->source), "html", null, true);
                echo "
      </small>
    ";
            }
            // line 174
            echo "  </div>
";
        }
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["type", "checkbox_style", "name", "title_display", "disabled", "errors", "description_display", "attributes", "prefix", "description", "label_display", "input_attributes", "input_title", "suffix", "float_label", "label", "children"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "themes/contrib/bootstrap_barrio/templates/form/form-element.html.twig";
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
        return array (  333 => 174,  327 => 171,  322 => 170,  319 => 169,  313 => 166,  310 => 165,  307 => 164,  301 => 162,  298 => 161,  294 => 159,  291 => 158,  285 => 155,  282 => 154,  280 => 153,  275 => 152,  269 => 149,  264 => 148,  261 => 147,  255 => 144,  252 => 143,  249 => 142,  243 => 140,  240 => 139,  234 => 137,  232 => 136,  227 => 135,  223 => 133,  217 => 130,  212 => 129,  209 => 128,  203 => 125,  200 => 124,  197 => 123,  191 => 121,  188 => 120,  182 => 117,  177 => 116,  174 => 115,  168 => 113,  162 => 111,  159 => 110,  153 => 107,  148 => 106,  145 => 105,  139 => 102,  134 => 101,  131 => 100,  125 => 98,  123 => 97,  118 => 96,  116 => 95,  114 => 92,  113 => 89,  110 => 87,  106 => 85,  103 => 84,  100 => 83,  97 => 82,  94 => 81,  92 => 80,  89 => 79,  87 => 76,  86 => 75,  85 => 74,  84 => 73,  83 => 72,  82 => 71,  81 => 70,  80 => 69,  79 => 68,  78 => 67,  77 => 65,  74 => 63,  70 => 61,  67 => 60,  64 => 59,  62 => 58,  59 => 57,  55 => 55,  52 => 54,  49 => 53,  47 => 52,  44 => 51,  42 => 49,  39 => 47,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/contrib/bootstrap_barrio/templates/form/form-element.html.twig", "/var/www/html/themes/contrib/bootstrap_barrio/templates/form/form-element.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 49, "if" => 52);
        static $filters = array("clean_class" => 67, "escape" => 96, "raw" => 107);
        static $functions = array("create_attribute" => 49);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['clean_class', 'escape', 'raw'],
                ['create_attribute']
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
