# Ticketing System

## Overview
A simple PHP-based ticket management class to handle support tickets efficiently. The `Ticket` class allows for creating, answering, updating, and removing tickets, with built-in methods to track ticket status and link responses to the main ticket.

## Features
- **Automatic Table Creation**: Automatically creates the necessary `tickets` table if it doesn’t already exist.
- **Ticket Operations**: Create, update, and delete tickets with ease.
- **Status Management**: Update ticket statuses to track ongoing and closed tickets.
- **User Validation**: Ensure only valid users can interact with tickets.

## Requirements
- PHP 7.0 or higher
- PDO extension enabled
- MySQL database


## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/serohant/TicketingSystem.git
   cd user-authentication-system
   ```
2. Navigate to the project directory:
   ```bash
   cd user-authentication-system
   ```
3. Configure your database connection in the Ticket class constructor.
   
## Usage
* To create a new ticket, call the createTicket() method with the required parameters.
* To create a new answer, call the answerTicket() method with the required parameters.
* To update a ticket, call the updateTicket() method with the required parameters.
* To close a ticket, call the closeTicket() method with the required parameters.
* To delete a ticket, call the removeTicket() method with the required parameters.

## Example
### createTicket
```php
$ticket = new ticket('db_user', 'db_pass', 'db_name', 'localhost', 'tablename');
$new = $ticket->createTicket($userid, $subject, $text);
if ($new === true) {
    echo "successfull!";
} else {
    echo "Error";
}
```
### answerTicket
```php
$ticket = new ticket('db_user', 'db_pass', 'db_name', 'localhost', 'tablename');
$new = $ticket->answerTicket($userid, $id, $text);
if ($new === true) {
    echo "successfull!";
} else {
    echo "Error";
}
```
### updateTicket
```php
$ticket = new ticket('db_user', 'db_pass', 'db_name', 'localhost', 'tablename');
$new = $ticket->updateTicket($id, $subject, $text)
if ($new === true) {
    echo "successfull!";
} else {
    echo "Error";
}
```
### closeTicket
```php
$ticket = new ticket('db_user', 'db_pass', 'db_name', 'localhost', 'tablename');
$new = $ticket->closeTicket($id);
if ($new === true) {
    echo "successfull!";
} else {
    echo "Error";
}
```
### removeTicket
```php
$ticket = new ticket('db_user', 'db_pass', 'db_name', 'localhost', 'tablename');
$new = $ticket->removeTicket($id);
if ($new === true) {
    echo "successfull!";
} else {
    echo "Error";
}
```


# License
This project is licensed under the MIT License - see the LICENSE file for details.

# Contributing
Contributions are welcome! Please fork the repository and submit a pull request.
Feel free to customize any part of it as needed!
