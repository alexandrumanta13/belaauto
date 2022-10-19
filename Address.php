<?php 
/**
* Clasa Address
*/
 
/**
* Clasa Address contine toate metodele specifice adreselor.
* Deoarece toate metodele comune sunt implementate in clasa
* abstracta Common sau in clasa Database, ea va defini doar
* metodele speciale specifice adreselor, selectarea tuturor 
* adreselor unui utilizator.
*
* @package      classes
* @author       Bogdan Florea <bogdan.florea24@yahoo.com>
* @version      Version: 1.2
* @access       public
* @copyright    2013 - 2014 Bogdan Florea
*/
class Address extends Common{
    /**
    * Tabela adreselor
    *
    * @var      string
    * @access   public
    **/
    static $table = "address";
 
    /**
    * Campurile protejate pentru operatii de actualizare
    *
    * @var      array
    * @access   protected
    **/
    protected $protected_fields = array('id');
 
    /**
    * Constructor - creeaza conexiunea cu baza de date si, in cazul
    * in care este furnizat un id, populeaza obiectul cu datele din
    * baza de date
    *
    * @param    mixed   ID-ul adresei (int sau NULL)
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
    * Extrage toate adresele unui utilizator
    *
    * @param    int         ID-ul utilizatorului
    * @return   array       Vectorul cu adrese
    * @access   public
    */
    static function AllAddresses($user_id){
        if (!$results = Database::table(static::$table)->select()->where('user_id',$user_id)->get()){
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
}
?>