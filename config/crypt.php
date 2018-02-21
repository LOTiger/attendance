<?php
//基于laravel根目录，分隔符最好是用 DIRECTORY_SEPARATOR 常量代替
return [
    'rsa_api' => [
        'path'=>storage_path('key'),
        'private_key_file_name'=>'rsa_private_key.pem',
        'public_key_file_name' =>'rsa_public_key.pem',
        'openssl_config'=>[
            "digest_alg" => "sha1",
            "private_key_bits" => 1024,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ]
    ],
    'rsa_data'=>[
        'path'=>storage_path('key'),
        'private_key_file_name'=>'rsa_private_key.pem',
        'public_key_file_name' =>'rsa_public_key.pem',
        'openssl_config'=>[
            "digest_alg" => "sha1",
            "private_key_bits" => 1024,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ]
    ]
];