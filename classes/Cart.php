<?php

class Cart {

    private $products;
    private $tot;

    function __construct() {
        $this->tot = 0;
        $this->products = array();
    }

    public function getProducts() {
        return $this->products;
    }

    public function getTot() {
        return $this->tot;
    }

    public function addProduct($prod) {
        $bool = false;
        foreach ($this->products as &$row)
            if ($row['id'] == $prod['id']){
                $row['prod']['qty'] += $prod['qty'];
                $bool = true;
            }
            
        if(!$bool)
            $this->products[] =  $prod;
        
        $this->calculateTotal();
    }

    public function removeProduct($prod_id) {
        foreach ($this->products as $key => $row)
            if ($row['prod']['id'] == $prod_id)
                unset($this->products[$key]);
        
        $this->calculateTotal();
    }
    
    public function emptyCart(){
        $this->products = array();
    }

    private function calculateTotal() {
        foreach ($this->products as $row)
            $this->tot += $row['prod']['prezzo'] * $row['prod']['qty'];
    }

}

?>