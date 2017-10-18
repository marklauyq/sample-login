# Simple Login

## Introduction
A simple registration and login system

This application allows you to create and login with a set of email and password
Users are than able to view their login activity that is stored in a redis server

This application uses the [Laravel 5.5 framework](https://laravel.com/docs/5.5)

## API

Clients are able to register and view retrieve users login activity.

API routes are secured using [Laravel Passport](https://laravel.com/docs/5.5/passport)

There are 2 main authentication methods used
* Client Grant
* Password Grant

For the examples below, i will be using guzzle to show how the call is made

#### Client Grant
Used for routes that do not require login such as the registration process

1. first Make a call to `/oauth/token` with the following int the form body

   ```php
   $guzzle = new GuzzleHttp\Client;

   $response = $guzzle->post('http://your-app.com/oauth/token', [
       'form_params' => [
           'grant_type' => 'client_credentials',
           'client_id' => '3', 
           'client_secret' => 'secret',
           'scope' => '*',
       ],
   ]);
   
   json_decode((string) $response->getBody(), true)['access_token'];
   ```
   
   The client_id can be found in the database by running the following `select * oauth_client;`
   
 2. After making the call, you will get an access token which will allow you to make a request to the registration route
    
    ```php
    $guzzle = new GuzzleHttp\Client;
    
    $response = $guzzle->post('http://your-app.com/api/register', [
         'form_params' => [
            'name' => 'Mark',
            'email' => 'mark001@tester.com', 
            'password' => 'password',
            'password_confirmation' => 'password',
         ],  
        'headers' => [
            'Authorization' => 'Bearer <access-token>'
         ], 
    ]);
    
    json_decode((string) $response->getBody(), true)
    ```
    
    insert the access token from step 1 inside the `<access-token>`


#### Password Grant
The password grant is used to log the user into the application and use the access grant to gain access
to all the user specific end points

1. first Make a call to `/oauth/token` with the following int the form body

   ```php
   $guzzle = new GuzzleHttp\Client;

   $response = $guzzle->post('http://your-app.com/oauth/token', [
       'form_params' => [
           'grant_type' => 'password',
           'client_id' => '4', 
           'client_secret' => 'secret',
           'username' => 'mark001@tester.com', 
           'password' => 'password',
           'scope' => '',
       ],
   ]);
   
   json_decode((string) $response->getBody(), true)['access_token'];
   ```
   
   This step is similar to the Client grant but users will not be allowed to create users and and the client
   access token will not be allowed to access user resources
   
2. Use the access token to make a request to the user resource
       
    ```php
   $guzzle = new GuzzleHttp\Client;
   
   $response = $guzzle->get('http://your-app.com/api/register', [ 
       'headers' => [
           'Authorization' => 'Bearer <access-token>'
        ], 
   ]);
   
   json_decode((string) $response->getBody(), true)
    ```
       
   insert the access token from step 1 inside the `<access-token>`