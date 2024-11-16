 var app = angular.module('myApp',['ngMaterial']);
 app.controller('MyController',  function($scope){
 

 	$scope.delButton = function()
 	{
 		confirm("Bạn có chắc chắn muốn xóa!");
 		
 	}

 	
 	$(document).ready(function(){
 		
 		var count_banner = 4,
 		timmer_banner = null;
 		$('.slogan').animate({
 			'opacity':1
 		},5000);
 		timmer_banner = setInterval(function(){
 			
 			if(count_banner < 0){
 				clearInterval(timmer_banner);
 				return false;
 			}
 			
 			$('.banner .photo-' + (count_banner)).addClass('active');
 			
 			count_banner--;
 		},600);
 		
 	});



 	
 })