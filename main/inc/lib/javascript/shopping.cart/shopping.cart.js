$(document).ready(function() {
	$('a.addToCartCourseClick').live('click', function(event) {
		event.preventDefault();
		ShoppingCart.addItemShoppingCart($(this));
	});
	$('div#header div.headerinner div#cart div.heading a').live('click', function(event) {
		event.preventDefault();
		ShoppingCart.mouseOverShoppingCartContent();
		
		$('div#header div#cart.active table.cart td.remove img').live('click' , function(event){
			event.preventDefault();
			ShoppingCart.removeItemShoppingCart($(this));
		} )
	});
});