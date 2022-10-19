<?php
/**
* Clasa Favorites
*/
 
/**
* Clasa Favorites contine metodele specifice produselor favorite.
* Ea stocheaza produsele favorite si ii atribuie un id unic generat prin functia
* uniqid() ce este stocat atat in baza de date cat si intr-un 
* cookie cu valabilitatea 1 saptamana. Orice modificare in favorite se 
* salveaza in baza de date si se prelungeste valabilitatea 
* cookie-ului. Ea include metodele de adaugare produse, modificare,
* stergere produse, precum si stergerea produselor favorite in momentul in care
* se plaseaza comanda.
*
* @package      classes
* @author   	Alexandru Manta <alexandru.manta@hotmail.com>
* @version  	Version: 1.0
* @access   	public
*/
class Favorites extends Common{
 
    /**
    * Tabela cosurilor
    *
    * @var      string
    * @access   public
    **/
    static $table = "favorites";
 
    /**
    * Campurile protejate pentru operatii de actualizare
    *
    * @var      array
    * @access   protected
    **/
    protected $protected_fields = array('id');
 
    /**
    * Vectorul de produse din favorite
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
    * exista deja produse favorite create. Daca da, va popula cu produsele 
    * existente, altfel va crea si va seta cookie-ul cu
    * valabilitatea de o saptamana.
    *
    * @access   public
    */
    public function __construct(){
        $this->link = Database::getInstance();
        if ((isset($_SESSION['fav_id'])) and ($this->favExists($_SESSION['fav_id']))){
            $this->id = $_SESSION['fav_id'];
        } elseif ((isset($_COOKIE['favorites'])) and ($this->favExists($_COOKIE['favorites']))){
            $this->id = $_COOKIE['favorites'];
            $_SESSION['fav_id'] = $this->id;        
        } else{
 
            $this->id = uniqid();
            setcookie('favorites',$this->id,time()+3600*24*7);
            $_SESSION['fav_id'] = $this->id;

            $query = "INSERT INTO " . self::$table . "(id,date_modified,products) VALUES ('" . $this->id . "', '" . date('Y-m-d H:i:s') . "', '" . serialize($this->items) . "')";
            $this->link->execute($query);
           
        }
        $this->fillFavorites();
    }
     
    /**
    * Functia verifica daca exista produse favorite cu id-ul setat in variabila de
    * sesiune sau in cookie.
    *
    * @param    string      ID-ul produiselor favorite ce se verifica
    * @return   boolean     Returneaza adevarat daca exista, fals altfel 
    * @access   public
    */
    public function favExists($fav_id){
        $query = "SELECT id FROM " . self::$table . " WHERE id = '" . $fav_id . "' LIMIT 0,1";
        $result = $this->link->execute($query);
        if ($row = $this->link->getObject($result)){
            return true;    
        } else{
            return false;
        }
    }
     
    /**
    * Functia adauga un produs in favorite, cu cantitatea specificata de
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
        setcookie('favorites',$this->id,time()+3600*24*7);
    }

    /**
    * Functia update() actualizeaza datele din favorite.
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
    * Populeaza produsele favorite, atunci cand acesta sunt create din datele din
    * sesiune sau cookie.
    *
    * @access   public
    */
    public function fillFavorites(){
        $query = "SELECT * FROM " . self::$table . " WHERE id = '" . $this->id . "'";
        $result = $this->link->execute($query);
        if ($favorite = $this->link->getObject($result)){
            $this->items = unserialize($favorite->products);
            $this->num_unique = count($this->items);
            $sum = 0;
            foreach($this->items as $qty){
                $sum += $qty;
            }
            $this->num_items = $sum;
        }
    }
     
    /**
    * Sterge un produs din favorite
    *
    * @param    int     ID-ul produsului ce va fi sters
    * @access   public
    */
    public function delete($id){
        unset($this->items[$id]);
        $this->update(array('products'=>serialize($this->items),'date_modified'=>date('Y-m-d H:i:s')));
    }
     
    /**
    * Sterge produsele favorite din baza de date si din cookie, atunci cand
    * o comanda este efectuata
    *
    * @return   int         Numarul de randuri modificate
    * @access   public
    */
    public function deleteFavorites(){
        $query = "DELETE FROM " . self::$table . " WHERE id = '" . $this->id . "'";
        $this->link->execute($query);
        $affected = $this->link->getAffected();
        if ($affected == 1){
            setcookie('favorites','',time()-3600);
            unset($_SESSION['fav_id']);
        }
        return $affected;
    }
}
?>