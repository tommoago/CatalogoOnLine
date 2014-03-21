<?php

class Cart
{

    private $products;
    private $tot;
    public $id;
    public $ide;
    public $prev;

    function __construct()
    {
        $this->tot = 0;
        $this->products = array();
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function getCurrentProducts()
    {
        foreach ($this->products as $key => $row)
            if (array_key_exists('old', $row))
                unset($this->products[$key]);
        return $this->products;
    }

    public function getTot()
    {
        return $this->tot;
    }

    public function addProduct($prod)
    {
        $bool = false;

        foreach ($this->products as &$row)
            if ($row['id'] == $prod['id']) {
                $row['qty'] += $prod['qty'];
                if (array_key_exists('old', $prod))
                    $row['old'] = $prod['old'];
                $bool = true;
            }

        if (!$bool)
            $this->products[] = $prod;

        $this->calculateTotal();
    }

    public function update($prod)
    {
        foreach ($this->products as &$row)
            if ($row['id'] == $prod['id']) {
                $row['qty'] = $prod['qty'];
            }

        $this->calculateTotal();
    }

    public function removeProduct($prod_id)
    {
        foreach ($this->products as $key => $row)
            if ($row['id'] == $prod_id)
                unset($this->products[$key]);

        $this->calculateTotal();
    }

    public function emptyCart()
    {
        $this->products = array();
        $this->id = null;
        $this->ide = null;
        $this->prev = null;
    }

    private function calculateTotal()
    {
        $this->tot = 0;
        foreach ($this->products as $row)
            if (!array_key_exists('old', $row))
                $this->tot += $row['discount_price'] * $row['qty'];
    }

}

?>
