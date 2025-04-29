<?php
// Importerar klassen UserDatabase som finns i Models-mappen
require_once('Models/UserDatabase.php');
require_once('Models/Cart.php');
require_once('Models/CartItem.php');
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
        $this->initData();
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
                categoryName VARCHAR(100),
                popularityFactor INT,
                imageUrl VARCHAR (1000),
                description VARCHAR(1000)
            )');
        $this->pdo->query('CREATE TABLE IF NOT EXISTS CartItem (
                id INT AUTO_INCREMENT PRIMARY KEY,
                productId INT,
                quantity INT,
                addedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                sessionId VARCHAR(50), # b77e0a1d7b4f9286f4ddcb8c61b80403
                userId INT NULL,
                FOREIGN KEY (productId) REFERENCES Products(id) ON DELETE CASCADE
                )');
    }
    function addProductIfNotExists($title, $description, $price, $imageUrl, $stockLevel, $categoryName, $popularityFactor)
    {
        $query = $this->pdo->prepare("SELECT * FROM Products WHERE title = :title");
        $query->execute(['title' => $title]);
        if ($query->rowCount() == 0) {
            $this->insertProduct($title, $description, $stockLevel, $price, $categoryName, $imageUrl, $popularityFactor);
        }
    }
    function initData()
    {
        $this->addProductIfNotExists("Nature's Serenity", "Two brown deer peacefully grazing among trees. A perfect addition to bring a calming, nature-inspired atmosphere to your home or office.", 299, "https://images.unsplash.com/photo-1743965127529-1de2aa469477?q=80&w=1913&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 105, "Världen", 1);
        $this->addProductIfNotExists("Furry Friends ", "An illustration of squirrels in a tree. Bring a touch of woodland charm to your child's room with this adorable poster!", 119, "https://images.unsplash.com/photo-1583422409516-2895a77efded?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 90, "Vintage", 8);
        $this->addProductIfNotExists("Hey Kitty Cat ", "Illustration of a brown and white cat sitting calmly on the ground, with a relaxed and peaceful expression, surrounded by soft lines and neutral tones.", 119, "https://plus.unsplash.com/premium_vector-1711987817831-55bfbf7200a6?q=80&w=1800&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 80, "Djur", 2);
        $this->addProductIfNotExists("Air ballons", "Air balloons in the sky. Imagine the dreamlike view from a hot air balloon", 179, "https://images.unsplash.com/photo-1688537171088-0c2e2924a24f?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 80, "Barnrum", 2);
        $this->addProductIfNotExists("Owl and Oak", "Illustration of an owl perched on a tree branch surrounded by smaller birds", 199, "https://plus.unsplash.com/premium_vector-1739039925751-7118c15d0109?q=80&w=1800&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 80, "Vintage", 3);
        $this->addProductIfNotExists("Fresh Lemons", "A close-up of several fresh yellow lemons", 179, "https://plus.unsplash.com/premium_vector-1720027992280-970fcb00e58d?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjB8fHZpbnRhZ2V8ZW58MHx8MHx8fDA%3D", 120, "Kitchen posters", 4);
        $this->addProductIfNotExists("Summer Lemons", "Fresh yellow lemons resting on a sunlit rock near the seaA summery addition to your kitchen.", 179, "https://plus.unsplash.com/premium_photo-1675432656807-216d786dd468?q=80&w=1890&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 150, "Barnrum", 4);
        $this->addProductIfNotExists("Summer drinks", "A variety of glasses and pitchers filled with colorful fruit-infused drinks.", 229, "https://images.unsplash.com/photo-1744057137174-72a54712fd83?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 170, "Abstrakt", 10);
        $this->addProductIfNotExists("Pink Cherry Blossoms", "Pink cherry blossoms in full bloom on tree. Bring the elegance of spring into your space", 229, "https://images.unsplash.com/photo-1522093007474-d86e9bf7ba6f?q=80&w=1600&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 120, "Världen", 1);
        $this->addProductIfNotExists("Poppy Peach", "Oeach and pink poppies with bright yellow centers. Bring the elegance of spring into your space", 199, "https://plus.unsplash.com/premium_photo-1661938235722-7532c1c207b4?q=80&w=1446&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 280, "Djur", 5);
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
    function insertProduct($title, $description, $stockLevel, $price, $categoryName, $imageUrl, $popularityFactor)
    {
        $sql = "INSERT INTO Products (title,description,price,stockLevel,categoryName,imageUrl,popularityFactor) VALUES (:title,:description,:price,:stockLevel,:categoryName,:imageUrl,:popularityFactor)";
        $query = $this->pdo->prepare($sql);
        $query->execute([
            'title' => $title,
            'description' => $description,
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
    function getCategoryProducts($catName, $sortCol, $sortOrder)
    {
        // Validera och justera inkommande sorteringsparametrar
        if (!in_array($sortCol, ["title", "price"])) {
            $sortCol = "title";
        }
        if (!in_array($sortOrder, ["asc", "desc"])) {
            $sortOrder = "asc";
        }

        // Om ingen kategori anges, hämta allt
        if ($catName == "") {
            $query = $this->pdo->query("SELECT * FROM Products ORDER BY $sortCol $sortOrder");
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
        }

        // Hämta produkter baserat på kategori + sortering
        $query = $this->pdo->prepare("SELECT * FROM Products WHERE categoryName = :categoryName ORDER BY $sortCol $sortOrder");
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

    function getPopularProducts()
    {
        $query = $this->pdo->query("SELECT * FROM Products ORDER BY popularityFactor DESC LIMIT 10"); // Products är TABELL 
        return $query->fetchAll(PDO::FETCH_CLASS, 'Product'); // Product är PHP Klass
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



    //FUNTIONER FÖR CART
    function getCartItems($userId, $sessionId)
    {
        if ($userId != null) {
            $query = $this->pdo->prepare("UPDATE CartItem SET userId=:userId WHERE userId IS NULL AND  sessionId = :sessionId");
            $query->execute(['sessionId' => $sessionId, 'userId' => $userId]);
        }

        $query = $this->pdo->prepare("SELECT CartItem.Id as id, CartItem.productId, CartItem.quantity, Products.title as productName, Products.price as productPrice, Products.price * CartItem.quantity as rowPrice     FROM CartItem JOIN Products ON Products.id=CartItem.productId  WHERE userId=:userId or sessionId = :sessionId");
        $query->execute(['sessionId' => $sessionId, 'userId' => $userId]);


        return $query->fetchAll(PDO::FETCH_CLASS, 'CartItem');
    }

    function convertSessionToUser($session_id, $userId, $newSessionId)
    {
        $query = $this->pdo->prepare("UPDATE CartItem SET userId=:userId, sessionId=:newSessionId WHERE sessionId = :sessionId");
        $query->execute(['sessionId' => $session_id, 'userId' => $userId, 'newSessionId' => $newSessionId]);
    }

    function updateCartItem($userId, $sessionId, $productId, $quantity)
    {
        if ($quantity <= 0) {
            $query = $this->pdo->prepare("DELETE FROM CartItem WHERE (userId=:userId or sessionId=:sessionId) AND productId = :productId");
            $query->execute(['userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId]);
            return;
        }
        $query = $this->pdo->prepare("SELECT * FROM CartItem  WHERE (userId=:userId or sessionId=:sessionId) AND productId = :productId");
        $query->execute(['userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId]);
        if ($query->rowCount() == 0) {
            $query = $this->pdo->prepare("INSERT INTO CartItem (productId, quantity, sessionId, userId) VALUES (:productId, :quantity, :sessionId, :userId)");
            $query->execute(['userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId, 'quantity' => $quantity]);
        } else {
            $query = $this->pdo->prepare("UPDATE CartItem SET quantity = :quantity WHERE (userId=:userId or sessionId=:sessionId) AND productId = :productId");
            $query->execute(['userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId, 'quantity' => $quantity]);
        }
    }
}
