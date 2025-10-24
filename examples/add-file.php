<?php
declare( strict_types=1 );

require_once 'vendor/autoload.php';

$client = new Gitlab\Client();
$client->setUrl(getenv('GITLAB_SERVER'));
$client->authenticate(getenv('GITLAB_ACCESS_TOKEN'), Gitlab\Client::AUTH_HTTP_TOKEN);

$branch = $argv[1];
$file = trim($argv[2],'/');
$content = file_get_contents( $argv[2]);
$message = $argv[3];

try {
	$raw = $client->repositoryFiles()->getRawFile('foppelfb/demo-talk', $file, $branch);
} catch (Gitlab\Exception\RuntimeException $e) {
	$raw = null;
}

$payload = [
	'file_path' => $file,
	'branch' => $branch,
	'content' => $content,
	'commit_message' => $message,
	'author_email' => 'fberger@sudhaus7.de',
	'author_name' => 'Its a me, Franky',
];

$result = match(true) {
	$raw===null => $client->repositoryFiles()
      ->createFile('foppelfb/demo-talk', $payload),
	default => $client->repositoryFiles()
      ->updateFile('foppelfb/demo-talk', $payload)
};
print_r($result);
