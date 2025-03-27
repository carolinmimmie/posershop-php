<?php
class Product
{
    public $id;
    public $title;
    public $price;
    public $stockLevel;
    public $categoryName;
    public $imageUrl;
};
function getProduct($id)
{    //function getProduct(int $id): Product | null{
    // SELECT * FROM PRODUCTS WHERE ID = $id
    global $allaProdukter;

    // return array_find($allaProdukter, function ($product) use ($id ) {
    //     return $product->id == $id;
    // });

    foreach ($allaProdukter as $product) {
        if ($product->id == $id) {
            return $product;
        }
    }
    return null;
}





function getAllCategories()
{




    $cats = [];
    foreach (getAllProducts() as $product) {
        if (!in_array($product->categoryName, $cats)) {
            array_push($cats, $product->categoryName);
        }
    }

    //var_dump($cats);
    return $cats;
}

function getAllProducts()
{
    // $dsn = "mysql:host=localhost;dbname=stefansshop";
    // $pdo = new PDO($dsn, "root", "hejsan123");
    // $query = $pdo->query('SELECT * FROM Products');
    // //                                  DETTA ÄR TABELLEN

    // return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
    // //                                         DETTA ÄR PHP KLASS 
    //    DETTA SKA BLI EN SELECT * FROM Products
    global $allaProdukter;
    return $allaProdukter;
}
