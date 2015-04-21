(function(angular, $, _) {

  angular.module('mycontacttab').config(function($routeProvider) {
      $routeProvider.when('/about-me', {
        controller: 'MycontacttabAboutMe',
        templateUrl: '~/mycontacttab/AboutMe.html',

        // If you need to look up data when opening the page, list it out
        // under "resolve".
        resolve: {
          myContact: function(crmApi) {
            return crmApi('Contact', 'getsingle', {
              id: 'user_contact_id',
              return: ['first_name', 'last_name']
            });
          },
          myRelationships: function(crmApi){
            return crmApi('Relationship', 'get', {
              "sequential": 1,
              "contact_id_a": 203
            });
          }
        }
      });
    }
  );

  // The controller uses *injection*. This default injects a few things:
  //   $scope -- This is the set of variables shared between JS and HTML.
  //   crmApi, crmStatus, crmUiHelp -- These are services provided by civicrm-core.
  //   myContact -- The current contact, defined above in config().
  angular.module('mycontacttab').controller('MycontacttabAboutMe', function($scope, crmApi, crmStatus, crmUiHelp, myContact, myRelationships, crmMetadata) {
    // The ts() and hs() functions help load strings for this module.
    var ts = $scope.ts = CRM.ts('mycontacttab');
    var hs = $scope.hs = crmUiHelp({file: 'CRM/mycontacttab/AboutMe'}); // See: templates/CRM/mycontacttab/AboutMe.hlp

    // We have myContact available in JS. We also want to reference it in HTML.
    $scope.myContact = myContact;
    $scope.myRelationships = myRelationships;
    crmMetadata.getFields('Relationship').then(function(fields){
      $scope.relFields = fields;
    });
    crmApi('RelationshipType', 'get', {}).then(function(relTypes){
      $scope.relTypes = relTypes;
    });

    $scope.save = function save() {
      return crmStatus(
        // Status messages. For defaults, just use "{}"
        {start: ts('Saving...'), success: ts('Saved')},
        // The save action. Note that crmApi() returns a promise.
        crmApi('Contact', 'create', {
          id: myContact.id,
          first_name: myContact.first_name,
          last_name: myContact.last_name
        })
      );
    };
  });

})(angular, CRM.$, CRM._);
