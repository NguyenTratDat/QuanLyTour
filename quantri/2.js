 var app = angular.module('myApp',['ngMaterial']);
 app.controller('MyController',  function($scope){

    $(document).ready(function() {
        $("#loginLink").click(function( event ){
            event.preventDefault();
            $(".overlay").fadeToggle("fast");
        });
        
        $(".overlayLink").click(function(event){
            event.preventDefault();
            var action = $(this).attr('data-action');
            
            $.get( "ajax/" + action, function( data ) {
                $( ".login-content" ).html( data );
            }); 
            
            $(".overlay").fadeToggle("fast");
        });
        
        $(".close").click(function(){
            $(".overlay").fadeToggle("fast");
        });
        
        $(document).keyup(function(e) {
            if(e.keyCode == 27 && $(".overlay").css("display") != "none" ) { 
                event.preventDefault();
                $(".overlay").fadeToggle("fast");
            }
        });
    });


    $scope.display = true;

    $scope.show = function()
    {
        $scope.display = !$scope.display;
    }
})