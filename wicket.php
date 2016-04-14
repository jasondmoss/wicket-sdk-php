<?php
require_once "vendor/autoload.php";

// todo: DotENV

$API_APP_KEY = 'WICKET_APP_KEY';
$API_JWT_SECRET = '0e292dd9eaaa5e33169a8528cf8ea5051ad20f61828d7cfe2622b7780ceab29a90d609285c2b19f0a75317e98511ac45366ce44de81bbb7221970c6e51236a7d';
$PERSON_ID = 'df1c90c1-1855-4f14-b3d1-293163deb2e2';

// SDK

$client = new Wicket\Client($API_APP_KEY, $API_JWT_SECRET);
$client->authorize($PERSON_ID);

$orgs = $client->organizations->all();

//$orgs->each(function ($org) {
//	printf("%s |%d| [%-9s] %7s : %s\n"
//		, $org['id']
//		, $org['attributes']['ancestry']
//		, $org['attributes']['type']
//		, $org['attributes']['alternate_name']
//		, $org['attributes']['legal_name']
//	);
//});

/** @var \Wicket\Entities\Organizations $org_cpa */
$org_cpa = $client->organizations->fetch($orgs->last()['id']);

//printf("o.id: %s\n", $org_cpa->id);
//printf("o.type: %s\n", $org_cpa->type);
//printf("o.legal_name: %s\n", $org_cpa->legal_name);

$peeps = $client->people->all();

$scott = $peeps->search(function ($person) {
	return $person['attributes']['given_name'] == 'Scott';
});
$scott_user_id = $peeps->get($scott)['id'];

$scott = $client->people->fetch($scott_user_id);

//print_r('SCOTT: ');
//print_r($scott);
//printf("scott.name: %s\n", $scott->alternate_name);

$eml = new \Wicket\Entities\Emails([
	'address' => sprintf('s+%d@ind.ninja', rand(10000, 99999)),
	'primary' => true,
]);

$phone = new \Wicket\Entities\Phones([
	'area_code' => sprintf('%d', rand(100, 999)),
	'number'    => sprintf('%d-%d', rand(100, 999), rand(1000, 9999)),
]);

$phone2 = new \Wicket\Entities\Phones([
	'area_code' => sprintf('%d', rand(100, 999)),
	'number'    => sprintf('%d-%d', rand(100, 999), rand(1000, 9999)),
	'extension' => sprintf('%d', rand(100, 999)),
]);

$person = new \Wicket\Entities\People([
	'given_name'  => sprintf('Alice%d', rand(10000, 99999)),
	'family_name' => sprintf('Smith%d', rand(10000, 99999)),
]);

$person->attach($eml);
$person->attach($phone);
$person->attach($phone2);

$client->people->create($person, $org_cpa);

// #booya

