/*****************************************************************************
 *         In the name of God the Most Beneficent the Most Merciful          *
 *___________________________________________________________________________*
 *   This program is free software: you can redistribute it and/or modify    *
 *   it under the terms of the GNU General Public License as published by    *
 *   the Free Software Foundation, either version 3 of the License, or       *
 *   (at your option) any later version.                                     *
 *___________________________________________________________________________*
 *   This program is distributed in the hope that it will be useful,         *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of          *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           *
 *   GNU General Public License for more details.                            *
 *___________________________________________________________________________*
 *   You should have received a copy of the GNU General Public License       *
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.   *
 *___________________________________________________________________________*
 *                             Created by  Qti3e                             *
 *        <http://Qti3e.Github.io>    LO-VE    <Qti3eQti3e@Gmail.com>        *
 *****************************************************************************/

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

app.controller('newRepositoryCtrl',function ($scope,flowFactory) {

    $scope.removeImage = function () {
        $scope.noImage = true;
    };
    $scope.obj = new Flow();


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
    };

    $scope.disableSearch = function () {
        $scope.searchEnabled = false;
    };

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

    $scope.team             = {};
    $scope.team.readOnly    = {};
    $scope.team.write       = {};
});