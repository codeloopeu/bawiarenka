<?php declare(strict_types = 1);

include_once('helpers/HttpHelper.php');
include_once('helpers/JsonHelper.php');
include_once('helpers/DatabaseHelper.php');
include_once('helpers/DomainHelper.php');

HttpHelper::checkIfPostOrDie();
$domain = DomainHelper::getDomainOrDie();
$json = JsonHelper::getJsonFromBodyOrDie();

DatabaseHelper::insert('tracking', array(
    'domain' => $domain,
    'session_id' => @$json['sessionId'],
    'event_datetime' => @$json['eventDatetime'],
    'metadata' => json_encode(@$json['metadata'])
));

HttpHelper::setNoContentResponseStatusCode();
