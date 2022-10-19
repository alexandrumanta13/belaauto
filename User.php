<?php 
/**
* Clasa User
*/

/**
* Clasa User contine toate metodele specifice utilizatorilor.
* Deoarece toate metodele comune sunt implementate in clasa
* abstracta Common sau in clasa Database, ea va defini doar
* metodele speciale specifice utilizatorilor, cum ar fi 
* autentificarea, verificarea autentificarii sau delogarea.
*
* @package  	classes
* @author   	Alexandru Manta <alexandru.manta@hotmail.com>
* @version  	Version: 1.0
* @access   	public
*/
class User extends Common{

	/**
	* Tabela utilizatorilor
	*
	* @var 		string
	* @access 	public
	**/
	static $table = "users";

	/**
	 * Campul de ordonare predefinit
	 *
	 * @var 		string
	 * @access 	public
	 **/
	static $order_field = "email";

	/**
	* Campurile protejate pentru operatii de actualizare
	*
	* @var 		array
	* @access 	protected
	**/

	protected $protected_fields = array('id');
	
	/**
    * Constructor - creeaza conexiunea cu baza de date si, in cazul
    * in care este furnizat un id, populeaza obiectul cu datele din
    * baza de date
	*
	* @param 	mixed 	ID-ul categoriei (int sau NULL)
    * @access 	public
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
    * Functia loggedIn() verifica pe baza datelor din sesiune sau din
    * cookie daca utilizatorul este deja logat. Daca da, populeaza 
    * obiectul cu datele din tabela.
	*
    * @return 	boolean		Starea autentificarii
    * @access 	public
    */


	public function loggedIn(){
		if(!isset($_SESSION)) { 
			session_start(); 
		}

		if ((isset($_SESSION['user_id'])) and ($user = $this->find($_SESSION['user_id']))){
			if (strpos($_SERVER['REQUEST_URI'], "admin") !== false && $user->access == 99){
				$_SESSION['user_type'] = "admin";
			}else {
				$_SESSION['user_type'] = "user";
			}
			foreach (get_object_vars($user) as $prop=>$val){
				$this->$prop = $val;
			}
			return true;
		} elseif (isset($_COOKIE['auth'])){
			$token = substr($_COOKIE['auth'],0,32);
			$email = urldecode(substr($_COOKIE['auth'],32));
			if ($user = $this->select()->where('token',$token)->where('email',$email)->first()){
				$_SESSION['user_id'] = $user->id;
				foreach (get_object_vars($user) as $prop=>$val){
					$this->$prop = $val;
				}
				return true;
			}else{
				return false;
			}	 
		}else{
			return false;
		}
	}
	
	/**
    * Functia login() autentifica utilizatorul in aplicatie. Daca este
    * setat parametrul $persistent, atunci se creaza un cookie cu datele
    * de autentificare. De asemenea, functia populeaza obiectul curent
    * cu datele din tabela.
	*
    * @param 	string 		Email-ul utilizatorului
    * @param 	string 		Parola utilizatorului
    * @param 	boolean		Optiunea de mentinere a autentificarii
    * @return 	boolean		Starea autentificarii
    * @access 	public
    */

	public function login($email, $password, $persistent = false){
		if ($check = $this->select()->where('email', $email)->first()){
			if (password_verify($password, $check->password)){
				
				$_SESSION['user_id'] = $check->id;
				$user = new User($check->id);
				$user->date_last_visit = date('Y-m-d H:i:s');
	
				if ($persistent || $persistent == 1){
					$rand = md5(uniqid('',true));
					$user->token=$rand;
					setcookie('auth',$rand.$check->email,time()+3600*24*7);
				}
				$user->save();
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	/**
    * Functia checkEmail() verfica daca emailul exista deja in baza
	*
    * @param 	string 		Email-ul utilizatorului
    * @access 	public
    */

	public function checkEmail($email){
		
		$query = "SELECT * FROM " . self::$table . " WHERE " . self::$order_field . " = '{$email}'";
		$result = $this->link->execute($query);
		if ($this->link->getCount($result) > 0){
			return true;
		} else {
			return false;
		}
	}

	/**
    * Functia getUserByEmail() returneaza utilizatorul pe baza email-ului
	*
    * @param 	string 		Email-ul utilizatorului
    * @access 	public
    */

	public function getUserByEmail($email){
		$query = "SELECT * FROM " . self::$table . " WHERE " . self::$order_field . " = '{$email}'";
		$result = $this->link->execute($query);
		$user = $this->link->getObject($result);
			$users [] = $user;
		return $users;
	}

	/**
    * Delogeaza utilizatorul prin distrugerea datelor din sesiune si 
    * din cookie.
	*
    * @access 	public
    */
	static function Logout(){
		$helper = array_keys($_SESSION);
		foreach ($helper as $key){
			unset($_SESSION[$key]);
		}
		unset($_SESSION['user_id']);
		session_destroy();
		setcookie('auth','',time()-3600);
	}

}
?>