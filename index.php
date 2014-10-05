<!DOCTYPE html>
<html ng-app="app">
    <head>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="bower_components/angular-material/angular-material.css">
        <link rel="stylesheet" href="css/eventosmdp.css"/>
    </head>
    <body data-ng-controller="AppController">
        <div layout="vertical" layout-fill>
            <material-toolbar scroll-shrink class="material-theme-light">
                <div class="material-toolbar-tools" layout="horizontal">
                    <material-button ng-click="methods.openLeftMenu()" hide-md>
                        <material-icon icon="img/svg/menu_wht.svg" style="width: 24px; height: 24px;"></material-icon>
                    </material-button>
                    <div>EventosMDP hola</div>
                </div>
            </material-toolbar>
            <material-content layout="horizontal" flex>
                <material-sidenav class="material-sidenav-left material-whiteframe-z2" component-id="left">
                    <material-toolbar class="material-theme-indigo">
                        <section id="eventosmdp-profile">
                            <div flex="33" class="eventosmdp-profile-img">
                                <img ng-src="{{ persona.pic }}" alt="Perfil" width="48" height="48"/>
                            </div>
                            <div class="eventosmdp-profile-name">{{ persona.name }}</div>
                        </section>
                    </material-toolbar>
                    <material-content class="eventosmdp-sidenav material-content" layout="vertical">
                        <section id="eventosmdp-profile" ng-show="!(persona.logged || persona.fbLogged)">
                            <div class="tabsLogin" layout="vertical" layout-align="center center">
                                <material-tabs selected="data.selectedIndex" center>
                                    <!--<material-tab label="Tenés cuenta?"></material-tab>-->
                                    <material-tab>
                                        <material-icon icon="img/svg/login.svg" style="width: 24px; height: 24px;"></material-icon>
                                    </material-tab>
                                    <material-tab>
                                        <material-icon icon="img/social/post-facebook_wht.svg" style="width: 24px; height: 24px;"></material-icon>
                                    </material-tab>
                                </material-tabs>
                                <div class="animate-switch-container" ng-switch on="data.selectedIndex">
                                    <div class="animate-switch tab1" layout="vertical" ng-switch-when="0" layout-align="center center">
                                        <section class="eventosmdp-login-inputs" ng-show="!(persona.logged || persona.fbLogged)">
                                            <ig layout-align="center" fid="email" label="Email" type="email" class="material-input-group-theme-light-blue material-input-group-inverted"></ig>
                                            <ig layout-align="center" fid="password" label="Contraseña" type="password" class="material-input-group-theme-light-blue material-input-group-inverted"></ig>
                                        </section>
                                        <section class="eventosmdp-login">
                                            <section class="eventosmdp-login-button" layout="vertical" layout-sm="horizontal" layout-align="center center" ng-show="!(persona.logged || persona.fbLogged)">
                                                <material-button class="material-button-raised material-button-colored">Entrar</material-button>
                                                <material-button class="material-button-raised material-button-colored material-theme-green">Nuevo</material-button>
                                            </section>
                                        </section>
                                    </div>
                                    <div class="animate-switch tab2" ng-switch-when="1">
                                        <section class="eventosmdp-login">
                                            <section class="eventosmdp-login-button" layout="vertical" layout-sm="horizontal" layout-align="center center" ng-show="!(persona.logged || persona.fbLogged)">
                                                <material-button class="material-button-raised material-button-colored" ng-show="!persona.fbLogged" data-ng-click="persona.fbUser.login()">
                                                    Entrá con Facebook
                                                </material-button>
                                            </section>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="eventosmdp-logged" ng-show="persona.logged || persona.fbLogged">
                            <emdp-action ng-repeat="action in actions.list" name="{{ action.name }}" action="{{ action.action }}" icon="{{ action.icon }}"></emdp-action>
                        </section>
                    </material-content>
                </material-sidenav>
                <material-content flex class="material-content-padding">

                    <div class="eventosmdp-content" layout="horizontal" layout-fill layout-align="center">


                    </div>

                </material-content>

            </material-content>

        </div>
        <script src="bower_components/angular/angular.js"></script>
        <script src="bower_components/angular-animate/angular-animate.js"></script>
        <script src="bower_components/hammerjs/hammer.js"></script>
        <script src="bower_components/angular-material/angular-material.js"></script>
        <script src="bower_components/angular-ui-router/release/angular-ui-router.js"></script>
        <script src="bower_components/angular-facebook/lib/angular-facebook.js"></script>
        <!--<script src="bower_components/angular-directive.g-signin/google-plus-signin.js"></script>-->
        <script src="frontend/app/app.js"></script>
        <script src="frontend/view/frontend.controllers.js"></script>
        <script src="frontend/view/frontend.directives.js"></script>
        <script src="frontend/users/user.services.js"></script>

    </body>
</html>