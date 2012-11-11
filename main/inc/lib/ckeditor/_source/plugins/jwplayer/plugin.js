/*
 * @file Jwplayer plugin for CKEditor
 * Copyright (C) 2012 J. Scott Hepler, based on work by
 * Copyright (C) 2011 Alfonso Mart’nez de Lizarrondo
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 */

CKEDITOR.plugins.add( 'jwplayer',
{
	// Translations, available at the end of this file, without extra requests
	lang : [ 'en' ],

	init : function( editor )
	{
		var lang = editor.lang.jwplayer;

		// Check for CKEditor 3.5
		if (typeof editor.element.data == 'undefined')
		{
			alert('The "jwplayer" plugin requires CKEditor 3.5 or newer');
			return;
		}

		CKEDITOR.dialog.add( 'jwplayer', this.path + 'dialogs/jwplayer.js' );

		editor.addCommand( 'Jwplayer', new CKEDITOR.dialogCommand( 'jwplayer' ) );
		editor.ui.addButton( 'Jwplayer',
			{
				label : lang.toolbar,
				command : 'Jwplayer',
				icon : this.path + 'images/icon.png'
			} );

		editor.addCss(
			'img.cke_jwplayer' +
			'{' +
				'background-image: url(' + CKEDITOR.getUrl( this.path + 'images/placeholder.png' ) + ');' +
				'background-position: center center;' +
				'background-repeat: no-repeat;' +
				'background-color:gray;'+
				'border: 1px solid #a9a9a9;' +
				'width: 80px;' +
				'height: 80px;' +
			'}');


			// If the "menu" plugin is loaded, register the menu items.
			if ( editor.addMenuItems )
			{
				editor.addMenuItems(
					{
						jwplayer :
						{
							label : lang.properties,
							command : 'Jwplayer',
							group : 'flash'
						}
					});
			}

			editor.on( 'doubleclick', function( evt )
				{
					var element = evt.data.element;
                    // Flash should be replaced by jwplayer, this does not work so now, we need make changes here
					if ( element.is( 'img' ) && element.data( 'cke-real-element-type' ) == 'jwplayer' ) // = jwplayer
						evt.data.dialog = 'jwplayer';
				});

			// If the "contextmenu" plugin is loaded, register the listeners.
			if ( editor.contextMenu )
			{
				editor.contextMenu.addListener( function( element, selection )
					{
						if ( element && element.is( 'img' ) && !element.isReadOnly()
								&& element.data( 'cke-real-element-type' ) == 'jwplayer' )
							return { jwplayer : CKEDITOR.TRISTATE_OFF };
					});
			}

		// Add special handling for these items
		CKEDITOR.dtd.$empty['cke:source']=1;
		CKEDITOR.dtd.$empty['source']=1;

		editor.lang.fakeobjects.jwplayer = lang.fakeObject;


	}, //Init

	afterInit: function( editor )
	{

		var dataProcessor = editor.dataProcessor,
			htmlFilter = dataProcessor && dataProcessor.htmlFilter,
			dataFilter = dataProcessor && dataProcessor.dataFilter;

		// dataFilter : conversion from html input to internal data
		dataFilter.addRules(
			{

			elements : {
				$ : function( realElement )
				{                   
						if ( realElement.name == 'jwplayer' )
						{
							realElement.name = 'cke:jwplayer';
							var fakeElement = editor.createFakeParserElement( realElement, 'cke_jwplayer', 'jwplayer', false ),
								fakeStyle = fakeElement.attributes.style || '';

							var width = realElement.attributes.width,
								height = realElement.attributes.height,
								poster = realElement.attributes.poster;

							if ( typeof width != 'undefined' )
								fakeStyle = fakeElement.attributes.style = fakeStyle + 'width:' + CKEDITOR.tools.cssLength( width ) + ';';

							if ( typeof height != 'undefined' )
								fakeStyle = fakeElement.attributes.style = fakeStyle + 'height:' + CKEDITOR.tools.cssLength( height ) + ';';

							return fakeElement;
						}
				}
			}

			}
		);

	} // afterInit

} ); // plugins.add


// Translations
CKEDITOR.plugins.setLang( 'jwplayer', 'en', { jwplayer :
	{
		toolbar	: 'Jwplayer',
		dialogTitle : 'Jwplayer properties',
		fakeObject : 'Jwplayer',
		properties : 'Edit jwplayer',
		widthRequired : 'Width field cannot be empty',
		heightRequired : 'Height field cannot be empty',
		poster: 'Poster image',
		sourceJwplayer: 'Source jwplayer',
		sourceType : 'Jwplayer type',
		linkTemplate :  '<a href="%src%">%type%</a> ',
		fallbackTemplate : 'Your browser doesn\'t support jwplayer.<br>Please download the file: %links%'

	}
} );

