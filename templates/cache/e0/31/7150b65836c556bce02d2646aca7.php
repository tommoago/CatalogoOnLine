<?php

/* insertProductForm.phtml */
class __TwigTemplate_e0317150b65836c556bce02d2646aca7 extends Twig_Template
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
        <form action=\"insertProduct.php\" method=\"post\" style=\"padding-left: 270px;\">
            <p>Name</p> <input type=\"text\" name=\"name\"/><br>

            <p>Description</p><input type=\"text\" name=\"descr\"/><br>

            <p>New</p><input type=\"checkbox\" name=\"new\" /><br>

            <p>Offer</p><input type=\"checkbox\" name=\"offer\" /><br>

            <p>Evidence</p><input type=\"checkbox\" name=\"evidence\" /><br>

            <p>Wholesale Price</p><input type=\"text\" name=\"w_price\"/><br>

            <p>Retail Price</p><input type=\"text\" name=\"r_price\"/><br>

            <p>Super Price</p><input type=\"text\" name=\"s_price\"/><br>

            <p>Purchase Price</p><input type=\"text\" name=\"p_price\"/><br>

            <p>Cod</p><input type=\"text\" name=\"cod\"/><br>

            <p>Barcode</p><input type=\"text\" name=\"barcode\"/><br>

            <p>Single Qty</p><input type=\"text\" name=\"s_qty\"/><br>

            <p>pack Qty</p><input type=\"text\" name=\"p_qty\"/><br>

            <p>Cardboard Qty</p><input type=\"text\" name=\"c_qty\"/><br>

            <p>Categoy</p>

            <select name=\"cat_id\">
                ";
        // line 40
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["cats"]) ? $context["cats"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["cat"]) {
            // line 41
            echo "                <option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["cat"]) ? $context["cat"] : null), "id"), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["cat"]) ? $context["cat"] : null), "name"), "html", null, true);
            echo "</option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cat'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 43
        echo "            </select>

            <input type=\"submit\" value=\"invio\"/>

        </form>
    </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "insertProductForm.phtml";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 43,  64 => 41,  60 => 40,  19 => 1,);
    }
}
