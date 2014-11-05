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
            <material-toolbar scroll-shrink class="material-theme-indigo">
                <div class="material-toolbar-tools" layout="horizontal">
                    <material-button ng-click="methods.toggleMenu()" hide-md>
                        <material-icon icon="img/svg/menu_wht.svg" style="width: 24px; height: 24px;"></material-icon>
                    </material-button>
                    <div>EventosMDP</div>
                </div>
            </material-toolbar>
            <material-content class="emdp-body" layout="horizontal" flex data-ng-cloak>
                <material-sidenav class="material-sidenav-left material-whiteframe-z2" component-id="left">
                    <material-toolbar class="material-theme-light" ng-show="persona.logged">
                        <section id="eventosmdp-profile">
                            <div layout="horizontal" layout-sm="horizontal" layout-align="start center">
                                <div class="material-tile-left emdp-material-tile" layout="horizontal" layout-align="center start">
                                    <img data-ng-src="{{ persona.pic }}" alt="Perfil" width="48" height="48"/>
                                </div>
                                <div flex>
                                    <div class="eventosmdp-profile-name">{{ persona.name }}</div>
                                </div>
                            </div>
                        </section>
                    </material-toolbar>
                    <material-content class="eventosmdp-sidenav material-content" layout="vertical">
                        <section id="eventosmdp-profile" ng-show="!persona.logged">
                            <emdp-login-form></emdp-login-form>
                        </section>
                        <section class="eventosmdp-logged" ng-show="persona.logged">
                            <!--<section class="emdp-search">
                                <emdp-material-input
                                    layout-align="center"
                                    fid="search"
                                    label="Buscar"
                                    type="search"
                                    value="search"
                                    class="material-input-group-theme-light-blue material-input-group-inverted">
                                </emdp-material-input>
                            </section>
                            <material-divider class="emdp-divider"></material-divider>-->
                            <emdp-action
                                ng-repeat="action in actions.list | filter:persona.user.type"
                                name="{{ action.name }}"
                                action="{{ action.action }}"
                                icon="{{ action.icon }}"></emdp-action>
                        </section>
                    </material-content>
                </material-sidenav>
                <material-content flex class="emdp-cardlist-background">
                    <div class="eventosmdp-content"
                         layout="horizontal"
                         layout-fill
                         layout-align="center"
                         ui-view="content"></div>
                </material-content>
            </material-content>
        </div>
        <script src="bower_components/lodash/dist/lodash.js"></script>
        <script src="bower_components/datejs/build/date-es-AR.js"></script>
        <script src="bower_components/angular/angular.js"></script>
        <script src="bower_components/angular-i18n/angular-locale_es-ar.js"></script>
        <script src="bower_components/angular-aria/angular-aria.js"></script>
        <script src="bower_components/angular-animate/angular-animate.js"></script>
        <script src="bower_components/hammerjs/hammer.js"></script>
        <script src="bower_components/angular-material/angular-material.js"></script>
        <script src="bower_components/angular-ui-router/release/angular-ui-router.js"></script>
        <script src="bower_components/angular-facebook/lib/angular-facebook.js"></script>
        <script src="bower_components/angular-facebook/lib/angular-facebook.js"></script>
        <script src="frontend/app/app.js"></script>
        <script src="frontend/view/frontend.controllers.js"></script>
        <script src="frontend/view/frontend.directives.js"></script>
        <script src="frontend/view/frontend.services.js"></script>
        <script src="frontend/users/user.services.js"></script>
        <script src="frontend/events/events.services.js"></script>

    </body>
</html>