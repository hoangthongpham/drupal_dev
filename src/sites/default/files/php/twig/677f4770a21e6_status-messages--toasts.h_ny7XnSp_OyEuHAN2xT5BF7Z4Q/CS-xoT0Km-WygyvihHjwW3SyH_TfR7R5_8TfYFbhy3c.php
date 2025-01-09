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

/* themes/contrib/bootstrap_barrio/templates/misc/status-messages--toasts.html.twig */
class __TwigTemplate_8bd65924f91e2ab9e77e5501dd51a150 extends Template
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
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("bootstrap_barrio/toast"), "html", null, true);
        echo "

<div class=\"toast-container position-fixed top-0 end-0 p3\" aria-live=\"polite\" aria-atomic=\"true\" data-drupal-messages>

  ";
        // line 32
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["message_list"] ?? null));
        foreach ($context['_seq'] as $context["type"] => $context["messages"]) {
            // line 33
            echo "    ";
            // line 34
            $context["classes"] = ["toast", "fade"];
            // line 39
            echo "    ";
            // line 40
            $context["heading"] = ["status" => t("Status message"), "error" => t("Error message"), "warning" => t("Warning message"), "info" => t("Informative message")];
            // line 47
            echo "    ";
            // line 48
            $context["color"] = ["status" => "#28a745", "warning" => "#dc3545", "error" => "#ffc107", "info" => "#17a2b8"];
            // line 55
            echo "    ";
            // line 56
            $context["role"] = ["status" => "status", "warning" => "alert", "error" => "alert", "info" => "info"];
            // line 63
            echo "    ";
            // line 64
            $context["autohide"] = ["status" => "true", "warning" => "false", "error" => "true", "info" => "false"];
            // line 71
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["messages"]);
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 72
                echo "      <!-- Then put toasts within -->
      <div ";
                // line 73
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter($this->sandbox->ensureToStringAllowed(($context["attributes"] ?? null), 73, $this->source), "role", "aria-label"), "addClass", [($context["classes"] ?? null)], "method", false, false, true, 73), "setAttribute", ["data-drupal-selector", "messages"], "method", false, false, true, 73), "setAttribute", ["role", (($__internal_compile_0 = ($context["role"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[$context["type"]] ?? null) : null)], "method", false, false, true, 73), "setAttribute", ["data-bs-autohide", (($__internal_compile_1 = ($context["autohide"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1[$context["type"]] ?? null) : null)], "method", false, false, true, 73), 73, $this->source), "html", null, true);
                echo " aria-live=\"assertive\" aria-atomic=\"true\" data-delay=\"10000\">
        <div class=\"toast-header\">
          <svg class=\"bd-placeholder-img rounded mr-2\" width=\"20\" height=\"20\" xmlns=\"http://www.w3.org/2000/svg\" preserveaspectratio=\"xMidYMid slice\" focusable=\"false\" role=\"img\">
            <rect ";
                // line 76
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "setAttribute", ["fill", (($__internal_compile_2 = ($context["color"] ?? null)) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2[$context["type"]] ?? null) : null)], "method", false, false, true, 76), 76, $this->source), "html", null, true);
                echo " width=\"100%\" height=\"100%\"></rect>
          </svg>
          <strong class=\"me-auto\">";
                // line 78
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_3 = ($context["status_headings"] ?? null)) && is_array($__internal_compile_3) || $__internal_compile_3 instanceof ArrayAccess ? ($__internal_compile_3[$context["type"]] ?? null) : null), 78, $this->source), "html", null, true);
                echo "</strong>
          <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button>
        </div>
        <div class=\"toast-body\">
          ";
                // line 82
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["message"], 82, $this->source), "html", null, true);
                echo "
        </div>
      </div>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 86
            echo "  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['type'], $context['messages'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 87
        echo "</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["message_list", "attributes", "status_headings"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "themes/contrib/bootstrap_barrio/templates/misc/status-messages--toasts.html.twig";
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
        return array (  112 => 87,  106 => 86,  96 => 82,  89 => 78,  84 => 76,  78 => 73,  75 => 72,  70 => 71,  68 => 64,  66 => 63,  64 => 56,  62 => 55,  60 => 48,  58 => 47,  56 => 40,  54 => 39,  52 => 34,  50 => 33,  46 => 32,  39 => 28,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/contrib/bootstrap_barrio/templates/misc/status-messages--toasts.html.twig", "/var/www/html/themes/contrib/bootstrap_barrio/templates/misc/status-messages--toasts.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 32, "set" => 34);
        static $filters = array("escape" => 28, "t" => 41, "without" => 73);
        static $functions = array("attach_library" => 28);

        try {
            $this->sandbox->checkSecurity(
                ['for', 'set'],
                ['escape', 't', 'without'],
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
