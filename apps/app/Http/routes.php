<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) 
{
    return 'Welcome Thunder Document Service';
});

$api 							= app('Dingo\Api\Routing\Router');

$app->get('/templates',
	[
		'uses'				=> 'TemplateController@index',
		// 'middleware'		=> 'jwt|company:read-template',
	]
);

$app->post('/templates',
	[
		'uses'				=> 'TemplateController@post',
		// 'middleware'		=> 'jwt|company:store-template',
	]
);

$app->delete('/templates',
	[
		'uses'				=> 'TemplateController@delete',
		// 'middleware'		=> 'jwt|company:delete-template',
	]
);

$app->get('/documents',
	[
		'uses'				=> 'DocumentController@index',
		// 'middleware'		=> 'jwt|company:read-document',
	]
);

$app->post('/documents',
	[
		'uses'				=> 'DocumentController@post',
		// 'middleware'		=> 'jwt|company:store-document',
	]
);

$app->delete('/documents',
	[
		'uses'				=> 'DocumentController@delete',
		// 'middleware'		=> 'jwt|company:delete-document',
	]
);