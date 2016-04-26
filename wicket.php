<?php
require_once "vendor/autoload.php";

// todo: DotENV

$API_APP_KEY = 'WICKET_APP_KEY';
$API_JWT_SECRET = '0e292dd9eaaa5e33169a8528cf8ea5051ad20f61828d7cfe2622b7780ceab29a90d609285c2b19f0a75317e98511ac45366ce44de81bbb7221970c6e51236a7d';
$PERSON_ID = '60dea886-f8f3-4c4d-aba7-3006ac02e97c';
$PERSON_ID = '9699f620-c452-4183-97de-4ac6adae661b';

// SDK

$client = new Wicket\Client(
	$API_APP_KEY
	, $API_JWT_SECRET
	, 'https://api.wicket.io'
);

$client->authorize($PERSON_ID);

$peeps = $client->people->all();
$peeps2 = $peeps->nextPage();
$purl = $peeps->url(3);
$peeps3 = $peeps->getPage($purl);

$orgs = $client->organizations->all();
$orgs2 = $orgs->nextPage();

/** @var \Wicket\Entities\Organizations $org_cpa */
//$org_cpa = $client->organizations->fetch($orgs->last()['id']);
//$org_cpa = $orgs->last();
$org_cpa_id = $orgs->search(function ($org) {
	return $org->alternate_name == 'CPA';
});
$org_cpa = $orgs->get($org_cpa_id);

//print_r($org_cpa); die;

$peeps = $client->people->all();

$scott = $peeps->search(function ($person) {
	return $person->given_name == 'Scott';
});

$scott_user_id = $peeps->get($scott)->id;

$scott = $client->people->fetch($scott_user_id);

$eml = new \Wicket\Entities\Emails([
	//'address' => sprintf('alice_smith+%d@ind.ninja', rand(10000, 99999)),
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

$fname = sprintf('Alice%d', rand(10000, 99999));
$lname = sprintf('Smith%d', rand(10000, 99999));
$person = new \Wicket\Entities\People([
	'given_name'  => $fname,
	'family_name' => $lname,
	'user'        => [
		'password'              => 'oicu812#BADA55',
		'password_confirmation' => 'oicu812#BADA55',
		'username'              => strtolower($fname . '.' . $lname),
	],
]);

$person->attach($eml);
$person->attach($phone);
$person->attach($phone2);

print_r('PERSON:');
print_r($person->toJsonAPI());

$new_person = $client->people->create($person, $org_cpa);

print_r('NEW_PERSON:');
print_r($new_person['data']);

// #booya

