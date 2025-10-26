<?php
declare( strict_types=1 );

require_once 'vendor/autoload.php';

$client = new Gitlab\Client();
$client->setUrl('https://gitlab.com/');
$client->authenticate(getenv('GITLAB_ACCESS_TOKEN'), Gitlab\Client::AUTH_HTTP_TOKEN);

$srcBranch = $argv[1];
$tgtBranch = $argv[2];
$message = $argv[3];
$userid = 0;
$parameters = [
    'remove_source_branch'=>true,
    'squash'=>true,
];
if (isset($argv[4])) {
    $parameters['assignee_id'] = $argv[4];
}
try {
    $mr = $client->mergeRequests()->create(
        'foppelfb/demo-talk',
        $srcBranch,
        $tgtBranch,
        $message,
        $parameters
    );
    printf('[%d] %d %s (%s) %s / %s'."\n",
        $mr['iid'],
        $mr['id'],
        $mr['title'],
        $mr['state'],
        $mr['merge_status'],
        (int)$mr['user']['can_merge']===1 ? 'user can merge' : 'user can not merge'
    );
} catch (\Gitlab\Exception\RuntimeException $e) {
    // $e->getCode() == 409 - request exists
    echo $e->getCode(),' ',$e->getMessage(),"\n";
}

