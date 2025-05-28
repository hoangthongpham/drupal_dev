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

/* modules/contrib/commerce/templates/commerce-dashboard-inbox.html.twig */
class __TwigTemplate_5d1473e406627c1cb4faeace18394077 extends \Twig\Template
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
        echo "<div class=\"commerce-dashboard--inbox\">
  <div class=\"inbox-header\">
    <h2 class=\"inbox-header__title\">";
        // line 3
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Inbox"));
        echo "</h2>
    ";
        // line 4
        if (($context["unread_text"] ?? null)) {
            // line 5
            echo "      <h4 class=\"inbox-header__unread-text\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["unread_text"] ?? null), 5, $this->source), "html", null, true);
            echo "</h4>
    ";
        }
        // line 7
        echo "  </div>
  <div class=\"inbox-message--wrapper card\">
  ";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["messages"] ?? null));
        foreach ($context['_seq'] as $context["id"] => $context["message"]) {
            // line 10
            echo "    <div class=\"inbox-message ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["message"], "state", [], "any", false, false, true, 10), 10, $this->source)), "html", null, true);
            echo "\" data-message-id=\"";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["message"], "id", [], "any", false, false, true, 10), 10, $this->source), "html", null, true);
            echo "\">
      <div class=\"inbox-message__status\">";
            // line 11
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["message"], "time_ago", [], "any", false, false, true, 11), 11, $this->source), "html", null, true);
            echo "<button type=\"button\" class=\"close\" aria-label=\"Close\"></button></div>
      <h6 class=\"inbox-message__subject\">";
            // line 12
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["message"], "subject", [], "any", false, false, true, 12), 12, $this->source), "html", null, true);
            echo "</h6>
      <div class=\"inbox-message__message\">";
            // line 13
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["message"], "message", [], "any", false, false, true, 13), 13, $this->source), "html", null, true);
            echo "</div>
      <div class=\"inbox-message__actions\">
        ";
            // line 15
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["message"], "link", [], "any", false, false, true, 15))) {
                // line 16
                echo "          ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["message"], "link", [], "any", false, false, true, 16), 16, $this->source), "html", null, true);
                echo "
        ";
            }
            // line 18
            echo "        <a class=\"use-ajax message-dismiss action-link--danger\" href=\" ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getPath("commerce.inbox_message.dismiss", ["message_id" => twig_get_attribute($this->env, $this->source, $context["message"], "id", [], "any", false, false, true, 18)]), "html", null, true);
            echo "\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Dismiss"));
            echo " </a>
      </div>
    </div>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['id'], $context['message'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 22
        echo "  ";
        if ( !($context["messages"] ?? null)) {
            // line 23
            echo "    <div class=\"inbox-message__empty\">
      ";
            // line 24
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("No messages at the moment."));
            echo "
    </div>
  ";
        }
        // line 27
        echo "  </div>
  <div class=\"inbox-footer--wrapper\">
    <div class=\"inbox-footer\">
      <h5 class=\"inbox-footer__subject\">";
        // line 30
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Get the most out of Drupal Commerce."));
        echo "</h5>
      <div class=\"inbox-footer__message\">
        ";
        // line 32
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Learn how in the <a href=\"@docs\" target=\"_blank\">project documentation</a> and community support channels, or <a href=\"@support\" target=\"_blank\">hire the maintainers</a> for professional support or development.", ["@docs" => "https://docs.drupalcommerce.org/commerce2/user-guide", "@support" => "https://www.centarro.io/drupal-commerce/development-services"]));
        echo "
      </div>
    </div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/contrib/commerce/templates/commerce-dashboard-inbox.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  126 => 32,  121 => 30,  116 => 27,  110 => 24,  107 => 23,  104 => 22,  91 => 18,  85 => 16,  83 => 15,  78 => 13,  74 => 12,  70 => 11,  63 => 10,  59 => 9,  55 => 7,  49 => 5,  47 => 4,  43 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/commerce/templates/commerce-dashboard-inbox.html.twig", "/var/www/html/modules/contrib/commerce/templates/commerce-dashboard-inbox.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 4, "for" => 9);
        static $filters = array("t" => 3, "escape" => 5, "clean_class" => 10);
        static $functions = array("path" => 18);

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
                ['t', 'escape', 'clean_class'],
                ['path']
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
