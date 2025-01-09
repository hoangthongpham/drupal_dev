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

/* themes/contrib/bootstrap_barrio/templates/misc/status-messages--alerts.html.twig */
class __TwigTemplate_27fb9ac83ac293a9b6eb3684a2775a89 extends Template
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
        // line 28
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("bootstrap_barrio/alerts"), "html", null, true);
        echo "

<svg xmlns=\"http://www.w3.org/2000/svg\" style=\"display: none;\">
  <symbol id=\"check-circle-fill\" viewBox=\"0 0 16 16\">
    <path d=\"M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z\"/>
  </symbol>
  <symbol id=\"info-fill\" viewBox=\"0 0 16 16\">
    <path d=\"M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z\"/>
  </symbol>
  <symbol id=\"exclamation-triangle-fill\" viewBox=\"0 0 16 16\">
    <path d=\"M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z\"/>
  </symbol>
</svg>

<div class=\"alert-wrapper\" data-drupal-messages>
";
        // line 43
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["message_list"] ?? null));
        foreach ($context['_seq'] as $context["type"] => $context["messages"]) {
            // line 44
            echo "  ";
            // line 45
            $context["classes"] = ["alert", "alert-dismissible", "d-flex align-items-center", "fade", "show", "col-12", (((            // line 52
$context["type"] == "status")) ? ("alert-success") : ("")), (((            // line 53
$context["type"] == "warning")) ? ("alert-warning") : ("")), (((            // line 54
$context["type"] == "error")) ? ("alert-danger") : ("")), (((            // line 55
$context["type"] == "info")) ? ("alert-info") : (""))];
            // line 58
            echo "  ";
            // line 59
            $context["role"] = ["status" => "status", "error" => "alert", "warning" => "alert", "info" => "status"];
            // line 66
            echo "  <div aria-label=\"";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_0 = ($context["status_headings"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[$context["type"]] ?? null) : null), 66, $this->source), "html", null, true);
            echo "\" ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter($this->sandbox->ensureToStringAllowed(($context["attributes"] ?? null), 66, $this->source), "role", "aria-label"), "addClass", [($context["classes"] ?? null)], "method", false, false, true, 66), "setAttribute", ["data-drupal-selector", "messages"], "method", false, false, true, 66), "setAttribute", ["role", (($__internal_compile_1 = ($context["role"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1[$context["type"]] ?? null) : null)], "method", false, false, true, 66), 66, $this->source), "html", null, true);
            echo ">
    ";
            // line 67
            if (($context["type"] == "error")) {
                // line 68
                echo "      <svg class=\"bi flex-shrink-0 me-4\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>
    ";
            } elseif ((            // line 69
$context["type"] == "warning")) {
                // line 70
                echo "      <svg class=\"bi flex-shrink-0 me-4\" role=\"img\" aria-label=\"Warning:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>
    ";
            } elseif ((            // line 71
$context["type"] == "status")) {
                // line 72
                echo "      <svg class=\"bi flex-shrink-0 me-4\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>
    ";
            } elseif ((            // line 73
$context["type"] == "info")) {
                // line 74
                echo "      <svg class=\"bi flex-shrink-0 me-4\" role=\"img\" aria-label=\"Warning:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>
    ";
            }
            // line 76
            echo "    <div>
      <h2 id=\"";
            // line 77
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_2 = ($context["title_ids"] ?? null)) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2[$context["type"]] ?? null) : null), 77, $this->source), "html", null, true);
            echo "\" class=\"alert-heading\">
        ";
            // line 78
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_3 = ($context["status_headings"] ?? null)) && is_array($__internal_compile_3) || $__internal_compile_3 instanceof ArrayAccess ? ($__internal_compile_3[$context["type"]] ?? null) : null), 78, $this->source), "html", null, true);
            echo "
      </h2>    
      ";
            // line 80
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["messages"]);
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
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 81
                echo "        ";
                if (twig_get_attribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, true, 81)) {
                    // line 82
                    echo "          ";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["message"], 82, $this->source), "html", null, true);
                    echo "
        ";
                } else {
                    // line 84
                    echo "          ";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["message"], 84, $this->source), "html", null, true);
                    echo "
      <hr>
        ";
                }
                // line 87
                echo "      ";
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 88
            echo "    </div>
    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
  </div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['type'], $context['messages'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 92
        echo "</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["message_list", "status_headings", "attributes", "title_ids", "loop"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "themes/contrib/bootstrap_barrio/templates/misc/status-messages--alerts.html.twig";
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
        return array (  169 => 92,  160 => 88,  146 => 87,  139 => 84,  133 => 82,  130 => 81,  113 => 80,  108 => 78,  104 => 77,  101 => 76,  97 => 74,  95 => 73,  92 => 72,  90 => 71,  87 => 70,  85 => 69,  82 => 68,  80 => 67,  73 => 66,  71 => 59,  69 => 58,  67 => 55,  66 => 54,  65 => 53,  64 => 52,  63 => 45,  61 => 44,  57 => 43,  39 => 28,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/contrib/bootstrap_barrio/templates/misc/status-messages--alerts.html.twig", "/var/www/html/themes/contrib/bootstrap_barrio/templates/misc/status-messages--alerts.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 43, "set" => 45, "if" => 67);
        static $filters = array("escape" => 28, "without" => 66);
        static $functions = array("attach_library" => 28);

        try {
            $this->sandbox->checkSecurity(
                ['for', 'set', 'if'],
                ['escape', 'without'],
                ['attach_library']
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
