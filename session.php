<?php
session_start();
function checkLoggedIn(){
    if(!isset($_SESSION['loggedin'])){
        header('Location: ./auth/login');
    }
}