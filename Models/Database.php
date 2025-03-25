<?php 
    class Database{
        public $pdo;

        function __construct() {    
            $host = "localhost";
            $db   = "shoppen";
            $user = "root";
            $pass = "hejsan123";

            $dsn = "mysql:host=$host;port=3306;dbname=$db";
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->initDatabase();
        }

        function initDatabase(){
            $this->pdo->query('CREATE TABLE IF NOT EXISTS Products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(50),
                price INT,
                stockLevel INT,
                categoryName VARCHAR(50)
            )');
        }

        function getAllProducts(){
            $query = $this->pdo->query('SELECT * FROM Products'); // Products är TABELL 
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product'); // Product är PHP Klass
        }
        function getAllCategories(){
                // SELECT DISTINCT categoryName FROM Products
            $data = $this->pdo->query('SELECT DISTINCT categoryName FROM Products')->fetchAll(PDO::FETCH_COLUMN);
            return $data;
        }

    }
?>