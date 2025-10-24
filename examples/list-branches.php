<?php
declare( strict_types=1 );

require_once 'vendor/autoload.php';


$client = new Gitlab\Client();
$client->setUrl(getenv('GITLAB_SERVER'));
$client->authenticate(getenv('GITLAB_ACCESS_TOKEN'), Gitlab\Client::AUTH_HTTP_TOKEN);

$branches = $client->repositories()->branches('foppelfb/demo-talk');
foreach($branches as $branch) {
	printf("%s : Last commit %s (%s)\n%s: %s\n\n",
		$branch['name'],
		$branch['commit']['short_id'],
		$branch['commit']['created_at'],
		$branch['commit']['author_name'],
		$branch['commit']['title']
	);
}
