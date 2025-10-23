<?php
declare( strict_types=1 );
require_once 'vendor/autoload.php';

$client = new Gitlab\Client();
$client->setUrl('https://gitlab.com/');
$client->authenticate(getenv('GITLAB_ACCESS_TOKEN'), Gitlab\Client::AUTH_HTTP_TOKEN);

$projects = $client->projects()->all(['membership'=>true]);
foreach($projects as $project) {
	echo $project['id'],' ',$project['name_with_namespace'],' ',$project['path_with_namespace'],"\n";
}
