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
        // $this->initData();
        $this->usersDatabase = new UserDatabase($this->pdo);
        $this->usersDatabase->setupUsers();
        $this->usersDatabase->seedUsers();
    }

    // Funktion som skapar tabellen Products om den inte finns
    function initDatabase()
    {
        $this->pdo->query('CREATE TABLE IF NOT EXISTS CartItem (
                id INT AUTO_INCREMENT PRIMARY KEY,
                productId VARCHAR(30),
                quantity INT,
                addedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                sessionId VARCHAR(50), # b77e0a1d7b4f9286f4ddcb8c61b80403
                userId INT NULL,
                FOREIGN KEY (productId) REFERENCES Products(pimId) ON DELETE CASCADE
                )');
    }
    // function addProductIfNotExists($title, $description, $price, $img, $stock, $category, $popularity)
    // {
    //     $query = $this->pdo->prepare("SELECT * FROM Products WHERE title = :title");
    //     $query->execute(['title' => $title]);
    //     if ($query->rowCount() == 0) {
    //         $this->insertProduct($title, $description, $stock, $price, $category, $img, $popularity);
    //     }
    // }
    // function initData()
    // {
    //     //världen
    //     $this->addProductIfNotExists("Parisian Streets", "En romantisk bild av Paris gator i vårskrud, med blommande träd och stadens charm.", 229, "https://images.unsplash.com/photo-1522093007474-d86e9bf7ba6f?q=80&w=1600&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 120, "Världen", 1);
    //     $this->addProductIfNotExists("Barcelonas Diagonal Street", "En livlig stadsbild som visar Barcelonas ikoniska Diagonal Street i ett retroinspirerat ljus.", 119, "https://images.unsplash.com/photo-1583422409516-2895a77efded?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 90, "Världen", 8);
    //     $this->addProductIfNotExists("Tibidabo Amusement Park", "​En tidlös vy över Barcelonas mest ikoniska nöjespark, där historia möter modernitet", 199, "https://images.unsplash.com/photo-1558642084-fd07fae5282e?q=80&w=2672&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 250, "Världen", 2);
    //     $this->addProductIfNotExists("Palms in spain", "En lugn bild av palmer mot en klarblå himmel, som förmedlar känslan av en solig dag vid den spanska kusten.", 199, "https://images.unsplash.com/photo-1586122891856-5f90886b0cee?q=80&w=2574&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 230, "Världen", 4);
    //     $this->addProductIfNotExists("Houses by the ocean", "En harmonisk illustration av färgglada hus vid havet, som skapar en känsla av lugn och ro i ditt hem.", 199, "https://plus.unsplash.com/premium_photo-1689287363506-de3f74c9b99c?q=80&w=2574&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 280, "Världen", 5);
    //     $this->addProductIfNotExists("Food Market", "En livlig marknadsscen med färska råvaror och människor i rörelse – en hyllning till vardagens färger och dofter", 199, "https://images.unsplash.com/photo-1529686398651-b8112f4bb98c?q=80&w=2570&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 220, "Världen", 5);
    //     $this->addProductIfNotExists("Love by the ocean", "Ett abstrakt konstverk med böljande, färgrika linjer i jordnära toner som skapar en känsla av rörelse och harmoni.", 199, "https://images.unsplash.com/photo-1686775553473-3f25340018a7?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8b2NlYW4lMjBwb3N0ZXIlMjBsb3ZlY291cGxlfGVufDB8fDB8fHww", 280, "Världen", 5);
    //     $this->addProductIfNotExists("Street life", "En energisk och färgstark poster som fångar det urbana stadslivet med livliga penseldrag och intensiv rörelse. En perfekt kontrast till en minimalistisk inredning.", 199, "https://images.unsplash.com/photo-1643855380453-c04d6c6821b3?q=80&w=1335&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 280, "Världen", 5);

    //     //Abstrakt
    //     $this->addProductIfNotExists("Fluid Geometry", "Ett geometriskt konstverk med rena linjer och former som skapar en modern känsla.", 229, "https://images.unsplash.com/photo-1744057137174-72a54712fd83?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 170, "Abstrakt", 10);
    //     $this->addProductIfNotExists("Mindscapes", "En drömlik landskapsbild som fångar naturens stillhet och mystik.", 299, "https://images.unsplash.com/photo-1743965127529-1de2aa469477?q=80&w=1913&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 105, "Abstrakt", 1);
    //     $this->addProductIfNotExists("Tibidabo Amusement Park", "Ett konstverk där mjuka färgövergångar skapar en känsla av lugn och balans", 199, "https://plus.unsplash.com/premium_photo-1671554187530-8f9bd9449193?q=80&w=2727&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 250, "Abstrakt", 2);
    //     $this->addProductIfNotExists("My mind", "En minimalistisk komposition av linjer och former som ger ett modernt uttryck.", 199, "https://images.unsplash.com/photo-1604079628040-94301bb21b91?q=80&w=2574&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 230, "Abstrakt", 4);
    //     $this->addProductIfNotExists("Houses by the ocean", "Abstrakta former som påminner om naturens egna mönster och rörelser.", 199, "https://images.unsplash.com/photo-1557672172-298e090bd0f1?q=80&w=2574&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 280, "Abstrakt", 5);
    //     $this->addProductIfNotExists("Beyond Reality", "Färgstarka strösseldrag som skapar en känsla av energi och rörelse.", 199, "https://plus.unsplash.com/premium_photo-1668790939880-175008e583db?q=80&w=2480&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 220, "Abstrakt", 5);
    //     $this->addProductIfNotExists("Kaleidoscope Symphony", "Ett drömskt motiv med mjuka färgövergångar i blått och sandtoner som fångar känslan av havets närhet och lugn. Perfekt för dig som vill inreda med en stillsam och romantisk atmosfär.", 199, "https://images.unsplash.com/photo-1727436132086-e8a05da76ca4?q=80&w=2620&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 220, "Abstrakt", 5);
    //     $this->addProductIfNotExists("Woodland Harmony", "Ett abstrakt konstverk med böljande, färgrika linjer i jordnära toner som skapar en känsla av rörelse och harmoni.", 199, "https://images.unsplash.com/photo-1699304050690-d4e88121bef6?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjN8fHBvc3RlciUyMGFic3RyYWt0fGVufDB8fDB8fHww", 280, "Abstrakt", 5);

    //     //Djur
    //     $this->addProductIfNotExists("Gentle Bunny", "En söt och lugnande bild av en kanin, perfekt för att skapa en mysig stämning.", 199, "https://plus.unsplash.com/premium_vector-1739039925751-7118c15d0109?q=80&w=1800&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 80, "Barnrum", 3);
    //     $this->addProductIfNotExists("Grace in the Wild", "En elegant skildring av naturens skönhet och vildhet i harmonisk balans.", 179, "https://images.unsplash.com/photo-1688537171088-0c2e2924a24f?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 80, "Djur", 2);
    //     $this->addProductIfNotExists("Silent Majesty", " En kraftfull leopard fångad i ett stilla ögonblick – en symbol för styrka, elegans och vild skönhet.​", 199, "https://images.unsplash.com/photo-1544985361-b420d7a77043?q=80&w=2574&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 250, "Djur", 2);
    //     $this->addProductIfNotExists("Majestic Elephant", "Denna ståtliga elefant symboliserar styrka, visdom och lugn. Med sina kraftfulla betar och vänliga ögon påminner den oss om naturens storhet och vikten av att skydda världens vilda djur.", 199, "https://images.unsplash.com/photo-1549366021-9f761d450615?q=80&w=2612&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 230, "Djur", 4);
    //     $this->addProductIfNotExists("Mighty Buffalo", "Buffeln är ett imponerande djur med massiv kropp och kraftfulla horn. Den lever ofta i flock och är känd för sitt mod och sin lojalitet mot gruppen.", 199, "https://images.unsplash.com/photo-1618305217067-3e05d6122b44?q=80&w=2564&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 280, "Djur", 5);
    //     $this->addProductIfNotExists("Graceful Birds", "Fåglar fascinerar med sina färgglada fjädrar och vackra sång. De symboliserar frihet, rörelse och naturens skönhet, och finns i alla möjliga former – från små sångfåglar till majestätiska rovfåglar.", 199, "https://images.unsplash.com/photo-1507091249509-ea24980b1218?q=80&w=1801&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 220, "Djur", 5);
    //     $this->addProductIfNotExists("Striped Beauty", "Zebran är känd för sitt unika svartvita mönster som gör varje individ helt unik. Den lever i savannens hjärta och rör sig ofta i grupper för skydd. Zebran symboliserar balans, individualitet och vild frihet.", 199, "https://images.unsplash.com/photo-1540377536853-9dcd8b00ec43?q=80&w=2074&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 220, "Djur", 5);
    //     $this->addProductIfNotExists("Gentle Giants", "En fantasifull affisch som skildrar majestätiska jättar i en förtrollad värld.", 199, "https://plus.unsplash.com/premium_photo-1661938235722-7532c1c207b4?q=80&w=1446&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 280, "Djur", 5);
    //     $this->addProductIfNotExists("White Tiger", "En mäktig bild på den unika vita tigern med blå ögon", 199, "https://images.unsplash.com/photo-1602491453631-e2a5ad90a131?q=80&w=1254&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 280, "Djur", 5);

    //     //Barnrum 
    //     $this->addProductIfNotExists("Slow and Steady", "En charmig illustration av en sengångare som påminner oss om att ta det lugnt och njuta av resan.", 179, "https://plus.unsplash.com/premium_photo-1675432656807-216d786dd468?q=80&w=1890&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 150, "Barnrum", 4);
    //     $this->addProductIfNotExists("Cutie Pitbull", "Ett konstverk där mjuka färgövergångar skapar en känsla av lugn och balans", 199, "https://plus.unsplash.com/premium_photo-1722859221349-26353eae4744?q=80&w=2672&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 250, "Barnrum", 2);
    //     $this->addProductIfNotExists("FlowerPower", "En charmig hund med blomsterprydda ögon – en lekfull hyllning till naturens skönhet och glädje.", 199, "https://media.istockphoto.com/id/1410264915/sv/foto/portrait-of-a-funny-dog-on-a-pink-isolated-background-with-daisy-glasses-golden-retriever-in.jpg?s=1024x1024&w=is&k=20&c=Xdl4mYU8Ng95jUVoALSrbFfafyDqlJRoHvghl1cz9us=", 230, "Barnrum", 4);
    //     $this->addProductIfNotExists("Valentine’s Day", "En lekfull och romantisk poster med retroinspirerad 3D-typografi och röda rosor – perfekt för att sprida kärlek och glädje i barnrummet.​", 199, "https://media.istockphoto.com/id/2193883733/sv/vektor/valentines-day-3d-love-text-in-retro-style-typography-with-red-roses.jpg?s=1024x1024&w=is&k=20&c=qcAr39jN4aW7wED5Z5VxXA6zJWtukzGWUafp-gc8Ltw=", 280, "Barnrum", 5);
    //     $this->addProductIfNotExists("We are the world", "En färgstark illustration som hyllar gemenskap och omtanke om vår planet. Perfekt för att inspirera barn till att värna om miljön och förstå vikten av samarbete.​", 199, "https://media.istockphoto.com/id/1297466460/sv/vektor/jordens-dag-vektor-illustration-p%C3%A5-temat-k%C3%A4rlek-ekologi-och-skydd-av-v%C3%A5r-planet-jorden.jpg?s=1024x1024&w=is&k=20&c=85TRl2oOyWRF5g875tSWfAXMWdg2tvoiyvSoafk8ibY=", 220, "Barnrum", 5);
    //     $this->addProductIfNotExists("Planets", "En fantasifull poster med färgglada planeter och stjärnor som väcker nyfikenhet för rymden och universum. En perfekt dekoration för det lilla rymdäventyrets rum", 199, "https://plus.unsplash.com/premium_photo-1677589198127-62287b1827f3?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 220, "Barnrum", 5);
    //     $this->addProductIfNotExists("Hallowen", "Tagga till på hallowen med den dessa gulliga figurer", 199, "https: //plus.unsplash.com/premium_photo-1663852248441-bf1d1c6b7ba9?q=80&w=1287&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 220, "Barnrum", 5);


    //     //Vintage
    //     $this->addProductIfNotExists("Retro Vibes", "En färgstark affisch som för tankarna till retrostilens glada och lekfulla estetik.", 179, "https://plus.unsplash.com/premium_vector-1720027992280-970fcb00e58d?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjB8fHZpbnRhZ2V8ZW58MHx8MHx8fDA%3D", 120, "Vintage", 4);
    //     $this->addProductIfNotExists("Retro Red Sunset", "En vintageinspirerad affisch med en röd sol som skapar en varm och nostalgisk atmosfär.", 119, "https://plus.unsplash.com/premium_vector-1711987817831-55bfbf7200a6?q=80&w=1800&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 80, "Vintage", 2);
    //     $this->addProductIfNotExists("Sunlit Dive", "En elegant dykare fångad i ett ögonblick av frihet, där solens strålar dansar över vattnet och skapar en känsla av tidlös sommar.", 199, "https://plus.unsplash.com/premium_photo-1667239045006-05e9f3662264?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjV8fHZpbnRhZ2UlMjBwb3N0ZXJ8ZW58MHx8MHx8fDA%3D", 250, "Vintage", 2);
    //     $this->addProductIfNotExists("Waves of Grace", "En stiliserad simmare i rörelse, där varje linje och kurva förmedlar en känsla av harmoni och balans i vattnets rytm.", 199, "https://images.unsplash.com/photo-1579762714453-51d9913984e2?q=80&w=2662&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 230, "Vintage", 4);
    //     $this->addProductIfNotExists("Mushroom Medley", " En samling vackert illustrerade svampar i varma, jordnära toner. Perfekt för naturälskare som vill addera en rustik touch till sin inredning.​", 199, "https://plus.unsplash.com/premium_photo-1667238810317-a349c0fa2dd1?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 280, "Vintage", 5);
    //     $this->addProductIfNotExists("Birds of the North", "Färgstarka strösseldrag som skapar en känsla av energi och rörelse.", 199, "https://images.unsplash.com/photo-1584448141569-69f342da535c?q=80&w=2682&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 220, "Vintage", 5);
    //     $this->addProductIfNotExists("Underwater Elegance", "En dämpad färgpalett som inbjuder till stilla eftertanke och introspektion.", 199, "https://images.unsplash.com/photo-1584448097764-374f81551427?q=80&w=2196&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 220, "Vintage", 5);
    //     $this->addProductIfNotExists("The National Park", "En poster från The National Park vilda liv.", 199, "https://images.unsplash.com/photo-1580130718810-358e5e8af61b?q=80&w=1347&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", 220, "Vintage", 5);
    // }




    // Hämtar en produkt med ett visst id
    function getProduct($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM PRODUCTS WHERE pimId = :id");
        $query->execute(["id" => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, 'Product');
        return $query->fetch();
    }

    // Uppdaterar en produkt i databasen
    function updateProduct($product)
    {
        $s = "UPDATE Products SET title = :title," .
            " price = :price, stock = :stock, category = :category, img = :img, popularity = :popularity WHERE pimId = :id";
        $query = $this->pdo->prepare($s);
        $query->execute([
            'title' => $product->title,
            'price' => $product->price,
            'stock' => $product->stock,
            'category' => $product->category,
            'id' => $product->pimId,
            'img' => $product->img,
            'popularity' => $product->popularity
        ]);
    }

    // Tar bort en produkt från databasen
    function deleteProduct($id)
    {
        $query = $this->pdo->prepare("DELETE FROM Products WHERE pimId = :id");
        $query->execute(['id' => $id]);
    }

    // Lägger till en ny produkt i databasen
    function insertProduct($pimId, $title, $description, $stock, $price, $category, $img, $popularity)
    {
        $sql = "INSERT INTO Products (pimId,title,description,price,stock,category,img,popularity) VALUES (:pimId,:title,:description,:price,:stock,:category,:img,:popularity)";
        $query = $this->pdo->prepare($sql);
        $query->execute([
            'pimId' => $pimId,
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'stock' => $stock,
            'category' => $category,
            'img' => $img,
            'popularity' => $popularity
        ]);
    }

    // Hämtar alla produkter med valfri sortering
    function getAllProducts($sortCol = "pimId", $sortOrder = "asc")
    {
        // Säkerställer att bara tillåtna kolumner används
        if (!in_array($sortCol, ["id", "title", "price", "stock", "img", "popularity"])) {
            $sortCol = "pimId";
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
        $query = $this->pdo->prepare("SELECT * FROM Products WHERE category = :category ORDER BY $sortCol $sortOrder");
        $query->execute(['category' => $catName]);
        return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
    }


    // Hämtar alla unika kategorinamn från tabellen Products
    function getAllCategories()
    {
        // SELECT DISTINCT category FROM Products
        $data = $this->pdo->query('SELECT DISTINCT category FROM Products')->fetchAll(PDO::FETCH_COLUMN);
        return $data;
    }

    function getPopularProducts()
    {
        $query = $this->pdo->query("SELECT * FROM Products ORDER BY popularity DESC LIMIT 10"); // Products är TABELL 
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

        $query = $this->pdo->prepare("SELECT * FROM Products WHERE title LIKE :q or category like :q ORDER BY $sortCol $sortOrder");
        $query->execute(['q' => "%$q%"]);
        return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
    }



    //FUNkTIONER FÖR CART
    function getCartItems($userId, $sessionId)
    {
        if ($userId != null) {
            $query = $this->pdo->prepare("UPDATE CartItem SET userId=:userId WHERE userId IS NULL AND  sessionId = :sessionId");
            $query->execute(['sessionId' => $sessionId, 'userId' => $userId]);
        }

        $query = $this->pdo->prepare("SELECT CartItem.Id as id, CartItem.productId, CartItem.quantity, Products.title as productName, Products.price as productPrice, Products.price * CartItem.quantity as rowPrice     FROM CartItem JOIN Products ON Products.pimId=CartItem.productId  WHERE userId=:userId or sessionId = :sessionId");
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
