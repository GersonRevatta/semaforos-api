<?php

return [
  'default' => 'default',

  'documentations' => [
      'default' => [
          'api' => [
              'title' => 'Documentación de la API',
          ],

          'routes' => [
              'api' => 'api/documentation',
          ],

          'paths' => [
              'docs_json' => 'api-docs.json',
              'annotations' => [
                  base_path('app/Http/Controllers/API'),
              ],
          ],
      ],
  ],

  'paths' => [
      'docs' => storage_path('api-docs'),
      'annotations' => [
          base_path('app/Http/Controllers/API'),
      ],
      'base' => '/api/v1',
      'excludes' => [],
  ],

  'security' => [
      'api_key_security_example' => [
          'type' => 'apiKey',
          'description' => 'Introduce tu token de acceso en el encabezado Authorization.',
          'name' => 'Authorization',
          'in' => 'header',
      ],
  ],

  'generate_always' => false,

  'swagger_version' => env('L5_SWAGGER_VERSION', '3.0'),

  'constants' => [
      'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://localhost:8000/api/v1'),
  ],
];
