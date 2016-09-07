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
        var re  = [];
        if(props.name === ''){
            return [];
        }
        items.forEach(function(item){
            var s   = false;
            if(props['age'] == item.age){
                s   = true;
            }else {
                for(var key in item){
                    if(item[key].search(props['name']) !== -1){
                        s   = true;
                        break;
                    }
                }
            }
            if(s){
                re.push(item);
            }
        });
        return re;
    };
});

app.controller('newRepositoryCtrl',function ($scope,flowFactory,api) {
    $scope.page     = 'form';
    $scope.details  = '';
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

    $scope.person = {};
    $scope.people = [];
    api.req('users',{}).then(function(data){
        data.data.forEach(function(item){
            $scope.people.push(item);
        });
    },angular.noop);

    $scope.name             = '';
    $scope.dec              = '';
    $scope.team             = {};
    $scope.team.readOnly    = {};
    $scope.team.write       = {};
    var getIds              = function(items){
        var re  = [];
        for(var key in items){
            re.push(items[key].id);
        }
        return re;
    };
    /**
     * loading
     * failed
     * success
     * form
     */
    $scope.create           = function(){
        $scope.page = 'loading';
        api.req('repository/create',{
            name    : $scope.name,
            write   : getIds($scope.team.write),
            read    : getIds($scope.team.readOnly),
            dec     : $scope.dec
        }).then(function(data){
            data    = data.data;
            var key = data.key;
            if($scope.obj.flow.files[0] !== undefined){
                var blob= $scope.obj.flow.files[0].file;
                api.sendFile(blob,function(data){
                    api.req('repository/photo',{
                        id:key,
                        photo:data
                    }).then(function(){
                        $scope.page     = 'success';
                    },function(data){
                        $scope.page     = 'failed';
                        $scope.details  = data.message;
                    });
                },function(data){
                    $scope.page     = 'failed';
                    $scope.details  = data.message;
                })
            }else{
                $scope.page     = 'success';
            }
        },function(data){
            $scope.page     = 'failed';
            $scope.details  = data.message;
        });
    };
});