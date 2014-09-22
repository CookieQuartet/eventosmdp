<!DOCTYPE html>
<html ng-app="app">
    <head>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="bower_components/angular-material/angular-material.css">
        <link rel="stylesheet" href="css/eventosmdp.css"/>
    </head>
    <body data-ng-controller="MainController">

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">

                    <div class="page-header">
                        <h1>Hello angular-facebook! <small><a href="http://www.facebook.com/luiscarlosjayk" target="_blank">by Ciul</a></small> </h1>
                    </div>

                    <div>
                        <div class="alert alert-info" data-ng-show="salutation">Hello, {{user.name}}</div>
                        <div class="alert alert-warning" data-ng-show="byebye">Bye bye :'(</div>
                    </div>

                    <button type="button" class="btn btn-primary btn-large" data-ng-show="!logged" data-ng-disabled="!facebookReady" data-ng-click="IntentLogin()">Login with Facebook</button>
                    <button type="button" class="btn btn-danger btn-large" data-ng-show="logged" data-ng-disabled="!facebookReady" data-ng-click="logout()">Logout</button>

                    <div>
                        <debug val="user"></debug>
                    </div>

                </div>
            </div>
        </div>

        <script src="bower_components/angular/angular.js"></script>
        <script src="bower_components/angular-animate/angular-animate.js"></script>
        <script src="bower_components/hammerjs/hammer.js"></script>
        <script src="bower_components/angular-material/angular-material.js"></script>
        <script src="bower_components/angular-facebook/lib/angular-facebook.js"></script>
        <script src="js/app/app.js"></script>

    </body>
</html>