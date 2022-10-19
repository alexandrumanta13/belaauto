<?php
/**
* Clasa Compare
*/
 
/**
* Clasa Compare contine metodele specifice produselor pentru comparatie.
* Ea stocheaza produsele pentru comparatie si ii atribuie un id unic generat prin functia
* uniqid() ce este stocat atat in baza de date cat si intr-un 
* cookie cu valabilitatea 1 saptamana. Orice modificare in lista se 
* salveaza in baza de date si se prelungeste valabilitatea 
* cookie-ului. Ea include metodele de adaugare produse, modificare,
* stergere produse, precum si stergerea produselor in momentul in care
* se plaseaza comanda.
*
* @package      classes
* @author   	Alexandru Manta <alexandru.manta@hotmail.com>
* @version  	Version: 1.0
* @access   	public
*/
class Compare extends Common{
 
    /**
    * Tabela cosurilor
    *
    * @var      string
    * @access   public
    **/
    static $table = "compare";
 
    /**
    * Campurile protejate pentru operatii de actualizare
    *
    * @var      array
    * @access   protected
    **/
    protected $protected_fields = array('id');
 
    /**
    * Vectorul de produse din comparatie
    *
    * @var      array
    * @access   public
    **/
    public $items = array();
 
    /**
    * Numarul de produse fizice
    *
    * @var      int
    * @access   protected
    **/
    public $num_items = 0;
 
    /**
    * Numarul de produse diferite
    *
    * @var      int
    * @access   protected
    **/
    public $num_unique = 0;
     
    /**
    * Constructor - creeaza conexiunea cu baza de date si verifica daca
    * exista deja produse create. Daca da, va popula cu produsele 
    * existente, altfel va crea si va seta cookie-ul cu
    * valabilitatea de o saptamana.
    *
    * @access   public
    */
    public function __construct(){
        $this->link = Database::getInstance();
        if ((isset($_SESSION['compare_id'])) and ($this->compareExists($_SESSION['compare_id']))){
            $this->id = $_SESSION['compare_id'];
        } elseif ((isset($_COOKIE['compare'])) and ($this->compareExists($_COOKIE['compare']))){
            $this->id = $_COOKIE['compare'];
            $_SESSION['compare_id'] = $this->id;        
        } else{
 
            $this->id = uniqid();
            setcookie('compare',$this->id,time()+3600*24*7);
            $_SESSION['compare_id'] = $this->id;

            $query = "INSERT INTO " . self::$table . "(id,date_modified,products) VALUES ('" . $this->id . "', '" . date('Y-m-d H:i:s') . "', '" . serialize($this->items) . "')";
            $this->link->execute($query);
           
        }
        $this->fillCompare();
    }
     
    /**
    * Functia verifica daca exista produse cu id-ul setat in variabila de
    * sesiune sau in cookie.
    *
    * @param    string      ID-ul produselor ce se verifica
    * @return   boolean     Returneaza adevarat daca exista, fals altfel 
    * @access   public
    */
    public function compareExists($fav_id){
        $query = "SELECT id FROM " . self::$table . " WHERE id = '" . $fav_id . "' LIMIT 0,1";
        $result = $this->link->execute($query);
        if ($row = $this->link->getObject($result)){
            return true;    
        } else{
            return false;
        }
    }
     
    /**
    * Functia adauga un produs in lista, cu cantitatea specificata de
    * parametru $qty. Aceasta are valoare implicita 1.
    *
    * @param    object      Produsul ce se adauga in favorite
    * @param    int         Cantitatea produsului adaugat
    * @access   public
    */
    public function addItem($product, $qty=1){
        if (in_array($product->id,array_keys($this->items))){
            $this->items[$product->id] = $qty;
        } else{
            $this->items[$product->id]=$qty;
            $this->num_unique++;
        }
        $this->num_items = $qty;
        $this->update(array('products'=>serialize($this->items),'date_modified'=>date('Y-m-d H:i:s')));
        setcookie('compare',$this->id,time()+3600*24*7);
    }

    /**
    * Functia update() actualizeaza datele din lista.
    *
    * @param    array       Datele ce urmeaza sa fie actualizate
    * @param    int         Numarul de randuri modificate
    * @access   public
    */
    public function update($data){
        if (is_array($data)){
            $query = "UPDATE " . self::$table . " SET ";
            foreach ($data as $key=>$value){
                $this->$key = $value;
                $query .= $key . " = ";
                $query .= (is_numeric($value)) ? $value : "'" . $this->link->escape($value) . "'";
                $query .= ", ";
            }
            $query = substr($query,0,-2);
            $query .= " WHERE id = '" . $this->id . "'";
            $this->link->execute($query);
            return $this->link->getAffected();
        }
    }
     
     
    /**
    * Returneaza numarul de produse fizice
    *
    * @return   int         Numarul produselor fizice din favorite
    * @access   public
    */
    public function getTotal(){
        return $this->num_items;
    }
     
    /**
    * Returneaza numarul de produse distincte
    *
    * @return   int         Numarul produselor distincte din favorite
    * @access   public
    */
    public function getUnique(){
        return $this->num_unique;
    }
     
    /**
    * Populeaza produsele din lista, atunci cand acesta sunt create din datele din
    * sesiune sau cookie.
    *
    * @access   public
    */
    public function fillCompare(){
        $query = "SELECT * FROM " . self::$table . " WHERE id = '" . $this->id . "'";
        $result = $this->link->execute($query);
        if ($compare = $this->link->getObject($result)){
            $this->items = unserialize($compare->products);
            $this->num_unique = count($this->items);
            $sum = 0;
            foreach($this->items as $qty){
                $sum += $qty;
            }
            $this->num_items = $sum;
        }
    }
     
    /**
    * Sterge un produs din lista de comparatie
    *
    * @param    int     ID-ul produsului ce va fi sters
    * @access   public
    */
    public function delete($id){
        unset($this->items[$id]);
        $this->update(array('products'=>serialize($this->items),'date_modified'=>date('Y-m-d H:i:s')));
    }
     
    /**
    * Sterge produsele din baza de date si din cookie, atunci cand
    * o comanda este efectuata
    *
    * @return   int         Numarul de randuri modificate
    * @access   public
    */
    public function deleteCompare(){
        $query = "DELETE FROM " . self::$table . " WHERE id = '" . $this->id . "'";
        $this->link->execute($query);
        $affected = $this->link->getAffected();
        if ($affected == 1){
            setcookie('compare','',time()-3600);
            unset($_SESSION['comapre_id']);
        }
        return $affected;
    }
}
?>