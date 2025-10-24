<?php
declare( strict_types=1 );

require_once 'vendor/autoload.php';

$client = new Gitlab\Client();
$client->setUrl('https://gitlab.com/foppelfb/');
$client->authenticate(getenv('GITLAB_ACCESS_TOKEN'), Gitlab\Client::AUTH_HTTP_TOKEN);


$issues = $client->issues()->all('foppelfb/demo-talk');
foreach($issues as $issue) {
	printf("[%d] ID %d in %s: %s (%s)\n%s\n",
		$issue['id'],
		$issue['iid'],
		$issue['project_id'],
		$issue['title'],
		$issue['author']['name'],
		$issue['web_url']
	);
}

