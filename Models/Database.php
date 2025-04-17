<?php
// Importerar klassen UserDatabase som finns i Models-mappen
require_once('Models/UserDatabase.php');
// Skapar en klass som hanterar databaskoppling och operationer
class Database
{
    // PDO-objektet hanterar databaskopplingen
    public $pdo;
    // Instans av UserDatabase-klassen som hanterar användarrelaterad data
    private $usersDatabase;
    // Getter-metod som returnerar instansen av UserDatabase
    function getUsersDatabase()
    {
        return $this->usersDatabase;
    }
    // Konstruktorn körs automatiskt när ett objekt skapas av klassen
    function __construct()
    {
        // Hämtar miljövariabler för databasuppkoppling
        $host = $_ENV['HOST'];
        $db   = $_ENV['DB'];
        $user = $_ENV['USER'];
        $pass = $_ENV['PASSWORD'];
        $port = $_ENV['PORT'];

        $dsn = "mysql:host=$host:$port;dbname=$db";
        // Skapar en ny PDO-instans (databaskoppling)
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->initDatabase();
        $this->usersDatabase = new UserDatabase($this->pdo);
        $this->usersDatabase->setupUsers();
        $this->usersDatabase->seedUsers();
    }

    // Funktion som skapar tabellen Products om den inte finns
    function initDatabase()
    {
        $this->pdo->query('CREATE TABLE IF NOT EXISTS Products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(50),
                price INT,
                stockLevel INT,
                categoryName VARCHAR(50),
                popularityFactor INT
            )');
    }

    // Hämtar en produkt med ett visst id
    function getProduct($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM PRODUCTS WHERE id = :id");
        $query->execute(["id" => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, 'Product');
        return $query->fetch();
    }

    // Uppdaterar en produkt i databasen
    function updateProduct($product)
    {
        $s = "UPDATE Products SET title = :title," .
            " price = :price, stockLevel = :stockLevel, categoryName = :categoryName, imageUrl = :imageUrl, popularityFactor = :popularityFactor WHERE id = :id";
        $query = $this->pdo->prepare($s);
        $query->execute([
            'title' => $product->title,
            'price' => $product->price,
            'stockLevel' => $product->stockLevel,
            'categoryName' => $product->categoryName,
            'id' => $product->id,
            'imageUrl' => $product->imageUrl,
            'popularityFactor' => $product->popularityFactor
        ]);
    }

    // Tar bort en produkt från databasen
    function deleteProduct($id)
    {
        $query = $this->pdo->prepare("DELETE FROM Products WHERE id = :id");
        $query->execute(['id' => $id]);
    }

    // Lägger till en ny produkt i databasen
    function insertProduct($title, $stockLevel, $price, $categoryName, $imageUrl, $popularityFactor)
    {
        $sql = "INSERT INTO Products (title,price,stockLevel,categoryName,imageUrl,popularityFactor) VALUES (:title,:price,:stockLevel,:categoryName,:imageUrl,:popularityFactor)";
        $query = $this->pdo->prepare($sql);
        $query->execute([
            'title' => $title,
            'price' => $price,
            'stockLevel' => $stockLevel,
            'categoryName' => $categoryName,
            'imageUrl' => $imageUrl,
            'popularityFactor' => $popularityFactor
        ]);
    }

    // Hämtar alla produkter med valfri sortering
    function getAllProducts($sortCol = "id", $sortOrder = "asc")
    {
        // Säkerställer att bara tillåtna kolumner används
        if (!in_array($sortCol, ["id", "title", "price", "stockLevel", "imageUrl", "popularityFactor"])) {
            $sortCol = "id";
        }
        if (!in_array($sortOrder, ["asc", "desc"])) {
            $sortOrder = "asc";
        }
        // Kör frågan mot databasen och returnerar produkter som objekt av klassen Product
        $query = $this->pdo->query("SELECT * FROM Products ORDER BY $sortCol $sortOrder"); // Products är TABELL 
        return $query->fetchAll(PDO::FETCH_CLASS, 'Product'); // Product är PHP Klass
    }

    // Hämtar produkter inom en viss kategori
    function getCategoryProducts($catName)
    {
        if ($catName == "") {
            $query = $this->pdo->query("SELECT * FROM Products"); // Products är TABELL 
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product'); // Product är PHP Klass
        }
        $query = $this->pdo->prepare("SELECT * FROM Products WHERE categoryName = :categoryName");
        $query->execute(['categoryName' => $catName]);
        return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
    }

    // Hämtar alla unika kategorinamn från tabellen Products
    function getAllCategories()
    {
        // SELECT DISTINCT categoryName FROM Products
        $data = $this->pdo->query('SELECT DISTINCT categoryName FROM Products')->fetchAll(PDO::FETCH_COLUMN);
        return $data;
    }

    // Söker efter produkter utifrån titel eller kategori, med sortering
    function searchProducts($q, $sortCol, $sortOrder)
    {
        if (!in_array($sortCol, ["title", "price"])) {
            $sortCol = "title";
        }
        if (!in_array($sortOrder, ["asc", "desc"])) {
            $sortOrder = "asc";
        }

        $query = $this->pdo->prepare("SELECT * FROM Products WHERE title LIKE :q or categoryName like :q ORDER BY $sortCol $sortOrder");
        $query->execute(['q' => "%$q%"]);
        return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
    }
}
