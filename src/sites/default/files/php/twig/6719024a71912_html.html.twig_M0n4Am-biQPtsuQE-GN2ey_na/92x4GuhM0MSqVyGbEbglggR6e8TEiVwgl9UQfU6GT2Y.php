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

/* themes/mini_store/templates/html/html.html.twig */
class __TwigTemplate_4c19a258eadaaba2695c96ca07d4b161 extends Template
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
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"zxx\" class=\"no-js\">

  <head>
    <!-- Mobile Specific Meta -->
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">
    <meta name=\"description\" content=\"multikart\">
    <meta name=\"keywords\" content=\"multikart\">
    <meta name=\"author\" content=\"multikart\">
    <link rel=\"icon\" href=\"themes/mini_store/public/images/favicon/20.png\" type=\"image/x-icon\">
    <link rel=\"shortcut icon\" href=\"themes/mini_store/public/images/favicon/20.png\" type=\"image/x-icon\">

    <head-placeholder token=\"";
        // line 15
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["placeholder_token"] ?? null), 15, $this->source), "html", null, true);
        echo "\">
    <title>";
        // line 16
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->safeJoin($this->env, $this->sandbox->ensureToStringAllowed(($context["head_title"] ?? null), 16, $this->source), " | "));
        echo "</title>
    <css-placeholder token=\"";
        // line 17
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["placeholder_token"] ?? null), 17, $this->source), "html", null, true);
        echo "\">
    <js-placeholder token=\"";
        // line 18
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["placeholder_token"] ?? null), 18, $this->source), "html", null, true);
        echo "\">
  </head>
  <body class=\"theme-color-28\">
    ";
        // line 21
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["page"] ?? null), 21, $this->source), "html", null, true);
        echo "
    <js-bottom-placeholder token=\"";
        // line 22
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["placeholder_token"] ?? null), 22, $this->source), "html", null, true);
        echo "\">
  <script>
      \$(window).on('load', function () {
          setTimeout(function () {
              \$('#newyear').modal('show');
          }, 2500);
      });
      feather.replace();

      function openSearch() {
          document.getElementById(\"search-overlay\").style.display = \"block\";
      }

      function closeSearch() {
          document.getElementById(\"search-overlay\").style.display = \"none\";
      }


  </script>

  </body>
</html>

";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["placeholder_token", "head_title", "page"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "themes/mini_store/templates/html/html.html.twig";
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
        return array (  77 => 22,  73 => 21,  67 => 18,  63 => 17,  59 => 16,  55 => 15,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/mini_store/templates/html/html.html.twig", "/var/www/html/themes/mini_store/templates/html/html.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 15, "safe_join" => 16);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape', 'safe_join'],
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
