<?php
declare( strict_types=1 );
require_once 'vendor/autoload.php';

$client = new Gitlab\Client();
$client->setUrl(getenv('GITLAB_SERVER'));
$client->authenticate(getenv('GITLAB_ACCESS_TOKEN'), Gitlab\Client::AUTH_HTTP_TOKEN);

$projects = $client->projects()->all();
foreach($projects as $project) {
	printf("%d %s (%s)\n",
        $project['id'],
        $project['name_with_namespace'],
        $project['path_with_namespace']
    );
}
