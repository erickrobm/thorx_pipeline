
    var loadFile = function(event) {
      var output = document.getElementById('imagen');
      output.src = URL.createObjectURL(event.target.files[0]);
      var x = document.getElementById("resultadosdiv");
      x.style.display = "none";
    };
    
    var app = angular.module('myApp', ['ngMaterial']);

    app.config(['$interpolateProvider', function($interpolateProvider) {
      $interpolateProvider.startSymbol('{:');
      $interpolateProvider.endSymbol(':}');
    }]);

    app.controller('myCtrl', ['$scope', '$http',
      function($scope, $http) {
        $scope.rp = "http://127.0.0.1:8000";
        //$scope.rp = "http://35.226.247.36:5000/";
        $scope.loading = false;
        $scope.success = false;
      	$scope.error = false;

        $scope.submit = function() {
          var x = document.getElementById("resultadosdiv");
          x.style.display = "block";
          $scope.loading = true;
          $scope.success = false;
        	$scope.error = false;

          var myform = document.forms['myForm'];
          var formData = new FormData(myform);
          console.log(myform)

          URI_final = $scope.rp + "/prediction/platform/";
          //URI_final = $scope.rp + "/model/covid19/";
          console.log(URI_final);
          console.log("Calling ...");
          $http({
            method : 'POST',
            url : URI_final,
            headers: {
                'Content-Type': undefined
            },
            data: formData
          }).success(function(data, status, headers, config) {
            $scope.predictions = data.predictions;
            console.log(data.predictions);
            $scope.loading = false;
            $scope.success = true;
          	$scope.error = false;
          }).error(function(data, status, headers, config) {
            $scope.loading = false;
            $scope.success = false;
            $scope.error = true;
          });

        }

        console.log("Loaded!");
      }
    ]);
