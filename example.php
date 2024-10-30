<?php 

include 'ticket.class.php';

$username = "root";
$pass = "";
$server = "localhost";
$name = "ticket";
$table = "tickets";


/**
 * For creating new ticket
 */
$ticket = new ticket($username, $pass, $name, $server, $table);
if($ticket->createTicket(123456,"Deneme başlık", "Deneme açıklama")){
    echo "ok";
}else{
    echo "something went wrong";
}




/**
 * For creating new answer 
 */
$ticket = new ticket($username, $pass, $name, $server, $table);
if($ticket->answerTicket(234567,1,"Deneme cevap")){
    echo "ok";
}else{
    echo "something went wrong";
}




/**
 * For updating a ticket
 */
$ticket = new ticket($username, $pass, $name, $server, $table);
if($ticket->updateTicket(1, "Deneme değişti","Deneme değişti")){
    echo "ok";
}else{
    echo "something went wrong";
}





/**
 * For closing a ticket
 */
$ticket = new ticket($username, $pass, $name, $server, $table);
if($ticket->closeTicket(1)){
    echo "ok";
}else{
    echo "something went wrong";
}




/**
 * For removing a ticket
 */
$ticket = new ticket($username, $pass, $name, $server, $table);
if($ticket->removeTicket(1)){
    echo "ok";
}else{
    echo "something went wrong";
}

?>
