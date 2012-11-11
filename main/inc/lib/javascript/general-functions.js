var ShoppingCart = function() {

	var isContentEmpty = true;
	var currentItem = 0;
	var clickedAnchors = new Array();

	return {
              addItemShoppingCart : function( clicked ) 
              {                      
                    $('#shoppingMsgBody').dialog({modal: true, title: 'Shopping Cart', height: '280', width: '350px', resizable: false,
                            buttons: { 
                                    'No': function() {
                                        $(this).dialog('close');
                                        }, 
                                    'Yes': function() {
                                        $('#shoppingMsgBodyAdded').dialog({
                                            modal: true, title: 'Shopping Cart', height: '280', width: '350px', resizable: false, closeOnEscape: false, 
                                            open: function(event, ui){
                                                  setTimeout("$('#shoppingMsgBodyAdded').dialog('close')",2000);
                                          }                                         
                                        });
                                        $('.ui-dialog-titlebar-close').hide();
                                        var parentContainer  = clicked.closest('div.course_catalog_container');
                                        var code = parentContainer.attr('rel');
                                        var type = $('table#shoppingCartCatalog').attr('rel');
                                        $.ajax({
                                            url : "/main/core/controller/shopping_cart/shopping_cart_controller.php",
                                            data : {
                                                    code: code,
                                                    type : type,
                                                    action: 'addItem'
                                                },
                                            context : document.body,
                                            success : function(msg) {
                                                        $('div#header div#cart').replaceWith(msg);  
                                                    }
                                              });   
                                        $(this).dialog('close');
                                        }
                                     }
                   });		
		},
		removeItemShoppingCart : function( clicked )
		{
			var code = clicked.attr('alt');
			
			$.ajax({
				url : "/main/core/controller/shopping_cart/shopping_cart_controller.php",
				data : {
					code: code,
					type : '',
					action: 'removeItem'
				},
				context : document.body,
				success : function(msg) {
					$('div#header div#cart').replaceWith(msg);					
					$('div#header div#cart').addClass('active');
					
				}
			});	
		},
		mouseOverShoppingCartContent : function()
		{
			$('div#header div#cart').addClass('active');
			$('div#header div#cart *').show();
			$('div#header div#cart').live('mouseleave', function() {
				$(this).removeClass('active');
			});
		}
	}
}();