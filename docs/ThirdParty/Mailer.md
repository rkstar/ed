# ThirdParty.Mailer

The `Mailer` class extends `PHPMailer` and provides a setup constructor method that uses defines you can add to your `custom.php` config file.  All of the properties below can be overridden after the class is instantiated.

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("ThirdParty.Mailer");

$mail = new Mailer();
$mail->addAddress("rkstar@mac.com");
$mail->IsHtml();
$mail->Subject = "This is awesome.";
$mail->Body    = "<h1>PHPMailer is a pretty wicked class.</h1> Holla if ya hear me!";
$mail->Send();
```

## Documentation Index

* [Dependencies](#dependencies)
* [Properties](#properties)

## Dependencies

* [**PHPMailer**](https://code.google.com/a/apache-extras.org/p/phpmailer/): An open source PHP library to make sending complex email formats easier

## Properties

#### NOTIFICATION_EMAIL_FROM_ADDRESS
> sets the `From` address in the email headers

#### NOTIFICATION_EMAIL_FROM_NAME
> sets the `From` name in the email headers

#### NOTIFICATION_EMAIL_HOST
> sets the host that the email server will use to send emails

#### NOTIFICATION_EMAIL_PORT
> sets the port number that the email server will use to send emails

#### NOTIFICATION_EMAIL_PRIORITY
> sets the priority header of the email

#### NOTIFICATION_EMAIL_ALTBODY
> sets the `altbody` text when sending HTML emails

#### NOTIFICATION_SMTP_AUTH_REQUIRED
> tells the class whether or not SMTP authentication is required

#### NOTIFICATION_SMTP_AUTH_USERNAME
> the SMTP username

#### NOTIFICATION_SMTP_AUTH_PASSWORD
> the SMTP password