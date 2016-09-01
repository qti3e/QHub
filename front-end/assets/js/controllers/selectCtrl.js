'use strict';
/**
 * AngularJS default filter with the following expression:
 * "person in people | filter: {name: $select.search, age: $select.search}"
 * performs a AND between 'name: $select.search' and 'age: $select.search'.
 * We want to perform a OR.
 */
app.filter('propsFilter', function () {
    return function (items, props) {
        var out = [];

        if (angular.isArray(items)) {
            items.forEach(function (item) {
                var itemMatches = false;

                var keys = Object.keys(props);
                for (var i = 0; i < keys.length; i++) {
                    var prop = keys[i];
                    var text = props[prop].toLowerCase();
                    if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
                        itemMatches = true;
                        break;
                    }
                }

                if (itemMatches) {
                    out.push(item);
                }
            });
        } else {
            // Let the output be the input untouched
            out = items;
        }

        return out;
    };
});

app.controller('SelectCtrl', function ($scope, $http, $timeout) {
    $scope.disabled = undefined;
    $scope.searchEnabled = undefined;

    $scope.enable = function () {
        $scope.disabled = false;
    };

    $scope.disable = function () {
        $scope.disabled = true;
    };

    $scope.enableSearch = function () {
        $scope.searchEnabled = true;
    }

    $scope.disableSearch = function () {
        $scope.searchEnabled = false;
    }

    $scope.clear = function () {
        $scope.person.selected = undefined;
        $scope.address.selected = undefined;
        $scope.country.selected = undefined;
    };

    $scope.someGroupFn = function (item) {

        if (item.name[0] >= 'A' && item.name[0] <= 'M')
            return 'From A - M';

        if (item.name[0] >= 'N' && item.name[0] <= 'Z')
            return 'From N - Z';

    };

    $scope.personAsync = {};
    $scope.peopleAsync = [];

    $timeout(function () {
        $scope.peopleAsync = [
             { name: 'Adam', email: 'adam@email.com', age: 12, country: 'United States' },
             { name: 'Amalie', email: 'amalie@email.com', age: 12, country: 'Argentina' },
             { name: 'Estefanía', email: 'estefania@email.com', age: 21, country: 'Argentina' },
             { name: 'Adrian', email: 'adrian@email.com', age: 21, country: 'Ecuador' },
             { name: 'Wladimir', email: 'wladimir@email.com', age: 30, country: 'Ecuador' },
             { name: 'Samantha', email: 'samantha@email.com', age: 30, country: 'United States' },
             { name: 'Nicole', email: 'nicole@email.com', age: 43, country: 'Colombia' },
             { name: 'Natasha', email: 'natasha@email.com', age: 54, country: 'Ecuador' },
             { name: 'Michael', email: 'michael@email.com', age: 15, country: 'Colombia' },
             { name: 'Nicolás', email: 'nicole@email.com', age: 43, country: 'Colombia' }
        ];
    }, 3000);

    $scope.counter = 0;
    $scope.someFunction = function (item, model) {
        $scope.counter++;
        $scope.eventResult = { item: item, model: model };
    };

    $scope.removed = function (item, model) {
        $scope.lastRemoved = {
            item: item,
            model: model
        };
    };

    $scope.tagTransform = function (newTag) {
        var item = {
            name: newTag,
            email: newTag + '@email.com',
            age: 'unknown',
            country: 'unknown'
        };

        return item;
    };

    $scope.person = {};
    $scope.people = [
      { name: 'Adam', email: 'adam@email.com', age: 12, country: 'United States' },
      { name: 'Amalie', email: 'amalie@email.com', age: 12, country: 'Argentina' },
      { name: 'Estefanía', email: 'estefania@email.com', age: 21, country: 'Argentina' },
      { name: 'Adrian', email: 'adrian@email.com', age: 21, country: 'Ecuador' },
      { name: 'Wladimir', email: 'wladimir@email.com', age: 30, country: 'Ecuador' },
      { name: 'Samantha', email: 'samantha@email.com', age: 30, country: 'United States' },
      { name: 'Nicole', email: 'nicole@email.com', age: 43, country: 'Colombia' },
      { name: 'Natasha', email: 'natasha@email.com', age: 54, country: 'Ecuador' },
      { name: 'Michael', email: 'michael@email.com', age: 15, country: 'Colombia' },
      { name: 'Nicolás', email: 'nicolas@email.com', age: 43, country: 'Colombia' }
    ];

    $scope.multipleDemo = {};
    $scope.multipleDemo.selectedPeople = [];
    $scope.multipleDemo.selectedPeople2 = $scope.multipleDemo.selectedPeople;
    $scope.multipleDemo.selectedPeopleWithGroupBy = [];
    $scope.multipleDemo.selectedPeopleSimple = [];
});
