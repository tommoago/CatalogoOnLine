<?php

/* list.phtml */
class __TwigTemplate_e31091b40918e86c349ae38f3cd4279c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
        <title></title>
    </head>
    <body>
        <table border='1' style='margin: 50px;'>
            <tr>
                <td>Name</td> 
                <td>Description</td>
                <td>New</td>
                <td>Offer</td>
                <td>Evidence</td>
                <td>Wholesale Price</td>
                <td>Retail Price</td>
                <td>Super Price</td>
                <td>Purchase Price</td>
                <td>Cod</td>
                <td>Barcode</td>
                <td>Single Qty</td>
                <td>Pack Qty</td>
                <td>Cardboard Qty</td>
                <td>Categoy</td>
            </tr>
            ";
        // line 26
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["prods"]) ? $context["prods"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["prod"]) {
            // line 27
            echo "            <tr>
                <td>";
            // line 28
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "name"), "html", null, true);
            echo "</td> 
                <td>";
            // line 29
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "description"), "html", null, true);
            echo "</td>
                <td>";
            // line 30
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "new"), "html", null, true);
            echo "</td>
                <td>";
            // line 31
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "offer"), "html", null, true);
            echo "</td>
                <td>";
            // line 32
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "evidence"), "html", null, true);
            echo "</td>
                <td>";
            // line 33
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "wholesale_price"), "html", null, true);
            echo "</td>
                <td>";
            // line 34
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "retail_price"), "html", null, true);
            echo "</td>
                <td>";
            // line 35
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "super_price"), "html", null, true);
            echo "</td>
                <td>";
            // line 36
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "purchase_price"), "html", null, true);
            echo "</td>
                <td>";
            // line 37
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "cod"), "html", null, true);
            echo "</td>
                <td>";
            // line 38
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "barcode"), "html", null, true);
            echo "</td>
                <td>";
            // line 39
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "single_qty"), "html", null, true);
            echo "</td>
                <td>";
            // line 40
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "pack_qty"), "html", null, true);
            echo "</td>
                <td>";
            // line 41
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "cardboard_qty"), "html", null, true);
            echo "</td>
                <td>";
            // line 42
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "categoy"), "html", null, true);
            echo "</td>
                <td><a href='delete.php?id=";
            // line 43
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "id"), "html", null, true);
            echo "'>elimina</a></td>
                <td><a href='prepareUpdate.php?id=";
            // line 44
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["prod"]) ? $context["prod"] : null), "id"), "html", null, true);
            echo "'>modifica</a></td>
            </tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['prod'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        echo "        </table>
    </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "list.phtml";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  126 => 47,  117 => 44,  113 => 43,  109 => 42,  105 => 41,  101 => 40,  97 => 39,  93 => 38,  89 => 37,  85 => 36,  81 => 35,  77 => 34,  73 => 33,  69 => 32,  65 => 31,  61 => 30,  57 => 29,  53 => 28,  50 => 27,  46 => 26,  19 => 1,);
    }
}
