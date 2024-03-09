<?
session_start();
$uid=$_SESSION['user_id'];
if (isset($_SESSION['user_id'])){
echo "WELCOME!";

}