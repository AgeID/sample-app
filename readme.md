AgeID Integration 
====

This is a sample application how to integrate with AgeID (https://www.ageid.com) written in Laravel.



Installation
---


__Requirements:__

* PHP7
* Composer
* Node.js 


Download the application archive or clone the repository from Github:

    git clone https://github.com/AgeID/sample-app.git
    

In the project directory, please run:

    composer install
    npm install
    npm run prod

In order to configure the application, first please make a copy of the example file:    

    cp .env.example .env

You need to set the following parameters:

| Name              | Description 
|---                |---     
|APP_URL            | Your application/website url where is installed. Default: http://localhost     
|AGEID_URL          | The AgeID website URL. For development/staging environment, please check with Customer Support 
|AGEID_KEY          | Secret key provided in your business account
|AGEID_CLIENT_ID    | Client id provided in your business account
|AGEID_CALLBACK_URL | Callback url set as _APP_URL_/ageIdCallback E.g. http://localhost/ageIdCallback
|AGEID_REDIRECT_URL | Redirect url set as _APP_URL_/ageIdRedirectCallback E.g. http://localhost/ageIdRedirectCallback
|AGEID_TIMEOUT      | Timeout in minutes while is waiting for verification. Default: 60



    
Make sure _storage_ and _bootstrap/cache_ folder is writable by http server. 

After installing, you should configure your web server's document / web root to be the  _public_ directory. 