<?php
class Database
{
    public $pdo;

    function __construct()
    {
        $host = $_ENV['HOST'];
        $db   = $_ENV['DB'];
        $user = $_ENV['USER'];
        $pass = $_ENV['PASSWORD'];
        $port = $_ENV['PORT'];

        $dsn = "mysql:host=$host:$port;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->initDatabase();
    }

    function initDatabase()
    {
        $this->pdo->query('CREATE TABLE IF NOT EXISTS Products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(50),
                price INT,
                stockLevel INT,
                categoryName VARCHAR(50)
                       
            )');
    }
    function getProduct($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM PRODUCTS WHERE id = :id");
        $query->execute(["id" => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, 'Product');
        return $query->fetch();
    }
    function updateProduct($product)
    {
        $s = "UPDATE Products SET title = :title," .
            " price = :price, stockLevel = :stockLevel, categoryName = :categoryName, imageUrl = :imageUrl WHERE id = :id";
        $query = $this->pdo->prepare($s);
        $query->execute([
            'title' => $product->title,
            'price' => $product->price,
            'stockLevel' => $product->stockLevel,
            'categoryName' => $product->categoryName,
            'id' => $product->id,
            'imageUrl' => $product->imageUrl
        ]);
    }

    function insertProduct($title, $stockLevel, $price, $categoryName, $imageUrl)
    {
        $sql = "INSERT INTO Products (title,price,stockLevel,categoryName,imageUrl) VALUES (:title,:price,:stockLevel,:categoryName,:imageUrl)";
        $query = $this->pdo->prepare($sql);
        $query->execute([
            'title' => $title,
            'price' => $price,
            'stockLevel' => $stockLevel,
            'categoryName' => $categoryName,
            'imageUrl' => $imageUrl,
        ]);
    }

    function getAllProducts($sortCol = "id", $sortOrder = "asc")
    {
        if (!in_array($sortCol, ["id", "title", "price", "stockLevel", "imageUrl"])) {
            $sortCol = "id";
        }
        if (!in_array($sortOrder, ["asc", "desc"])) {
            $sortOrder = "asc";
        }
        $query = $this->pdo->query("SELECT * FROM Products ORDER BY $sortCol $sortOrder"); // Products är TABELL 
        return $query->fetchAll(PDO::FETCH_CLASS, 'Product'); // Product är PHP Klass
    }
    function getAllCategories()
    {
        // SELECT DISTINCT categoryName FROM Products
        $data = $this->pdo->query('SELECT DISTINCT categoryName FROM Products')->fetchAll(PDO::FETCH_COLUMN);
        return $data;
    }
}
