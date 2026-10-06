<?php declare(strict_types = 1);

include_once('helpers/HttpHelper.php');
include_once('helpers/JsonHelper.php');
include_once('helpers/DatabaseHelper.php');
include_once('helpers/DomainHelper.php');

HttpHelper::checkIfPostOrDie();
$domain = DomainHelper::getDomainOrDie();
$json = JsonHelper::getJsonFromBodyOrDie();

DatabaseHelper::insert('sessions', array(
    'domain' => $domain,
    'id' => @$json['sessionId'],
    'client_id' => @$json['ref'],
    'browser_id' => @$json['browserId'],
    'event_datetime' => @$json['eventDatetime'],
    'metadata' => json_encode(@$json['metadata'])
));

HttpHelper::setNoContentResponseStatusCode();
