<?php
require_once __DIR__.'/master.php';

$result = sendHTMLMail(
    'anjanbaruah97@gmail.com',
    'Pranjal',
    'Welcome to Our Website',
    'templates/welcome.html',
    [
        'name'       => 'Pranjal Gogoi',
        'email'      => 'anjanbaruah97@gmail.com',
        'date'       => date('d-m-Y'),
        'login_link' => 'https://yourwebsite.com/login'
    ]
);

print_r($result);

?>