var app = angular.module('clipApp', ['clip-two']);
app.run(['$rootScope', '$state', '$stateParams',
function ($rootScope, $state, $stateParams) {

    // Attach Fastclick for eliminating the 300ms delay between a physical tap and the firing of a click event on mobile browsers
    FastClick.attach(document.body);

    // Set some reference to access them from any scope
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;

    // GLOBAL APP SCOPE
    // set below basic information
    $rootScope.app = {
        name: 'XZC', // name of your project
        author: 'QTIƎE', // author's name or company name
        description: 'XZBox private version controller.', // brief description
        version: '1.0', // current version
        year: ((new Date()).getFullYear()), // automatic current year (for copyright information)
        isMobile: (function () {// true if the browser is a mobile device
            var check = false;
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                check = true;
            };
            return check;
        })(),
        layout: {
            isNavbarFixed: true, //true if you want to initialize the template with fixed header
            isSidebarFixed: true, // true if you want to initialize the template with fixed sidebar
            isSidebarClosed: false, // true if you want to initialize the template with closed sidebar
            isFooterFixed: true, // true if you want to initialize the template with fixed footer
            theme: 'theme-1', // indicate the theme chosen for your project
            logo: 'assets/images/logo.png', // relative path of the project logo
        }
    };
    $rootScope.user = {
        name: 'QTIƎE',
        job: 'ng-Dev',
        picture: 'assets/images/qt.jpg'
    };
    $rootScope.rsa      = new RSAKey();
    $rootScope.rsa.setPublic('CEB3DE3910DD8FE30A6704BC559BDD40D982C475A91B51BF17A4F0D0EFB35AA4D855C8F605D3D3D548831390513861B71F121D08820D44C0322E578CD4E14B6D111A1EE8912CF7168FF0597793163914AC9C1049EC81002CC95ADC9A75B93B0F1F938933DB6F678582880B26312680092A5628C71C00E8FE2692CDC55D2A08F63639C029C33517C37E430436247F8CBE055130AF889ACEAAE36346BBFDAD2932DBB6424674EC37C8FB5AA724E651D828AAEE42BE6181D0AE04E187E93D27299A23D083D94095CE6BD9257F6511BB832E4AC2221FE549B979D807B13BC35C560AF660B7896330F3D9AA8617C3FEF6CD7D93C3FF3912520F5BF6A1F00E267160AD', '010001');
    $rootScope.token    = localStorage.getItem('token');
    $rootScope.fastKey  = fastEnc.generateRandomKey();
}]);
// translate config
app.config(['$translateProvider',
function ($translateProvider) {

    // prefix and suffix information  is required to specify a pattern
    // You can simply use the static-files loader with this pattern:
    $translateProvider.useStaticFilesLoader({
        prefix: 'assets/i18n/',
        suffix: '.json'
    });

    // Since you've now registered more then one translation table, angular-translate has to know which one to use.
    // This is where preferredLanguage(langKey) comes in.
    $translateProvider.preferredLanguage('en');

    // Store the language in the local storage
    $translateProvider.useLocalStorage();

}]);
// Angular-Loading-Bar
// configuration
app.config(['cfpLoadingBarProvider',
function (cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeBar = true;
    cfpLoadingBarProvider.includeSpinner = false;

}]);
//btoa -> string->base64
//atob -> base64->string
app.service('api',function($http,$rootScope){
    if($rootScope.a)
    var url = 'http://qti3e/xzbox/vcs/';
    var re  = Object();
    var key = $rootScope.fastKey;
    re.get  = function(page,data){
        if(data === undefined){
            data    = {};
        }
        var d   = {};
        d.page  = page;
        d.data  = data;
        if($rootScope.token !== undefined){
            d.data.token    = $rootScope.token;
        }
        d           = JSON.stringify(d);
        var sign    = Sha1.hash(d);
        var sec     = $rootScope.rsa.encrypt(key+';'+sign);
        data        = fastEnc.encrypt(d,key,sign);
        console.log(url);
        var req = {
            method: 'POST',
            url: 'http://qti3e/xzbox/vcs/',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: $.param({key:sec,data:data})
        };
        $http(req).then(function(data){
            console.log(data);
        },function(){
            console.log('error');
        });
    };
    re.decrypt  = function(data){

    };
    return re;
});