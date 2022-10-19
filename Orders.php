<?php
/**
* Clasa Order
*/

/**
* Clasa Order contine metodele specifice comenzilor. Ea foloseste
* metodele comune definite in clasa abstracta Common si in clasa 
* Database. In plus, adauga metodele specifice de salvare a produselor
* in tabela produse comandate si de calcul a totalului si preturilor
* individuale a produselor comandate (ce pot fi diferite de cele din 
* tabela produse, ele putand suferi modificari in timp). De asemenea,
* modifica functia All() pentru a filtra comenzile dupa status-ul
* acestora.
*
*/

class Orders extends Common{
   
    /**
    * Tabela comenzilor
    *
    * @var      string
    * @access   public
    **/
    static $table = "orders";
    
    /**
    * Campurile protejate pentru operatii de actualizare
    *
    * @var      array
    * @access   protected
    **/
    protected $protected_fields = array('id');
    
    /**
    * Tabela produselor comandate
    *
    * @var      string
    * @access   private
    **/
    private $product_table = "product_orders";

    /**
    * Campul de ordonare predefinit
    *
    * @var      string
    * @access   public
    **/
    static $order_field = "date_added";

    /**
    * Constructor - creeaza conexiunea cu baza de date si, in cazul
    * in care este furnizat un id, populeaza obiectul cu datele din
    * baza de date
    *
    * @param    mixed   ID-ul categoriei (int sau NULL)
    * @access   public
    */
    public function __construct($id=null){
        $this->link = Database::getInstance();
        if ((is_numeric($id)) and ($id>0) and (filter_var($id, FILTER_VALIDATE_INT))){
            $option = $this->find($id);
            foreach (get_object_vars($option) as $prop=>$val){
                $this->$prop = $val;
            }
        }
    }

    /**
    * Extrage comanda din tabela in functie de id-ul setat
    * in parametrul $value
    *
    * @param    int         Id-ul setat in parametru
    * @return   array       Vectorul cu rezultate
    * @access   public
    */
    public function getOrder($value){
        $query = "SELECT * FROM " . self::$table . " WHERE id = {$value}";
        $result = $this->link->execute($query);
        $order = $this->link->getObject($result);
        $orders [] = $order;
        return $orders;
    }
    
    /**
    * Adauga produsele si detaliile lor in tabela produse comandate
    *
    * @param    array       Produsele comandate si cantitatile
    * @return   boolean     Rezultatul adaugarii
    * @access   public
    */

    public function saveItems($items){
        if (!is_array($items)){
            throw new Exception("Date invalide");
        }
        
        $query = "INSERT INTO " . $this->product_table . " VALUES";
        foreach ($items as $id=>$qty){
            $product = new Product($id);
            $query .= "(NULL, " . $this->id . ", " . $product->id . ", " . $qty . ", " . $product->price . ", '" . $product->model . "'), ";
        }
        $query = substr($query, 0, -2);
      
        $this->link->execute($query);
        if ($this->link->getAffected() > 0){
            return true;
        }
        else{
            return false;
        }
    }
    
    /**
    * Selecteaza produsele pentru o comanda
    *
    * @return   array       Vectorul de obiecte produs
    * @access   public
    */
    public function getProducts(){
        $query = "SELECT * FROM " . $this->product_table . " WHERE order_id = '" . $this->id . "'";
        $result = $this->link->execute($query);
        $products = array();
        while ($prod = $this->link->getObject($result)){
            $products[] = $prod->product_id;
        }
        return $products;
    }

    public function getProductsFromOrder($value){
        $query = "SELECT * FROM " . $this->product_table . " WHERE order_id = {$value}";
        $result = $this->link->execute($query);
        if ($this->link->getCount($result) > 0){
            while ($product = $this->link->getObject($result)){
                $products[]= $product;
            }   
            return $products;
        }
    }

    
    /**
    * Selecteaza cantiatile pentru fiecare produs comandat
    *
    * @return   array       Vectorul de cantitati
    * @access   public
    */
    public function getQuantities(){
        $query = "SELECT * FROM " . $this->product_table . " WHERE order_id = '" . $this->id . "'";
        $result = $this->link->execute($query);
        $q = array();
        while ($prod = $this->link->getObject($result)){
            $q[] = $prod->qnt;
        }
        return $q;
    }



    public function getQuantity($value){
        $query = "SELECT * FROM " . $this->product_table . " WHERE id_product = {$value}";
        $result = $this->link->execute($query);
        if ($this->link->getCount($result) > 0){
            while ($product = $this->link->getObject($result)){
                $products[]= $product;
            }   
            return $products;
        }
    }
    
    
    /**
    * Selecteaza preturile pentru o comanda
    *
    * @return   array       Vectorul de preturi
    * @access   public
    */
    public function getPrices(){
        $query = "SELECT * FROM " . $this->product_table . " WHERE order_id = '" . $this->id . "'";
        $result = $this->link->execute($query);
        $p = array();
        while ($prod = $this->link->getObject($result)){
            $p[] = $prod->price;
        }
        return $p;
    }
    
    /**
    * Calculeaza totalul comenzii
    *
    * @return   float       Pretul total al comenzii
    * @access   public
    */
    public function getTotal(){
        $cantitati = $this->getQuantities();
        $prices = $this->getPrices();
        $total = 0;
        foreach($cantitati as $key=>$value){
            $total += $value * $prices[$key];
        }
        return $total;
    }

    /**
    * Schimba statusul comenzii de catre admin
    *
    * @return   boolean     Rezultatul adaugarii
    * @access   public
    */
    public function updateStatusByAdmin($status){
        $query = "UPDATE " . self::$table . " SET status = '{$status}' WHERE id = '" . $this->id . "'";
        $this->link->execute($query);
        return $this->link->getAffected();
    }

    /**
    * Schimba statusul comenzii in functie de raspunsul platii online
    *
    * @return   boolean     Rezultatul adaugarii
    * @access   public
    */
    public function updateStatus($status, $kupon_id){
        $query = "UPDATE " . self::$table . " SET status = '{$status}' WHERE id = '" . $kupon_id . "'";
        $this->link->execute($query);
        return $this->link->getAffected();
    }
    
    /**
    * Extrage toate rezultatele dintr-o tabela , ordonand rezultatele
    * dupa campul specificat in parametrul $field si in ordinea specificata
    * de parametrul $dir
    *
    * @param    string      Campul folosit pentru ordonare
    * @param    string      Directia (sensul) ordonarii 
    * @return   array       Vectorul cu rezultate
    * @access   public
    */
    static function All($show = "asteptare", $field = "date_added", $dir = "DESC"){
        if (!$results = Database::table(static::$table)->select()->where('status',$show)->order($field, $dir)->get()){
            return array();
        }

        foreach ($results as $result){
            $class = get_called_class();
            $object = new $class;
            foreach (get_object_vars($result) as $prop=>$val){
                $object->$prop = $val;
            }
            $objects[] = $object;
            
        }
        return $objects;
    }

    public function getOrders(){
        $query = "SELECT * FROM " . self::$table . " ORDER BY " . self::$order_field . " ASC";
        $result = $this->link->execute($query);
        if ($this->link->getCount($result) > 0){
            while ($order = $this->link->getObject($result)){
                $orders[]= $order;
            }   
            return $orders;
        }
    }
}

?>