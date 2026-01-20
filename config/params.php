<?php

$env = is_file(__DIR__ . '/params-env.php') ? require __DIR__ . '/params-env.php' : [];

return array_merge([
    'cookieValidationKey' => 'this_is_not_secret_u_looking_for', // create params-env.php and declare key

    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
], $env);
