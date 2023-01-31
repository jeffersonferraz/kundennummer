<?php
include_once ("config.inc.php");

class CustomerHandle {

    public $connection;

    public function __construct() {
        
        $this->connection = $this->connectDb();

    }

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

    public function generateId() {

        $array = [];
        $endstellen = 0;

        for ($i=0; $i < 7; $i++) {

            array_push($array, rand(1,9));

            $endstellen += $array[$i];
        }

        $kdnummer = "KD" . implode("", $array) . $endstellen;

        return $kdnummer;

    }

    public function insert($customerId, $firstName, $lastName) {

        $sql = "INSERT INTO customer (customerId, firstName, lastName) VALUES (?, ?, ?)";
        $stmt= $this->connection->prepare($sql);
        $stmt->execute([$customerId, $firstName, $lastName]);

        echo "<br>" . " Premiumkunde: " . $firstName . " " . $lastName;
        echo "<br>" . " Premiumkundennummer: " . $customerId;

    }

    public function checkId($customerId) {

        $stmt = $this->connection->query("SELECT customerId FROM customer WHERE customerId = '$customerId'");
        $result = $stmt->fetch();
        
        if (!empty($result)) {
            $idExist = true;
        } else {
            $idExist = false;
        }

        return $idExist;
    }

    }