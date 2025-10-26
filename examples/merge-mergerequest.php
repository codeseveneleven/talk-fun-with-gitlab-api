<?php
declare( strict_types=1 );

require_once 'vendor/autoload.php';


$client = new Gitlab\Client();
$client->setUrl('https://gitlab.com/');
$client->authenticate(getenv('GITLAB_ACCESS_TOKEN'), Gitlab\Client::AUTH_HTTP_TOKEN);

$iid = (int)$argv[1];

$mr = $client->mergeRequests()->show( 'foppelfb/demo-talk', $iid);
if ($mr['detailed_merge_status'] === 'mergeable' && (int)$mr['user']['can_merge']===1) {
    $mrResult = $client->mergeRequests()->merge( 'foppelfb/demo-talk', $iid);
    printf("%s\n",$mrResult['merged_at']);
} else {
    printf("ERROR: %s: %s - user can merge: %d\n",
        $mr['merge_status'],
        $mr['detailed_merge_status'],
        $mr['user']['can_merge']
    );
}
