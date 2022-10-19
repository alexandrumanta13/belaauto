<?php	

/**
* Clasa Common
*/



/**
* Clasa abstracta Common implementeaza functionalitatea comuna tuturor
* claselor aplicatiei. Ea contine metodele de salvare, actualizare si
* stergere a datelor si defineste proprietatile comune acestora. Calsa 
* defineste alias-uri pentru functiile de selectie implementate in clasa
* Database. Clasa Common implementeaza interfata IteratorAggregate pentru
* a parcurge proprietatile unui obiect prin intermediul iteratorului 
* generat. Metoda getIterator() este obligatorie acestei interfete.
* Toate clasele aplicatiei vor extinde aceasta clasa.
*
*/

abstract class Common implements IteratorAggregate {

	/**
	* Tabela specifica fiecarei clase copil
	*
	* @var 		string
	* @access 	public
	**/

	static $table;

	/**
	* Campul ID al fiecarei tabele. Valoare implicita: id
	*
	* @var 		string
	* @access 	protected
	**/

	protected $id_field = "id";

	/**
	* Conexiunea cu baza de date
	*
	* @var 		mysqli
	* @access 	protected
	**/

	protected $link = null;

	/**
	* Forderul pentru upload
	*
	* @var 		string
	* @access 	public
	**/

	static $upload_folder = "assets/images/deals";

	/**
	* Vectorul de campuri din baza de date. Iteratorul este asociat acestei variabile
	*
	* @var 		array
	* @access 	protected
	**/

	protected $fields = array();

	/**
	* Campurile protejate pentru operatii de actualizare
	*
	* @var 		array
	* @access 	protected
	**/

	protected $protected_fields = array();

	/**
	* Numarul de pagini, pentru functia de paginare
	*
	* @var 		int
	* @access 	public
	**/

	static $num_pages;

	/**
	* Numarul total de inregistrari, pentru functia de paginare
	*
	* @var 		int
	* @access 	public
	**/

	static $total_results;


	/**
	* Numarul total de inregistrari setat, pentru functia de paginare
	*
	* @var 		int
	* @access 	public
	**/

	static $show_count;

	/**
	* Numarul total de inregistrari din interogare, pentru functia de paginare
	*
	* @var 		int
	* @access 	public
	**/

	static $return_results;


	/**
    * Constructor - creeaza conexiunea cu baza de date
	*
    * @access 	public
    */

	public function __construct() {
		$this->link = new Database();

	}




	/**
    * Functia getIterator este impusa prin interfata IteratorAggregate.
    * Ea returneaza instanta unui iterator extern predefinit sau 
	* sau particular. Ea va genera iteratorul pentru vectorul de campuri.
	*
	* @return 	external iterator
    * @access 	public
    */

	public function getIterator() {
		return new ArrayIterator($this->fields);
	}

    /**
    * Metoda magica __set adauga date in vectorul de campuri
	*
    * @access 	public
    */

	public function __set($prop, $val) {
		$this->fields[$prop] = $val;
	}

    /**
    * Metoda magica __get extrage informatii din vectorul de campuri
	*
	* @return 	mixed
    * @access 	public
    */

	public function __get($prop){
		return $this->fields[$prop];
	}

    /**
    * Functie de test pentru afisarea continutului unui obiect creat
    * prin intermediul metodelo magice
	*
    * @access 	public
    */

	public function show() {
		foreach ($this as $prop=>$val){
			echo "<p>{$prop}: {$val}</p>";
		}
	}

    /**
    * Functia save() va efectua operatiile de inserare si de actualizare
    * a datelor. Ea va prelua informatia din vectorul de campuri si va
    * decide ce operatie trebuie efectuata in functie de prezenta unui id
    * in vectorul de date specific obiectului. Daca id-ul este furnizat,
    * va efectua operatia de UPDATE, altfel va crea o inregistrare noua
    * prin operatia de INSERT
	*
	* @return 	int 	Numarul de randuri afectate
    * @access 	public
    */
	
	
    public function save(){
    	$fields = "";
    	$values = "";
    	$bind_types = "";
    	$bind_data = array();

		// Daca este initializat id-ul inainte de apelul functiei save, voi face update
		// Daca nu, voi face insert
    	if (isset($this->fields[$this->id_field])) {

			// Pregatesc query UPDATE
    		if (($this->fields[$this->id_field] > 0) and (filter_var($this->fields[$this->id_field], FILTER_VALIDATE_INT))){
    			if ($this->find($this->fields[$this->id_field])){
    				$query = "UPDATE " . static::$table . " SET ";
    				foreach ($this as $field=>$value){
    					if (!in_array($field, $this->protected_fields)){
    						$query .= $field . " = ?, ";
    						if (filter_var($value, FILTER_VALIDATE_INT)){
    							$bind_types .= "i";
    						}elseif (filter_var($value, FILTER_VALIDATE_FLOAT)){
    							$bind_types .= "d";	
    						}else{
    							$bind_types .= "s";		
    						}			
    						$bind_data[] = &$this->fields[$field];
    					}
    				}
    				$params[] = &$bind_types;
    				$query = substr($query,0,-2);
    				$query .= " WHERE " . $this->id_field . " = " . $this->fields[$this->id_field]; 
					//echo $query;die();
					//prepared stmt
    				if($stmt = $this->link->prepare($query)){
    					/* Adauga parametrii s - string, b - blob, i - int */
    					call_user_func_array(array($stmt, 'bind_param'), array_merge($params,$bind_data));
    					/* Executa */
    					$stmt -> execute();
					    //echo $stmt->insert_id;die();
    					$affected = $stmt->affected_rows;
						//Inchide statement 
    					$stmt -> close();
    				}else{

    					throw new Exception("Eroare query!");
    				}
    			}else{
    				throw new Exception("ID inexistent");
    			}
    		}else{
    			throw new Exception("Bad ID");
    		}

    		if (($affected == 1) and (LOG)){
				//$this->log();	
    			$user = new User();
    			try{
    				$logged_in = $user->loggedIn();
    				$user = $user->name .' '. $user->last_name; 
    			}
    			catch (Exception $e){
    				echo $e->getMessage();
    				$logged_in = false;
    			}
    			$output = date("d.m.Y H:i:s") . " - Edited id" . $value . " from " . static::$table . " by " . $user . "\n";
    			foreach ($this as $field=>$value){
    				$output .= "\t{$field}: {$value}\n";
    			}
    			$output .= "\n";
    			$output .= "----------------------------------------------------------------";
    			$output .= "\n\n";
    			file_put_contents(LOG_FOLDER . "data.log",$output, FILE_APPEND);		
    		}

    	}else{
			// Pregatesc query INSERT
    		foreach ($this as $field=>$value){
    			$fields .= $field . ", ";
    			$values .= "?, ";
    			if (filter_var($value, FILTER_VALIDATE_INT)){
    				$bind_types .= "i";
    			}elseif (filter_var($value, FILTER_VALIDATE_FLOAT)){
    				$bind_types .= "d";	
    			}else{
    				$bind_types .= "s";		
    			}			
    			$bind_data[] = &$this->fields[$field];
    		}
    		$params[] = &$bind_types;
    		$fields = substr($fields,0,-2);
    		$values = substr($values,0,-2);
    		$query = "INSERT INTO " . static::$table . "({$fields}) VALUES({$values})"; 
			//echo $query;die();
			//prepared stmt
    		if($stmt = $this->link->prepare($query)){
    			/* Adauga parametrii s - string, b - blob, i - int */
			    //$stmt -> bind_param($bind_types, $bind_data);
    			call_user_func_array(array($stmt, 'bind_param'), array_merge($params,$bind_data));
    			/* Executa */
    			$stmt -> execute();
			    //echo $stmt->insert_id;die();
    			$affected = $stmt->affected_rows;
    			if ($affected == 1){
    				$this->id = $stmt->insert_id;
    			}
    			/* Inchide statement */
    			$stmt -> close();
    		}else{
    			throw new Exception("Eroare query!");
    		}
    		if (($affected == 1) and (LOG)){
				$this->log();	
    			// $user = new User();
    			// try{

    			// 	$logged_in = $user->loggedIn();
    			// 	$user = $user->name .' '. $user->last_name; 
    			// }
    			// catch (Exception $e){
    			// 	echo $e->getMessage();
    			// 	$logged_in = false;
    			// }
    			// $output = date("d.m.Y H:i:s") . " - Added id " . $value . " in " . static::$table . " by " . $user . "\n";
    			// foreach ($this as $field=>$value){
    			// 	$output .= "\t{$field}: {$value}\n";
    			// }
    			// $output .= "\n";
    			// $output .= "----------------------------------------------------------------";
    			// $output .= "\n\n";
    			// file_put_contents(LOG_FOLDER . "data.log",$output, FILE_APPEND);		
    		}
    	}



		if (($affected == 1) and (LOG)){
			$this->log();			

		}

    	return $affected;

    }


	/**
    * Functia log() va salva operatiile efectuate intr-un fisier pe disc pentru
    * depanarea aplicatiei. Dezactivarea optiunilor de arhivare se poate face 
    * din fisierul config/setting.php
	*
    * @access 	public
    */

	private function log()
	{
		// $user = new User();
		// try{
		// 	$logged_in = $user->loggedIn();
		// 	$user = $user->name .' '. $user->last_name; 
		// }
		// catch (Exception $e){
		// 	echo $e->getMessage();
		// 	$logged_in = false;
		// }
		$output = date("d.m.Y H:i:s") . " - Added in " . static::$table . " by me \n";
		foreach ($this as $field=>$value){
			$output .= "\t{$field}: {$value}\n";
		}
		$output .= "\n";
		$output .= "----------------------------------------------------------------";
		$output .= "\n\n";
		file_put_contents(LOG_FOLDER . "data.log",$output, FILE_APPEND);
	}

	/**
    * Scurtatura pentru functia select() din clasa Database, apelabila
    * ca metoda a obiectului curent
	*
	* @return 	Database object
    * @access 	public
    */

	public function select() {
		return $this->link->table(static::$table)->select();
	}


	/**
    * Scurtatura pentru functia find() din clasa Database, apelabila
    * ca metoda a obiectului curent
	*
	* @return 	mysqli_result
    * @access 	public
    */

	public function find($id) {
		return $this->link->table(static::$table)->find($id, $this->id_field);
	}

	/**
    * Realizeaza stergerea unei inregistrari din baza de date, in functie
    * de id-ul setat in vectorul de campuri. Pentru o stergere conditionata
    * de alte campuri, se poate rula interogarea DELETE corespunzatoare cu
    * ajutorul functiei execute() din clasa Database
	*
	* @return 	int 	Numarul de randuri afectate
    * @access 	public
    */

	public function delete($value) {

	// 	if (isset($this->fields[$this->id_field])) {

		if(isset($value)){

			// Pregatesc query DELETE

			//if (($this->fields[$this->id_field] > 0) and (filter_var($this->fields[$this->id_field], FILTER_VALIDATE_INT)))

			if (($value > 0) and (filter_var($value, FILTER_VALIDATE_INT))){
				$query = "DELETE FROM " . static::$table . " WHERE " . $this->id_field . " = ?"; 
				//print_r($query);
				//prepared stmt
				if($stmt = $this->link->prepare($query)){

					/* Adauga parametrii s - string, b - blob, i - int */

					$stmt -> bind_param("i", $value);

					/* Executa */
					$stmt -> execute();
					$affected = $stmt->affected_rows;

					/* Inchide statement */
					$stmt -> close();  

					if (($affected == 1) and (LOG)) {

						//$this->log();	
						$user = new User();
						try{

							$logged_in = $user->loggedIn();
							$user = $user->name .' '. $user->last_name; 

						}

						catch (Exception $e){
							echo $e->getMessage();
							$logged_in = false;

						}

						$output = date("d.m.Y H:i:s") . " - Deleted id " . $value . " from " . static::$table . " by " . $user . "\n";
						foreach ($this as $field=>$value){
							$output .= "\t{$field}: {$value}\n";
						}
						$output .= "\n";
						$output .= "----------------------------------------------------------------";
						$output .= "\n\n";
						file_put_contents(LOG_FOLDER . "data.log",$output, FILE_APPEND);		
					}
					return $affected; 
				} else {

					throw new Exception("Eroare query!");
				}
			} else {
				throw new Exception("Bad ID");
			}
		} else {
			throw new Exception("ID inexistent");
		}
	}

	/**
    * Extrage toate rezultatele dintr-o tabela , ordonand rezultatele
    * dupa campul specificat in parametrul $field si in ordinea specificata
    * de parametrul $dir
	*
	* @param 	string 		Campul folosit pentru ordonare
	* @param 	string 		Directia (sensul) ordonarii 
	* @return 	array 		Vectorul cu rezultate
    * @access 	public
    */

	static function All($field = "price", $dir = "ASC"){

		if (!$results = Database::table(static::$table)->select()->order($field, $dir)->get()){
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

		// foreach ($results as $result){
		// 	/*$class = get_called_class();*/
		// 	$object = $result;
		// 	/*foreach (get_object_vars($result) as $prop=>$val){
		// 		$object->$prop = $val;
		// 	}*/
		// 	$objects[] = $object;
			
		// }
		return $objects;

	}


	/**
    * Extrage toate rezultatele dintr-o tabela, ordonand rezultatele
    * dupa campul specificat in parametrul $field si in ordinea specificata
    * de parametrul $dir. Rezultatele vor fi paginate, fiind afisate un
    * numar de rezultate dat de parametrul $show
	*
	* @param 	string 		Campul folosit pentru ordonare
	* @param 	string 		Directia (sensul) ordonarii 
	* @param 	int 		Numarul de rezultate pe pagina
	* @return 	array 		Vectorul cu rezultate
    * @access 	public
    */


	static function Paginate($field = "id", $dir = "DESC", $show = 10){

		if (func_num_args() == 1) {
			$show = $field;
			$field = "id";
		}

		$currentDate = date("F");
		$seasons = ['Winter' => ['September', 'October', 'November', 'December', 'January'], 'Summer' => ['February', 'March', 'April', 'May', 'June', 'July', 'August']];
		$currentSeason = in_array($currentDate, $seasons['Winter']) ? 2 : 1;

		
		
		if (!$results =$output = Database::table(static::$table)->select()->where('price', '>=', 100)->order('season_id', ($currentSeason == 1 ? "ASC" : "DESC"))->take($show)){
			return array();
		}
		
		
		$total =$output = Database::table(static::$table)->select()->where('price', '>=', 100)->order('season_id', ($currentSeason == 1 ? "ASC" : "DESC"))->get();
		
		static::$num_pages = ceil(count($total)/$show);
		
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

	public function mysqli_field_array($query) {
		$result = $this->link->execute($query->select);
		
		$columns = array();
		if ($this->link->getCount($result) > 0){
			$values = $result->fetch_all(MYSQLI_ASSOC);
			if(!empty($values)){
				$columns = array_keys($values[0]);
			}
		}
		
		return $columns;
    }

	
	public function DynamicFiler($field = "id", $dir = "DESC", $show = 20, $values = [], $page = 1){

		$field = "price";
		$dir = "ASC";
		$this->page = $page;
		static::$num_pages = $page;

		$currentDate = date("F");
		$seasons = ['Winter' => ['September', 'October', 'November', 'December', 'January'], 'Summer' => ['February', 'March', 'April', 'May', 'June', 'July', 'August']];
		$currentSeason = in_array($currentDate, $seasons['Winter']) ? 2 : 1;


		if (func_num_args() == 1) {
			$show = $field;
			$field = "id";
		}
		if (in_array("all", $values)) {
			$columnsFirst[] = ['price', '>=', 100];
			$columnsFirst[] = ['season_id', '=', $currentSeason];

			$columnsSecond[] = ['price', '>=', 100];
			$columnsSecond[] = ['season_id', '=', ($currentSeason == 2 ? 1 : 2)];
			$method = ['where', 'season_id', '=', ($currentSeason == 2 ? 1 : 2)];
			//$output = Database::table(static::$table)->select()->where($columnsFirst)->union()->select()->where($columnsSecond)->order('season_id', ($currentSeason == 1 ? "ASC" : "DESC")))->take($show, $this->page);
			//->select()->where($columnsSecond)->order('season_id', ($currentSeason == 1 ? "ASC" : "DESC")))->take($show, $this->page)
			// $output = Database::table(static::$table)->select()->where('price', '>=', 100)->union(static::$table, $method)->take($show, $this->page);
			// $output = Database::table(static::$table)->select()->where('price', '>=', 100)->order('season_id', ($currentSeason == 1 ? "ASC" : "DESC"))->take($show, $this->page);
			$output = Database::table(static::$table)->select()->where('price', '>=', 100)->orderField("season_id", $currentSeason, ['price', 'ASC'])->take($show, $this->page);

			
		}
		else {

			$currentDate = date("F");
			$seasons = ['Winter' => ['September', 'October', 'November', 'December', 'January'], 'Summer' => ['February', 'March', 'April', 'May', 'June', 'July', 'August']];
			$currentSeason = in_array($currentDate, $seasons['Winter']) ? 2 : 1;



			foreach($values as $obj => $val) {
				if ($obj == "pagina") {
					$this->page = (int)$val;
				}
							
				if ($obj == "cauta") {
					$operator = "LIKE";
				} else if ($obj == "pret_minim") {
					$operator = ">=";
				} else if ($obj == "pret_maxim") {
					$operator = "<=";
				} else if ($obj == "categorie") {
					$operator = "=";
				}
				else {
					$operator = "=";
				}
	
				if(array_key_exists($obj, Product::translate_columns()))
				{
					if(!($val == -1))
					{
						$columns[] = [Product::translate_columns()[$obj], $operator, $val];
					}
				}
			}

			$output = Database::table(static::$table)->select()->where($columns, 'and', 'price', '>=', 100)->orderField("season_id", $currentSeason, ['price', 'ASC'])->take($show, $this->page);
		}

		
	
		if (!$results = $output) {
			return array();
		}

		foreach ($results as $result){
			$class = get_called_class();
			$object = new $class($result->id);
			$objects[] = $object->fields;

		}
		// print_r($objects);
		//print_r($objects);
		//print_r($results);
		// foreach ($results as $result){
		// 	/*$class = get_called_class();*/
		// 	$object = $result;
		// 	/*foreach (get_object_vars($result) as $prop=>$val){
		// 		$object->$prop = $val;
		// 	}*/
		// 	$objects[] = $object;
			
		// }
		//print_r($objects);
		
		return $objects;
		
	
       
	
	}


	static function PaginateProducts($field = "id", $dir = "DESC", $show = 20){

		if (func_num_args() == 1) {
			$show = $field;
			$field = "id";
		}



		static::$show_count = $show;


		if(isset($_GET['q']) && $_GET['cat'] == -1) {			
			if (!$results = Database::table(static::$table)->select()->where("search", "like" ,$_GET['q'])->order($field, $dir)->take($show, 1)) {
				return array();
			}
			static::$return_results = count($results);
			static::$total_results = Database::table(static::$table)->select()->where("search", "like" ,$_GET['q'])->order($field, $dir)->get();
			static::$num_pages = ceil(count(static::$total_results)/$show);
		} else if(isset($_GET['q']) && isset($_GET['cat'])) {			
			if (!$results = Database::table(static::$table)->select()->where("search", "like" ,$_GET['q'])->where("search", "like" ,$_GET['cat'])->order($field, $dir)->take($show, 1)) {
				return array();
			}
			static::$return_results = count($results);
			static::$total_results = Database::table(static::$table)->select()->where("search", "like" ,$_GET['q'])->order($field, $dir)->get();
			static::$num_pages = ceil(count(static::$total_results)/$show);
		} else if(isset($_GET['categorie'])) {
			if (!$results = Database::table(static::$table)->select()->where("category_id", "=" ,$_GET['categorie'])->order($field, $dir)->take($show)){
				return array();
			}
			static::$return_results = count($results);
			static::$total_results = Database::table(static::$table)->select()->where("category_id", "=" ,$_GET['categorie'])->get();
			static::$num_pages = ceil(count(static::$total_results)/$show);
		} else {
			
			if (!$results = Database::table(static::$table)->select()->order($field, $dir)->take($show)){
				return array();
			}
		
			
			static::$num_pages = ceil(count(static::All())/$show);
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

	/**
    * Afiseaza link-urile de paginatie, atunci cand se foloseste afisarea
    * paginata. Adauga in mod automat parametrul GET page si verifica 
    * daca acesta are o valoare valida inainte de a crea link-urile.
	*
	* @return 	string 		Codul HTML pentru link-urile de paginatie
    * @access 	public
    */

	static function Links(){
		
		if ((!empty(static::$num_pages)) and (static::$num_pages > 1)) {

			$output = "<ul class=\"pagination\">";
			if (isset($_GET['pagina']) and is_numeric($_GET['pagina']) and $_GET['pagina'] > 0) {
				$page = (int) $_GET['pagina'];

			} else {
				$page = 1;
			}

			if ($page > 1) {
				$prev = $page - 1;
				$output .= "<li><a href=\"" . $_SERVER['PHP_SELF'] . "?pagina=1\">&lsaquo;&lsaquo;</a></li>";
				$output .= "<li><a href=\"" . $_SERVER['PHP_SELF'] . "?pagina=" . $prev . "\">&lsaquo;</a></li>";

			}

			for ($i = 1; $i <= static::$num_pages; $i++) {
				$output .= "<li><a href=\"" . $_SERVER['PHP_SELF'] . "?pagina=" . $i . "\">" . $i . "</a></li>";	
			}

			if ($page < static::$num_pages) {
				$next = $page + 1;
				$output .= "<li><a href=\"" . $_SERVER['PHP_SELF'] . "?pagina=" . $next . "\">&rsaquo;</a></li>";
				$output .= "<li><a href=\"" . $_SERVER['PHP_SELF'] . "?pagina=" . static::$num_pages . "\">&rsaquo;&rsaquo;</a></li>";

			}
			$output .= "</ul>";
			return $output;
		} else {
			return false;
		}
	}

	static function ResultsPagnate() {
		$total = (!isset(static::$total_results) ? count(static::All()) : count(static::$total_results));
		if(!isset(static::$num_pages) || static::$num_pages == 1) {
			return static::$show_count . '-' . $total;
		} else if(static::$return_results < static::$show_count) {
			return $total . '-' . $total;
		} else {
			return static::$show_count * static::$num_pages . '-' . $total;
		}
	}

	static function SummaryLinks(){
		if ((!empty(static::$num_pages)) and (static::$num_pages > 1)) {
			return	"<div class=\"toolbox-item toolbox-show\">
							<label>Rezultate ". static::ResultsPagnate() ." din " . static::$num_pages . " pagini</label>
						</div>";
		} else {
			return false;
		}
	}

	static function ProductsLinks(){
		if ((!empty(static::$num_pages)) and (static::$num_pages > 1)) {

			$output = "<nav class=\"toolbox toolbox-pagination\">";
			$output .=	"<div class=\"toolbox-item toolbox-show\">
							<label>Rezultate ". static::ResultsPagnate() ." din " . static::$num_pages . " pagini</label>
						</div>";
			$output .= "<ul class=\"pagination\">";

			if(isset($_GET['categorie'])) {
				$link = '/new-site/anvelope?categorie='. $_GET['categorie'] .'&pagina=';
			}
			else {
				$link = '/new-site/anvelope?pagina=';
			}

			if (isset($_GET['pagina']) and is_numeric($_GET['pagina']) and $_GET['pagina'] > 0) {
				$page = (int) $_GET['pagina'];

			} else {
				$page = 1;
			}

			if ($page > 1) {
				$prev = $page - 1;
				$output .= "<li class=\"page-item\"><a class=\"page-link page-link-btn\" href=\"". $link ."'1\">&lsaquo;&lsaquo;</a></li>";
				$output .= "<li class=\"page-item\"><a class=\"page-link page-link-btn\" href=\"". $link . $prev . "\">&lsaquo;</a></li>";

			}

			for ($i = 1; $i <= static::$num_pages; $i++) {
			
					$output .= "<li class=\"page-item " . (isset($_GET['pagina']) && $_GET['pagina'] == $i ? 'active' : '') . "\"><a class=\"page-link\" href=\"". $link . $i . "\">" . $i . "</a></li>";	
				
			}

			if ($page < static::$num_pages) {
				$next = $page + 1;
				$output .= "<li class=\"page-item\"><a class=\"page-link page-link-btn\" href=\"". $link . $next . "\">&rsaquo;</a></li>";
				$output .= "<li class=\"page-item\"><a class=\"page-link page-link-btn\" href=\"". $link . static::$num_pages . "\">&rsaquo;&rsaquo;</a></li>";

			}
			$output .= "</ul>";
			$output .= "</nav>";
			return $output;
		} else {
			return false;
		}
	}

	/**
    * Extrage toate rezultatele dintr-o tabela dupa campul specificat in parametrul $id
	*
	* @return 	array 		Vectorul cu rezultate
    * @access 	public
    */

	public function getIt($query){
		// $query="SELECT * FROM ".static::$table." WHERE id=". $id;
		//echo $query;die();
		$result = $this->link->execute($query);
		try{
			if ($this->link->getCount($result) > 0){
				while ($obj = $this->link->getObject($result)){
					$objs [] = $obj;
				}	
				return $objs;
			}
		}catch (Exception $e){
			return $e->getMessage();
		}
	}


	public function getLink()
	{
		return $this->link;
	}
}

?>