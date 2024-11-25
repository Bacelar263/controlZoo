<?php

$conexao = mysqli_connect("localhost","root","","controlzoo");

if(!$conexao){
    die('Connection Failed'. mysqli_connect_error());
}
    
?>