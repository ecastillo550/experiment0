// Set new Toolbar
CKEDITOR.editor.prototype.setToolbar = function( toolbar )
{
	// Destroy previous toolbar
	var toolbars, index = 0, i,
			items, instance;
	toolbars = this.toolbox.toolbars;
	for ( ; index < toolbars.length; index++ )
	{
		items = toolbars[ index ].items;
		for ( i = 0; i < items.length; i++ )
		{
			instance = items[ i ];
			if ( instance.clickFn ) CKEDITOR.tools.removeFunction( instance.clickFn );
			if ( instance.keyDownFn ) CKEDITOR.tools.removeFunction( instance.keyDownFn );

			if ( instance.index ) CKEDITOR.ui.button._.instances[ instance.index ] = null;
		}
	}

	// Set new one
	this.config.toolbar = toolbar;

	// create it
	var toolbarLocation = this.config.toolbarLocation,
		space = document.getElementById('cke_' + toolbarLocation + '_' + this.name),
		html = this.fire( 'themeSpace', { space : toolbarLocation, html : '' } ).html;

	space.innerHTML = html;
}



CKEDITOR.plugins.add( 'toolbarswitch', 
{
	init: function( editor ) 
	{	
		var _initialToolbar = editor.config.toolbar;
		
		editor.on('beforeCommandExec',function(e){
			if (e.data.name != 'maximize')
			{
				return;
			}
	 		if (editor.config.toolbar == _initialToolbar )
	 		{   
                                                             
	 			editor.setToolbar( editor.config.maximizedToolbar );
	 		}
	 		else
	 		{
	 			editor.setToolbar( _initialToolbar );
	 		}
	 		
		});
	}
});

CKEDITOR.config.maximizedToolbar = 'FullTollbar';




