<?php
namespace App;

use App\Core\Bus\Database;
class Migrations
{
    protected static $db;
    public static function run($selectedTable)
    {
        $db = new Database();

        $tables = self::schemas();
        try {
            $db->query($tables[$selectedTable]);

            $db->createTable($selectedTable);
        } catch (\Exception $e) {
            echo $e;
        }
    }

    private static function schemas(){
       return [
            'users' => "CREATE TABLE users(
                    id BigInt Unsigned auto_increment,
                    name Varchar(250) NOT NULL unique,
                    email Varchar(250) NOT NULL unique,
                    password Varchar(255) NOT NULL,
                    Primary Key(id)
            )",

            'teams' => "CREATE TABLE teams(
                    id BigInt Unsigned auto_increment,
                    name Varchar(250) NOT NULL unique,
                    Primary Key(id)
             )",
       ];
    }
}
