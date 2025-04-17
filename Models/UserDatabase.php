<?php
// nnehåller en klass för att hantera användare via biblioteket Delight Auth, vilket är ett färdigt system för inloggning, registrering, återställning m.m.
// Laddar in alla externa paket från Composer, t.ex. Delight Auth

require 'vendor/autoload.php';

// Klassen ansvarar för att hantera användare i databasen
class UserDatabase
{
  // Lagrar PDO-anslutningen till databasen
  private $pdo;

  // Lagrar Delight\Auth instansen
  private $auth;

  // Hämtar Auth-objektet om vi behöver använda det utanför klassen
  function getAuth()
  {
    return $this->auth;
  }

  // Konstruktor som körs när vi skapar ett nytt UserDatabase-objekt
  function __construct($pdo)
  {
    $this->pdo = $pdo;
    $this->auth = new \Delight\Auth\Auth($pdo);
  }

  // Skapar användartabellerna i databasen (Delight Auth behöver dessa)
  function setupUsers()
  {
    // SQL-skriptet skapar ALLA tabeller som Delight Auth behöver

    $sql = "
        -- PHP-Auth (https://github.com/delight-im/PHP-Auth)
        -- Copyright (c) delight.im (https://www.delight.im/)
        -- Licensed under the MIT License (https://opensource.org/licenses/MIT)
        
        /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
        /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
        /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
        /*!40101 SET NAMES utf8mb4 */;
        
        CREATE TABLE IF NOT EXISTS `users` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
          `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `status` tinyint(2) unsigned NOT NULL DEFAULT '0',
          `verified` tinyint(1) unsigned NOT NULL DEFAULT '0',
          `resettable` tinyint(1) unsigned NOT NULL DEFAULT '1',
          `roles_mask` int(10) unsigned NOT NULL DEFAULT '0',
          `registered` int(10) unsigned NOT NULL,
          `last_login` int(10) unsigned DEFAULT NULL,
          `force_logout` mediumint(7) unsigned NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`),
          UNIQUE KEY `email` (`email`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        
        CREATE TABLE IF NOT EXISTS `users_confirmations` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `user_id` int(10) unsigned NOT NULL,
          `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
          `selector` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `expires` int(10) unsigned NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `selector` (`selector`),
          KEY `email_expires` (`email`,`expires`),
          KEY `user_id` (`user_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        
        CREATE TABLE IF NOT EXISTS `users_remembered` (
          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          `user` int(10) unsigned NOT NULL,
          `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `expires` int(10) unsigned NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `selector` (`selector`),
          KEY `user` (`user`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        
        CREATE TABLE IF NOT EXISTS `users_resets` (
          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
          `user` int(10) unsigned NOT NULL,
          `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `expires` int(10) unsigned NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `selector` (`selector`),
          KEY `user_expires` (`user`,`expires`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        
        CREATE TABLE IF NOT EXISTS `users_throttling` (
          `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
          `tokens` float unsigned NOT NULL,
          `replenished_at` int(10) unsigned NOT NULL,
          `expires_at` int(10) unsigned NOT NULL,
          PRIMARY KEY (`bucket`),
          KEY `expires_at` (`expires_at`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        
        /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
        /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
    // Kör hela SQL-skriptet på databasen

    $this->pdo->exec($sql);
  }


  //ANVÄND DENNA FUNKTION ÄVEN FÖR PRODUKTERNA!!!!!
  // Skapar en användare om den inte redan finns (kan användas vid test eller setup)
  function seedUsers()
  {
    // Kollar om användaren redan finns
    if ($this->pdo->query("select * from users where email='carolinmimmie@gmail.com'")->rowCount() == 0) {
      // Skapar en ny admin-användare med e-post, lösenord och användarnamn
      $userId = $this->auth->admin()->createUser("carolinmimmie@gmail.com", "root", "carolin");
    }
  }
}
