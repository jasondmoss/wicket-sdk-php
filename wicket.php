<?php

require_once "vendor/autoload.php";

// DotENV

$API_APP_KEY = 'WICKET_APP_KEY';
$API_JWT_SECRET = '0e292dd9eaaa5e33169a8528cf8ea5051ad20f61828d7cfe2622b7780ceab29a90d609285c2b19f0a75317e98511ac45366ce44de81bbb7221970c6e51236a7d';
$person_id = 'df1c90c1-1855-4f14-b3d1-293163deb2e2';
$org_uuid = 'ca23bab4-6dfc-4f71-b6d8-a4c3478c7495';

// SDK

$client = new Wicket\Client($API_APP_KEY, $API_JWT_SECRET);
$client->authorize($person_id);

$org = $client->organizations->all();
$orgs = $org['data'];
foreach ($orgs as $org) {
	printf("%s |%d| [%-9s] %7s : %s\n"
		, $org['id']
		, $org['attributes']['ancestry']
		, $org['attributes']['type']
		, $org['attributes']['alternate_name']
		, $org['attributes']['legal_name']
	);
}

$org_cpa = $client->organizations->fetch('ca23bab4-6dfc-4f71-b6d8-a4c3478c7495');

var_dump($org_cpa);

printf("o.id: %s\n", $org_cpa->id);
printf("o.type: %s\n", $org_cpa->type);
printf("o.legal_name: %s\n", $org_cpa->legal_name);

$peeps = $client->people->all()['data'];
$scott = $client->people->fetch('cc2ffffe-4768-485a-a61d-0ac62e4b515b');

print_r('SCOTT: ');
print_r($scott);
printf("s.name: %s\n", $scott->alternate_name);


die;

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
//$res = $client->get('people');

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
