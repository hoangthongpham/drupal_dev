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

/* modules/contrib/commerce/templates/commerce-dashboard-metrics-item.html.twig */
class __TwigTemplate_0c51bc29dabefc8222e0ec99f3026ba0 extends \Twig\Template
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
        // line 2
        $context["classes"] = [0 => "metrics-item"];
        // line 7
        $context["metric_value_classes"] = [0 => "metrics-item__value"];
        // line 11
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 11), 11, $this->source), "html", null, true);
        echo ">
  <span class=\"metrics-item__icon\"></span>
  <div class=\"metrics-item__data\">
    <h5 class=\"metrics-item__label\">";
        // line 14
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 14, $this->source), "html", null, true);
        echo "</h5>
    ";
        // line 15
        if (($context["values"] ?? null)) {
            // line 16
            echo "      ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["values"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["value"]) {
                // line 17
                echo "        <span";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $this->extensions['Drupal\Core\Template\TwigExtension']->createAttribute($this->sandbox->ensureToStringAllowed(($context["metric_value_attributes"] ?? null), 17, $this->source)), "addClass", [0 => ($context["metric_value_classes"] ?? null)], "method", false, false, true, 17), 17, $this->source), "html", null, true);
                echo ">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["value"], 17, $this->source), "html", null, true);
                echo "</span>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 19
            echo "    ";
        } else {
            // line 20
            echo "      <span class=\"metrics-item__value\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("-"));
            echo "</span>
    ";
        }
        // line 22
        echo "  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/contrib/commerce/templates/commerce-dashboard-metrics-item.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  81 => 22,  75 => 20,  72 => 19,  61 => 17,  56 => 16,  54 => 15,  50 => 14,  43 => 11,  41 => 7,  39 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/commerce/templates/commerce-dashboard-metrics-item.html.twig", "/var/www/html/modules/contrib/commerce/templates/commerce-dashboard-metrics-item.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 2, "if" => 15, "for" => 16);
        static $filters = array("escape" => 11, "t" => 20);
        static $functions = array("create_attribute" => 17);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'for'],
                ['escape', 't'],
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
