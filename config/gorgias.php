<?php
return [
    'service' => env('GORGIAS_SERVICE_ENABLE', true),
    'base_api_url' => env('GORGIAS_BASE_API_URL', 'https://audienhearing.gorgias.com/api/tickets'),
    'username' => env('GORGIAS_USERNAME', 'adnan@betatech.co'),
    'password' => env('GORGIAS_PASSWORD', '42d0ffe5be4592e55dc258f60bc77463aad5a6918556d8597851d56eb71bde34'),
    'purchased_from' => env('GORGIAS_PURCHASED_FROM', 'Amazon'),
    'ticket_subject' => env('GORGIAS_TICKET_SUBJECT', 'Critical Review from Gift Funnel'),
    'tag_name' => env('GORGIAS_TICKET_TAG_NAME', 'VOC-Initiative'),
    'tag_id' => env('GORGIAS_TICKET_TAG_ID', '1133155'),
];
