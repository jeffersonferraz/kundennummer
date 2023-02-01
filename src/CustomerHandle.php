<?php
// Datenbankkonfiguration einbinden
include_once ("config.inc.php");

class CustomerHandle {

    public $connection;


    // Die Datenbankverbindung wird direkt beim Instanzieren der Klasse mithilfe der connectDb()-Methode erstellt
    public function __construct() {
        
        $this->connection = $this->connectDb();

    }

    // Die Verbindung mit der Datenbank wird aufgebaut
    public function connectDb() {

        try {
            $dsn = "mysql:host=" . SERVER . ";dbname=" . DATABASE;
            $connection = new PDO($dsn, USER, PASSWORD);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $connection;
        
        }   catch(PDOException $e) {
        
            echo "Die Datenbankverbindung ist fehlerhaft: " . $e->getMessage();

        }

    }

    // Die Kundennummer wird erstellt
    public function generateId() {

        $midNumbers = [];
        $endNumbers = 0;

        for ($index=0; $index < 7; $index++) {

            array_push($midNumbers, rand(1,9));

            $endNumbers = $endNumbers + $midNumbers[$index];
        }

        $customerId = "KD" . implode("", $midNumbers) . $endNumbers;

        return $customerId;

    }

    // Die neue Premiumkundennummer wird auf die Einzigartigkeit geprüft
    public function checkId($customerId) {

        $stmt = $this->connection->query("SELECT customerId FROM customer WHERE customerId = '$customerId'");
        $result = $stmt->fetch();

        return $result;

    }

    // Die Kundendaten werden mit der geprüften Premiumkundennummer in die Datenbank durch ein SQL-Statement gespeichert 
    public function insert($customerId, $firstName, $lastName) {

        $sql = "INSERT INTO customer (customerId, firstName, lastName) VALUES (?, ?, ?)";
        $stmt= $this->connection->prepare($sql);
        $stmt->execute([$customerId, $firstName, $lastName]);

        // Die Kundendaten werden ausgegeben
        echo "<br>" . " Premiumkunde: " . "<strong>" . $firstName . " " . $lastName . "</strong>";
        echo "<br>" . " Premiumkundennummer: " . "<strong>" . $customerId . "</strong>";

    }

}