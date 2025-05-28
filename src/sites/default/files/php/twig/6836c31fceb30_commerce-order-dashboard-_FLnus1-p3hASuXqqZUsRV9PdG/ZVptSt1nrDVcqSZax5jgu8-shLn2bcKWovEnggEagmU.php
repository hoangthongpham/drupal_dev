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

/* modules/contrib/commerce/modules/order/templates/commerce-order-dashboard-metrics-form.html.twig */
class __TwigTemplate_2f309fe4a239635784704da98299f1de extends \Twig\Template
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
        // line 12
        echo "<div class=\"commerce-dashboard__actions\">
  <div class=\"commerce-dashboard__periods\">
    ";
        // line 14
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "periods", [], "any", false, false, true, 14), 14, $this->source), "html", null, true);
        echo "
  </div>
  ";
        // line 16
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "refresh", [], "any", false, false, true, 16))) {
            // line 17
            echo "    <div class=\"commerce-dashboard__refresh\">
      ";
            // line 18
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "refresh", [], "any", false, false, true, 18), "button", [], "any", false, false, true, 18), 18, $this->source), "html", null, true);
            echo "
      <span>";
            // line 19
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "refresh", [], "any", false, false, true, 19), "refreshed", [], "any", false, false, true, 19), 19, $this->source), "html", null, true);
            echo "</span>
    </div>
  ";
        }
        // line 22
        echo "</div>
<div class=\"commerce-dashboard__metrics card\">
    <div class=\"metrics__actions\">
      ";
        // line 25
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "filters", [], "any", false, false, true, 25), 25, $this->source), "html", null, true);
        echo "
    </div>
    <div class=\"metrics\">
      ";
        // line 28
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "metrics", [], "any", false, false, true, 28), 28, $this->source), "html", null, true);
        echo "
    </div>
    <div class=\"metrics__tables\">
      ";
        // line 31
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter($this->sandbox->ensureToStringAllowed(($context["form"] ?? null), 31, $this->source), "periods", "metrics", "filters", "refresh"), "html", null, true);
        echo "
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/contrib/commerce/modules/order/templates/commerce-order-dashboard-metrics-form.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 31,  74 => 28,  68 => 25,  63 => 22,  57 => 19,  53 => 18,  50 => 17,  48 => 16,  43 => 14,  39 => 12,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/commerce/modules/order/templates/commerce-order-dashboard-metrics-form.html.twig", "/var/www/html/modules/contrib/commerce/modules/order/templates/commerce-order-dashboard-metrics-form.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 16);
        static $filters = array("escape" => 14, "without" => 31);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape', 'without'],
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
