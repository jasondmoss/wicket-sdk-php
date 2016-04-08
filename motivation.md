# Dropbox

> https://www.dropbox.com/developers-v1/core/docs

```php
list($accessToken, $host) = \Dropbox\AuthInfo::loadFromJsonFile($nonOptionArgs[0]);
$client = new \Dropbox\Client($accessToken, "examples-$exampleName", $locale, $host);
$metadata = $client->uploadFile($dropboxPath, \Dropbox\WriteMode::add(), $fp, $size);
```

# Twitter

> https://dev.twitter.com/rest/reference/get/statuses/home_timeline

```php
$client = new \GuzzleHttp\Client(['base_url' => 'https://api.twitter.com/1.1/']);
$oauth = new Oauth1([ 'consumer_key' => '...', 'consumer_secret' => '...', 'token' => '...', 'token_secret' => '...', ]);
$client->getEmitter()->attach($oauth);
$res = $client->get('statuses/home_timeline.json', ['auth' => 'oauth'])->json();
```

# MailChimp

```php
use \DrewM\MailChimp\MailChimp;
$MailChimp = new MailChimp('abc123abc123abc123abc123abc123-us1');
```

Then, list all the mailing lists (with a get on the lists method)

```php
$result = $MailChimp->get('lists');
print_r($result);
```

Subscribe someone to a list (with a post to the list/{listID}/members method):

```php
$list_id = 'b1234346';
$result = $MailChimp->post("lists/$list_id/members", [
                'email_address' => 'davy@example.com',
                'status'        => 'subscribed',
            ]);
print_r($result);
```

Update a list member with more information (using patch to update):

```php
$list_id = 'b1234346';
$subscriber_hash = $MailChimp->subscriberHash('davy@example.com');
$result = $MailChimp->patch("lists/$list_id/members/$subscriber_hash", [
                'merge_fields' => ['FNAME'=>'Davy', 'LNAME'=>'Jones'],
                'interests'    => ['2s3a384h' => true],
            ]);
print_r($result);
```

Remove a list member using the delete method:

```php
$list_id = 'b1234346';
$subscriber_hash = $MailChimp->subscriberHash('davy@example.com');
$MailChimp->delete("lists/$list_id/members/$subscriber_hash");
```

