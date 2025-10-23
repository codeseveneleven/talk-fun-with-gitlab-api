<?php
declare( strict_types=1 );

require_once 'vendor/autoload.php';

$client = new Gitlab\Client();
$client->setUrl('https://gitlab.com/');
$client->authenticate(getenv('GITLAB_ACCESS_TOKEN'), Gitlab\Client::AUTH_HTTP_TOKEN);

$issue = $client->issues()->create('foppelfb/demo-talk',[
	'title'=>$argv[1],
	'description'=>$argv[2]
]);
printf("%d %s %s (%s)\n%s\n",
	$issue['id'],
	$issue['project_id'],
	$issue['title'],
	$issue['author']['name'],
	$issue['web_url']
);
