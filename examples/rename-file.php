<?php
declare( strict_types=1 );

require_once 'vendor/autoload.php';

$client = new Gitlab\Client();
$client->setUrl(getenv('GITLAB_SERVER'));
$client->authenticate(getenv('GITLAB_ACCESS_TOKEN'), Gitlab\Client::AUTH_HTTP_TOKEN);

$branch = $argv[1];
$oldfilename = $argv[2];
$newfilename = $argv[3];
$commitmessage = $argv[4];

$commit = $client->repositories()->createCommit( 'foppelfb/demo-talk', parameters: [
    'branch'=>$branch,
    'commit_message'=>$commitmessage,
    'actions'=>[
        [
            'action'=>'move',
            'previous_path'=>$oldfilename,
            'file_path'=> $newfilename,
        ]
    ],
    'author_email'=>'fberger@sudhaus7.de',
    'author_name'=>'The other Franky',
] );
print_r($commit);
