
angular.module('app', ['users', 'view'])
    .value('emdpActions', {
      list: [
        {
          name: 'Perfil',
          icon: "img/svg/account.svg",
          action: ''
        },
        {
          name: 'Eventos',
          icon: "img/svg/map-marker.svg",
          action: ''
        },
        {
          name: 'Favoritos',
          icon: "img/svg/heart.svg",
          action: ''
        },
        {
          name: 'Mis Alertas',
          icon: "img/svg/bell.svg",
          action: ''
        },
        {
          name: 'Cerrar sesión',
          icon: "img/svg/exit-to-app.svg",
          action: 'fbUser.logout()'
        }
      ]
    });

