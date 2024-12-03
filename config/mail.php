<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | Este valor define el "mailer" predeterminado que se usará para enviar
    | correos electrónicos. Asegúrate de que coincida con el transporte
    | configurado en el bloque "mailers".
    |
    */

    'default' => 'smtp',

    /*
    |--------------------------------------------------------------------------
    | Configuración de Mailers
    |--------------------------------------------------------------------------
    |
    | Aquí defines la configuración para cada "mailer" que tu aplicación usa.
    | En este caso, configuraremos el "smtp" con todos los valores necesarios.
    |
    */

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => 'mail.cuestionariosmedic.com',
            'port' => 465,
            'encryption' => 'ssl',
            'username' => 'soporte@cuestionariosmedic.com',
            'password' => '}YyEuXtAtVgw',
            'timeout' => null,
            'local_domain' => 'cuestionariosmedic.com',
            'stream' => [ // Configuración avanzada SSL/TLS
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dirección "From" Global
    |--------------------------------------------------------------------------
    |
    | Todos los correos electrónicos enviados por la aplicación usarán esta
    | dirección como la dirección de origen. Asegúrate de configurarla.
    |
    */

    'from' => [
        'address' => 'soporte@cuestionariosmedic.com',
        'name' => 'Cuestionarios Medic',
    ],

    /*
    |--------------------------------------------------------------------------
    | Opciones de Log
    |--------------------------------------------------------------------------
    |
    | Configuración para registrar correos en los logs en lugar de enviarlos.
    |
    */

    'log_channel' => env('MAIL_LOG_CHANNEL'),

];
