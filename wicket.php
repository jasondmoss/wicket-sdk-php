<?php

require_once "vendor/autoload.php";

// DotENV

$API_APP_KEY = 'wicket_app_key';
$API_JWT_SECRET = '0e292dd9eaaa5e33169a8528cf8ea5051ad20f61828d7cfe2622b7780ceab29a90d609285c2b19f0a75317e98511ac45366ce44de81bbb7221970c6e51236a7d';
$person_id = 'ef139c15-0829-49b5-b912-cbd5e23f3dd8';

// SDK

$client = new Wicket\Client($API_APP_KEY, $API_JWT_SECRET);

$client->authorize($person_id);

$org = $client->organization->all();

die($org);

//$res = $org[3];
//$res->name = 'xxx';

//$client->organization->update($res);

//$res = $client->organization->fetch('uuid');
//$res = $client->people->fetch('uuid');


/*
// resource style

$res = $wicket->organization->fetch('uuid');
$people = $res->people();

throw new WicketException()

// fluent style

$wicket->organizations('uuid')
->people // Wicket\Entitles\Person

// Resource ops
	->all()
	->find()
	->create()
	->update()
	->delete()
	->relationships()->sync()
	->relationships()->attach()
	->relationships()->detach()
*/

//$wicket->organizations('uuid')
//	->person
//	->create([
//		'fname' => '',
//		'lname' => '',
//		'username' => '',
//		'phone' => '',
//		'email' => '',
//	]);

// $wicket->organizations('uuid')
//	 ->address | phone | email ...
//   ->create([
//		
//	]);

//$person = $wicket->initPerson();
//$wicket->list('');
//$wicket->people('');

//$res = $wicket->get('organizations');
$res = $client->get('people');

$data = $res['data'][0];
print_r($data);

foreach ($res['data'] as $japi_org) {
	$org = $japi_org['attributes'];
	printf("[%s]\t%s\t%s\t%s\n"
		, $org['type']
		, $org['alternate_name']
		, $org['slug']
		, $org['uuid']
	);
}

/*
// Interface Ideas

// nouns


$wicket->user->list();

$new_user = [
	'name'  => 'uname',
	'email' => 'email',
//	...
];

$wicket->user->create($new_user);

// verbs

$wicket->list('user');
$wicket->create('user', $new_user);

$wicket->create('organization');
 

--- From PostMan

{
    "data": {
        "attributes": {
            "given_name": "baz",
            "family_name": "baz"
        },
        "relationships": {
            "emails": { 
                "data": [
                    { "type": "emails", "attributes": { "address": "t@ind.ninja", "primary": true } }
                ]
            }
        }
    }
}

new Person(
[
	"attributes" => [
		"given_name": "baz",
		"family_name": "baz"
	],
	"relationships" => [
		"emails": { 
			"data": [
				{ "type": "emails", "attributes": { "address": "t@ind.ninja", "primary": true } }
			]
		}
	]
]
);

$person->emails->push(new Email(['address', 'primary' => true]));

$person->setRelationship('emails' => [ new Email(['address', 'primary' => true]) ] );


	*/
