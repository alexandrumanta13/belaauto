<?php
/**
 * Clasa Database
 */

/**
 * Clasa Database realizeaza conexiunea cu baza de date si implemeteaza
 * functii specifice interactiunii intre PHP si baza de date
 *
 * Clasa Database implementeaza functionalitatile de executie si
 * inregistrare a interogarilor. Clasa ofera atat posibilitatea
 * de a rula o interogare particulara, cat si o interfata Fluent
 * pentru cele mai frecvente interogari de selectie a datelor
 * Interfata Fluent va fi folosita de clasele specifice aplicatiei
 *
 * @package      classes
 * @author       Alexandru Manta <alexandru.manta@hotmail.com>
 * @version      Version: 1.0
 * @access       public
 */
class Database
{

    /**
     * Instanta bazei de date
     *
     * @var     mysqli
     * @access  private
     */
    private static $__instance = null;

    /**
     * Conexiunea cu baza de date
     *
     * @var      mysqli
     * @access   private
     **/
    private $__link;

    /**
     * Rezultatul ultimei interogari
     *
     * @var      mysqli_result
     * @access   private
     **/

    private $__result;

    /**
     * Setari pentru inregistrarea interogarilor non-Fluent
     *
     * @var      int
     * @access   private
     **/

    private $__debug = 0;

    /**
     * Datele ce vor fi parsate interogarii SQL
     *
     * @var      array
     * @access   private
     **/

    private $__binds = array();

    /**
     * Tipurile datelor ce vor fi parsate interogarii SQL
     *
     * @var      string
     * @access   private
     **/

    private $__bind_types = "";

    /**
     * Constructor - creeaza conexiunea cu baza de date
     * si returneaza variabila de conexiune
     *
     * @return   mysqli
     * @access   public
     */

    public function __construct()
    {
        require_once __DIR__ . "/config.php";

        $this->link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->link->connect_error) {
            throw new Exception("Eroare conexiune", "100");
        }
        if (DEBUG) {
            $this->debug = 1;
        }
    }

    /**
     * Obtine instanta bazei de date
     *
     * @return   mixed
     * @access   public
     */

    public static function getInstance()
    {
        if (!self::$__instance) {
            self::$__instance = new Database();
        }

        return self::$__instance;
    }

    /**
     * Returneaza conexiunea curenta
     *
     * @return    private
     * @access    public
     *
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Pregateste interogarea parsata prin interfata Fluent
     *
     * @param    string      Interogarea MySQL in format prepared statements
     * @return   mysqli_stmt
     * @access   public
     */

    public function prepare($query)
    {
        return $this->getLink()->prepare($query);
    }

    /**
     * Ruleaza interogarile non-Fluent si le inregistreaza in fisierul
     * de log
     *
     * @param    string      Interogarea MySQL
     * @return   mysqli_result
     * @access   public
     */

    public function execute($query)
    {
        $this->result = $this->getLink()->query($query);
        if ($this->debug) {
            $output = date("d.m.Y H:i:s") . " - MySQLi query\n";
            $output .= "\tQuery: " . $query . "\n";
            $output .= "\tResult: ";
            $output .= ($this->getLink()->errno) ? $this->getLink()->error : "Succes";
            $output .= "\n\n";
            $output .= "----------------------------------------------------------------";
            $output .= "\n\n";
            file_put_contents(LOG_FOLDER . "db.log", $output, FILE_APPEND);
        }
        return $this->result;
    }

    /**
     * Realizeaza escaparea textului pentru prevenirea SQL Injection
     * pentru interogarile non-Fluent
     *
     * @param    string      Textul ce urmeaza a fi escapat
     * @return   string      Textul escapat
     * @access   public
     */

    public function escape($text)
    {
        return $this->getLink()->real_escape_string($text);
    }

    /**
     * Returneaza rezultatul ultimei interogari
     *
     * @return   mysqli_result
     * @access   public
     */

    public function getResult()
    {
        return $this->result;
    }

    /**
     * Returneaza numarul de rezultate ale ultimei interogari. Se aplica
     * doar pentru interogari SELECT
     *
     * @param    mysqli_result   Rezultatul ultimului SELECT
     * @return   int             Numarul de rezultate returnat
     * @access   public
     */

    public function getCount($result)
    {
        return $result->num_rows;
    }

    /**
     * Returneaza numarul de randuri afectate de ultima interogare. Se
     * aplica numai pentru interogari INSERT, UPDATE sau DELETE
     *
     * @return   int     Numarul de randuri modificate
     * @access   public
     */

    public function getAffected()
    {
        return $this->getLink()->affected_rows;
    }

    /**
     * Extrage primul rezultat dintr-o interogarea select sub forma unui
     * vector asociativ
     *
     * @param    mysqli_result   Rezultatul ultimului SELECT
     * @return   array           Vectorul asociativ cu datele primului rand
     * @access   public
     */

    public function getAssoc($result)
    {
        return $result->fetch_assoc();
    }

    /**
     * Extrage primul rezultat dintr-o interogarea select sub forma unui
     * obiect
     *
     * @param    mysqli_result   Rezultatul ultimului SELECT
     * @return   object          Obiectul cu datele primului rand
     * @access   public
     */

    public function getObject($result)
    {
        return $result->fetch_object();
    }

    /**
     * Selectarea tabelei pentru interfata Fluent. Functia este folosita
     * si in clasele specifice aplicatiei ca o scurtatura pentru utilizarea
     * interfetei fluent. Ruleaza constructorul clasei Database pentru a
     * realiza conexiunea si reseteaza datele parsate interogarii si tipurile
     * acestora
     *
     * @param    string      Tabele din care se vor selecta datele
     * @return   Database object Obiectul creat din clasa Database
     * @access   public
     */

    public static function table($table)
    {
        if (is_string($table)) {
            $db = new self();
            $db->table = $table;
            $db->binds = array();
            $db->bind_types = "";
            return $db;
        } else {
            throw new Exception("Tabela inexistenta");
        }
    }

    /**
     * Pregateste interogarea SELECT pentru tabela selectata prin functia
     * table()
     *
     * @return   Database object Obiectul creat din clasa Database
     * @access   public
     */

    public function select()
    {
        $this->select = "SELECT * FROM " . $this->table;
        return $this;
    }

    /**
     * Adauga clauza WHERE interogarii SELECT formate prin functia select().
     * Daca aceasta nu a fost creata, va fi apelata functia select() si apoi
     * se va adauga clauza WHERE. Functia poate fi apelata inlantuit pentru
     * adaugarea de clauze multiple, grupate in mod implicit prin operatorul
     * AND (si logic)
     *
     * @param    string      Campul ce va fi testat in clauza WHERE
     * @param    string      Operatorul de test. Camp optional. In
     * cazul in care nu se specifica, va fi utilizat operatorul =
     * @param    string      Valoarea ce se testeaza
     * @param    string      Operatorul folosit pentru gruparea
     * clauzelor multiple. Parametru optional. Valori acceptate: AND sau OR.
     * Valoarea implicita este AND in cazul in care nu se specifica sau este
     * eronat
     * @return   Database object Obiectul creat din clasa Database
     * @access   public
     */

    public function where($field = null, $operator = null, $value = null, $boolean = 'and')
    {
        if (!isset($this->select)) {
            $this->select();
        }

        if (func_num_args() == 2) {
            $value = $operator;
            $operator = '=';
        } elseif (!is_array($field) && !in_array(strtolower($operator), array('=', '!=', '<>', '<', '<=', '>', '>=', 'like', 'is null', 'is not null'))) {
            throw new Exception("Eroare operator");
        }

        if (is_string($field)) {
            $this->field = $field;
            $this->operator = $operator;
            if (in_array(strtolower($boolean), array('and', 'or'))) {
                $this->boolean = $boolean;
            } else {
                // Bad operator, defaults to AND
                $this->boolean = 'and';
            }

            if (!in_array(strtolower($operator), array('like', 'not like'))) {
                $this->value = $value;
            } else {
                $this->value = "%{$value}%";
            }

            $this->binds[] = $this->value;
            if (filter_var($this->value, FILTER_VALIDATE_INT)) {
                $this->bind_types .= "i";
            } elseif (filter_var($this->value, FILTER_VALIDATE_FLOAT)) {
                $this->bind_types .= "d";
            } else {
                $this->bind_types .= "s";
            }

            if (!isset($this->where)) {
                $this->select .= " WHERE {$this->field} {$this->operator} ?";
                $this->where = true;
            } else {
                $this->select .= " {$this->boolean} {$this->field} {$this->operator} ?";
            }
        } elseif (is_array($field)) {
            $this->select .= " WHERE ";

            for ($i = 0; $i < count($field); $i++) {
                $column = $operator = $value = null;

                for ($j = 0; $j < count($field[$i]); $j++) {
                    $column = filter_var($field[$i][0], FILTER_SANITIZE_STRING);
                    $operator = filter_var($field[$i][1]);

                    if ($operator == "LIKE") {
                        $value = "'%" . urldecode(filter_var($field[$i][2], FILTER_SANITIZE_STRING)) . "%'";
                    } else {
                        $value = filter_var($field[$i][2], FILTER_SANITIZE_STRING);
                    }
                }

                if ($i !== count($field) - 1) {
                    $this->select .= "$column $operator $value AND ";
                } elseif ($operator == "LIKE") {
                    $this->select .= "$column $operator $value";
                } else {
                    $this->select .= "$column $operator $value";
                }
            }
            // $this->select .= substr($this->select,0,-3);
        } else {
            throw new Exception("Camp inexistent");
        }

        return $this;
    }

    /**
     * Scuratura pentru adaugarea unei clauze WHERE folosind operatorul OR
     * Utilizeaza functia where() cu urmatorul prototip:
     * where($field, $operator, $value, 'or')
     *
     * @param    string      Campul ce va fi testat in clauza WHERE
     * @param    string      Operatorul de test. Camp optional. In
     * cazul in care nu se specifica, va fi utilizat operatorul =
     * @param    string      Valoarea ce se testeaza
     * @return   Database object Obiectul creat din clasa Database
     * @access   public
     */

    public function orWhere($field, $operator = null, $value = null)
    {
        if (!isset($this->select)) {
            $this->select();
        }
        return $this->where($field, $operator, $value, 'or');
    }

    /**
     * Adaugarea unei clauze WHERE de tipul IS NULL sau IS NOT NULL
     *
     * @param    string      Campul ce va fi testat in clauza WHERE
     * @param    boolean     Specifica daca se va folosi operatorul
     * logic NOT in evaluarea conditiei. Parametru optional. Valoare predefinita:
     * false
     * @param    string      Operatorul folosit pentru gruparea
     * clauzelor multiple. Parametru optional. Valori acceptate: AND sau OR.
     * Valoarea implicita este AND in cazul in care nu se specifica sau este
     * eronat
     * @return   Database object Obiectul creat din clasa Database
     * @access   public
     */

    public function whereNull($field, $not = false, $boolean = 'and')
    {
        if (!isset($this->select)) {
            $this->select();
        }
        if (is_string($field)) {
            $this->field = $field;
            if (in_array(strtolower($boolean), array('and', 'or'))) {
                $this->boolean = $boolean;
            } else {
                // Bad operator, defaults to AND
                $this->boolean = 'and';
            }

            $this->operator = ($not) ? "is null" : "is not null";

            if (!isset($this->where)) {
                $this->select .= " WHERE {$this->field} {$this->operator}";
                $this->where = true;
            } else {
                $this->select .= " {$this->boolean} {$this->field} {$this->operator}";
            }
        } else {
            echo "Bad field name";
        }
        return $this;
    }

    /**
     * Scurtatura pentru adaugarea unei clauze WHERE de tipul IS NULL sau
     * IS NOT NULL folosind operatorul OR. Foloseste functia whereNull()
     * cu urmatorul prototip:
     * whereNull($field, $not, 'or')
     *
     * @param    string      Campul ce va fi testat in clauza WHERE
     * @param    boolean     Specifica daca se va folosi operatorul
     * logic NOT in evaluarea conditiei. Parametru optional. Valoare predefinita:
     * false
     * @param    string      Operatorul folosit pentru gruparea
     * clauzelor multiple. Parametru optional. Valori acceptate: AND sau OR.
     * Valoarea implicita este AND in cazul in care nu se specifica sau este
     * eronat
     * @return   Database object Obiectul creat din clasa Database
     * @access   public
     */

    public function orWhereNull($field, $not = false)
    {
        if (!isset($this->select)) {
            $this->select();
        }
        return $this->whereNull($field, $not, 'or');
    }

    /**
     * Adauga clauza ORDER BY interogarii SELECT. Daca interogarea nu a fost
     * creata, se va rula mai intai functia select()
     *
     * @param    string      Campul dupa care se va face ordonarea
     * @param    string      Directia ordonarii. Parametru optional.
     * Valoare implicita: ASC. Valori acceptate: ASC sau DESC
     * @return   Database object Obiectul creat din clasa Database
     * @access   public
     */

    public function order($field, $order = 'ASC')
    {
        if (!isset($this->select)) {
            $this->select();
        }

        if (is_string($field)) {
            $this->field = $field;
            if ((isset($order)) and (in_array(strtolower($order), array('asc', 'desc')))) {
                $this->order = $order;
            } else {
                // Bad order - default to ASC
                $this->order = 'ASC';
            }
            $this->select .= " ORDER BY {$this->field} {$this->order}";
        } elseif (is_array($field)) {
            $this->select .= " ORDER BY ";
            for ($i = 0; $i < count($field); $i++) // eg. [ [price, asc], [season_id, desc] ]
            {
                $this->field = $field[$i][0];
                $this->order = $field[$i][1];
                if ($i !== count($field) - 1) {
                    $this->select .= "{$this->field} {$this->order}, ";
                } else {
                    $this->select .= " {$this->field} {$this->order}";
                }
            }
        } else {
            throw new Exception("Camp inexistent");
        }
        return $this;
    }

    /**
     * Adauga clauza LIMIT pentru paginare. Functia va cauta parametrul GET page
     * si va ajusta interogarea SELECT pentru a extrage rezultatele paginat.
     * Daca parametrul GET page nu exista sau nu este valid, se va selecta prima
     * pagina. Daca numarul paginii este real, se va rotunji la cel mai apropiat
     * numar intreg.
     *
     * @param    int         Numarul de rezultate afisat pe pagina.
     * Parametru optional. Valoare implicita: 10
     * @return   array   Vectorul rezultatelor
     * @access   public
     */

    public function take($display = 10, $page = 1)
    {

        // die(var_dump($this->select));
        if (!isset($this->select)) {
            $this->select();
        }
        if ($page == -1) {
            return $this->get();
        } else {
            if (isset($_GET['pagina']) and is_numeric($_GET['pagina']) and $_GET['pagina'] > 0) {
                $this->page = (int)$_GET['pagina'];
            } elseif ($page != 1) {
                $this->page = $page;
            } else {
                $this->page = 1;
            }

            $this->display = $display;
            if (isset($_GET['display']) and is_numeric($_GET['display'])) {
                $this->display = (int)$_GET['display'];
            }

            $this->start = ($this->page - 1) * $this->display;

            // if($this->page == 1)
            // {
            //     $this->select .= " LIMIT ?";
            //     $this->binds[] = $this->display;
            // } else if($this->page == 2)
            // {
            //     $this->select .= " LIMIT ? OFFSET ?";
            //     $this->binds[] = $this->display;
            //     $this->binds[] = $this->display;
            // } else {
            //     $this->select .= " LIMIT ? OFFSET ?";
            //     $this->binds[] = $this->display;
            //     $this->binds[] = $this->page * $this->display;
            // }

            $start = $this->start;
            $end = $this->display;

            $this->select .= " LIMIT $start, $end";

            // $this->binds[] = $this->start;
            // $this->binds[] = $this->display;

            // $this->bind_types .= "ii";
            //print_r($this);
            return $this->get();
        }
    }

    /**
     * Ruleaza interogarea SELECT formata de functiile interfetei Fluent
     *
     * @return   array   Vectorul rezultatelor
     * @access   public
     */

    public function get()
    {

        foreach ($this->binds as $key => $value) {
            $bind_data[] =& $this->binds[$key];
        }

        $params[] =& $this->bind_types;

        if ($stmt = $this->prepare($this->select)) {

            /* Adauga parametrii s - string, b - blob, i - int */
            if (!empty($this->binds)) {
                call_user_func_array(array($stmt, 'bind_param'), array_merge($params, $bind_data));
            }
            /* Executa */
            $stmt->execute();
            $result = $stmt->get_result();
            /* Inchide statement */
            $stmt->close();

            if ($this->getCount($result) > 0) {
                $results = array();
                while ($obj = $this->getObject($result)) {
                    $results[] = $obj;
                }
                return $results;
            } else {
                return false;
            }
        } else {
            throw new Exception("Eroare query!");
        }

    }

    /**
     * Scuratura pentru cautarea unui id folosind functia where()
     *
     * @param    int         ID-ul cautat
     * @param    string      Permite specificarea denumirii  * campului ID.
     * Parametru optional. Valoare implicita: id
     * @return   object      rezultatul cautarii
     * @access   public
     */

    public function find($id, $id_field = 'id')
    {
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            return $this->select()->where($id_field, '=', $id)->first();
        } else {
            throw new Exception("ID invalid");
        }
    }

    public function union($table, $method)
    {
        if (!isset($this->select)) {
            $this->select();
        }

        if ($method[0] == 'where') {

        }

        $this->select .= " UNION SELECT * FROM " . $table . " WHERE season_id = 1";

        print_r($this);
        return $this;
    }

    public function orderField($field, $currentSeason, $additionalOrder) // e.g ['price', 'asc']
    {
        if (!isset($this->select)) {
            $this->select();
        }

        if (is_string($field)) {

            if (filter_var($currentSeason, FILTER_VALIDATE_INT)) {
                $this->select .= " ORDER BY FIELD($field,";

                if ($currentSeason == 1) {
                    $this->select .= "$currentSeason, 2, 3)";
                } else {
                    $this->select .= "$currentSeason, 1, 3)";
                }

                if(is_array($additionalOrder))
                {
                    $this->select .= ",";
                    for($i = 0; $i < count($additionalOrder); $i++)
                    {
                        $this->select .= $additionalOrder[$i];
                        $this->select .= " ";
                    }
                } else {
                    throw new Exception("Eroare parametru ordonare aditionala. Tip de valoare asteptat: array");
                }
            } else {
                throw new Exception("Eroare parametru sezon curent. Tip de valoare asteptat: int");
            }
        } else {
            throw new Exception("Eroare parametru tip field. Tip de valoare asteptat: string");
        }
        return $this;
    }

    /**
     * Scuratura pentru returnarea primului rezultat al unui SELECT
     *
     * @return   object      rezultatul cautarii
     * @access   public
     */

    public function first()
    {
        return $this->get()[0];
    }
}
