<?php
/**
 * Created by graphql-client.
 * User: Ruslan Evchev
 * Date: 26.11.16
 * Email: aion.planet.com@gmail.com
 */

require_once '../../vendor/autoload.php';

$client = new \GraphQLClient\HttpClient('http://snd.dev/app_dev.php/api/graphql');
//add new contacts with variables
$builder = \QueryBuilder\Builder::createMutationBuilder(); //for query use - createQueryBuilder

$builder
    ->name('addContactToEmailList')
    ->arguments([
        'emailListId' => '583979cfaa0876133f2f9c11',
        'contacts'    => [
            [
                'name'      => 'Ruslan Evchev',
                'email'     => 'aion.planet.com1@gmail.com',
                'variables' => [
                    [
                        'name'  => 'test',
                        'value' => 'test',
                    ],
                    [
                        'name'  => 'firstName',
                        'value' => 'Ruslan',
                    ],
                ],
            ],
            [
                'name'      => 'Ruslan Evchev',
                'email'     => 'eve.planet.com@gmail.com',
                'variables' => [
                    [
                        'name'  => 'test',
                        'value' => 'test',
                    ],
                    [
                        'name'  => 'firstName',
                        'value' => 'Ruslan',
                    ],
                ],
                'active'    => false,
            ],
        ],
    ])
    //What we need in the response result structure
    ->body([
        'id',
        'contacts' => [
            'name',
            'email',
            'variables' => [
                'name',
                'value',
            ],
            'active',
        ],
    ]);
try {
    $data = $client->setApiKey('NjE5ODJlNGY2MGNjYTdlNzFjMGM4NjljZTMzOTJjYWY=')->call($builder);
    $requestId = $client->getRequestId();

    echo json_encode($data, 128);
    
} catch (\GraphQLClient\Util\DatableHttpException $e) {
    echo $e->getMessage();
}

//Response!
//{
//    "addContactToEmailList": {
//    "id": "583979cfaa0876133f2f9c11",
//        "contacts": [
//            {
//                "name": "Ruslan Evchev",
//                "email": "aion.planet.com1@gmail.com",
//                "variables": [
//                    {
//                        "name": "test",
//                        "value": "test"
//                    },
//                    {
//                        "name": "firstName",
//                        "value": "Ruslan"
//                    }
//                ],
//                "active": true
//            },
//            {
//                "name": "Ruslan Evchev",
//                "email": "eve.planet.com@gmail.com",
//                "variables": [
//                    {
//                        "name": "test",
//                        "value": "test"
//                    },
//                    {
//                        "name": "firstName",
//                        "value": "Ruslan"
//                    }
//                ],
//                "active": true
//            }
//        ]
//    }
//}




