<?php

namespace App;
use Phore\MicroApp\App;
use Phore\MicroApp\Handler\JsonExceptionHandler;
use Phore\MicroApp\Handler\JsonResponseHandler;
use Phore\MicroApp\Helper\CORSHelper;
use Phore\MicroApp\Response\JsonResponse;
use Phore\MicroApp\Type\QueryParams;
use Phore\MicroApp\Type\Request;
use Phore\MicroApp\Type\RouteParams;


require __DIR__ . "/../vendor/autoload.php";

$app = new App();
$app->activateExceptionErrorHandlers();
$app->setOnExceptionHandler(new JsonExceptionHandler());
$app->setResponseHandler(new JsonResponseHandler());

$app->assets()->addAssetSearchPath(__DIR__ . "/assets/");


/**
 ** Configure Access Control Lists
 **/
$app->acl->addRule(\aclRule()->route("/*")->ALLOW());



/**
 ** Define Routes
 **/
$app->router->on("*", ["GET", "POST", "PUT", "DELETE"], function (QueryParams $params, Request $request) {

    $responseCode = $params->get("code", 200);

    $body = null;
    if ($request->requestMethod !== "GET")
        $body = $request->getBody();
    $data = [
        "endpoint" => "Talpa Mock Api",
        "requestMethod" => $request->requestMethod,
        "route" => $request->requestPath,
        "headers" => getallheaders(),
        "body" => $body
    ];


    file_put_contents("/tmp/log", phore_json_pretty_print(phore_json_encode($data)), FILE_APPEND);

    return new JsonResponse($data, [], $responseCode);



});

/**
 ** Run the application
 **/
$app->serve();
