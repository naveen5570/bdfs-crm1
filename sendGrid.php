<?php
require("sendgrid-php/sendgrid-php.php");
$from = new SendGrid\Email("DX PHP Test", "naveen@bdforsale.com");
$subject = "bdforsale Online Email";
$to = new SendGrid\Email("Elmer", "test-25f8qezk6@srv1.mail-tester.com");
$content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");
$mail = new SendGrid\Mail($from, $subject, $to, $content);
$apiKey = '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';
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);
//print_r($sg);
echo $response->statusCode();

