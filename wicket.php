<?php
require_once "vendor/autoload.php";

// todo: DotENV

$API_APP_KEY = 'WICKET_APP_KEY';
$API_JWT_SECRET = '0e292dd9eaaa5e33169a8528cf8ea5051ad20f61828d7cfe2622b7780ceab29a90d609285c2b19f0a75317e98511ac45366ce44de81bbb7221970c6e51236a7d';
$PERSON_ID = '942f28ae-dce8-4c41-918a-b3a6ffc6fe37';

// SDK

$client = new Wicket\Client(
	$API_APP_KEY,
	$API_JWT_SECRET,
	'https://api.wicket.io'
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
$org_cpa = $orgs->last();

$peeps = $client->people->all();

$scott = $peeps->search(function ($person) {
	return $person->given_name == 'Scott';
});

$scott_user_id = $peeps->get($scott)->id;

$scott = $client->people->fetch($scott_user_id);

die;

$eml = new \Wicket\Entities\Emails([
	'address' => sprintf('alice_smith+%d@ind.ninja', rand(10000, 99999)),
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

$new_person = $client->people->create($person, $org_cpa);

// #booya

