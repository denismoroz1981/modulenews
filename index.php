<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 12.06.18
 * Time: 6:06
 */

session_start();

$host = '127.0.0.1';
$dbname='moduleoop';
$user='moduleoopadmin';
$password='';

try {

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_CASE => PDO::CASE_NATURAL,
                PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

            ];
            $dbn = new PDO("mysql:host=$host;dbname=$dbname",$user,$password,$options);

        } catch (PDOException $e) {
            echo $e ->getMessage();
        }

require_once ("layout.php");