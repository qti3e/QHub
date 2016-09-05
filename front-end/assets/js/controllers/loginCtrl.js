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

app.controller('loginCtrl',function(api,Auth,$scope,$rootScope,$state){
    Auth.isLogin(function(isLogin){
        if(isLogin){
            $state.go('app.dashboard');
        }
    });
    $scope.data     = {
        username:'',
        password:''
    };
    $scope.wrongPass= false;
    $scope.login    = function(){
        api.req('login',$scope.data).then(function(data){
            if(data.status === 'nok'){
                $scope.wrongPass    = true;
            }else if(data.status === 'ok'){
                localStorage.token  = ($rootScope.token = data.data.token);
                $rootScope.user     = data.data.user;
                $rootScope._isLogin = true;
                if($rootScope.user.photo === undefined){
                    $rootScope.user.photo   = 'assets/images/default-user.png';
                }
                $state.go('app.dashboard');
            }else {
                //An error was occurred
                alert('An error was occurred!');
            }
        });
        $scope.data.password    = '';
    };
});