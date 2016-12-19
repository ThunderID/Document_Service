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

$app->get('/templates',
	[
		'uses'				=> 'TemplateController@index',
	]
);

$app->post('/templates',
	[
		'uses'				=> 'TemplateController@post',
	]
);

$app->delete('/templates',
	[
		'uses'				=> 'TemplateController@delete',
	]
);

$app->get('/documents',
	[
		'uses'				=> 'DocumentController@index',
	]
);

$app->post('/documents',
	[
		'uses'				=> 'DocumentController@post',
	]
);

$app->delete('/documents',
	[
		'uses'				=> 'DocumentController@delete',
	]
);