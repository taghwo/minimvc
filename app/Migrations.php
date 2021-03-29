<?php
namespace App;

use App\Core\Bus\Database;
class Migrations
{
    /**
     *
     * @var object
     */
    protected static $db;

    /**
     * Run migrations
     *
     * @param string $selectedTable
     * @return response
     */
    public static function run(string $selectedTable)
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

    /**
     * Create table schemas
     *
     * @return array
     */
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
