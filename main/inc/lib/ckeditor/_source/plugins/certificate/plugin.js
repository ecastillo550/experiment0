/*
* @example An iframe-based dialog with custom button handling logics.
*/
(function() {

    function returnToken(value) {        
        var divToken = '';        
        divToken = '<div class="certificate-drag" style="position:absolute;top:20px;left:20px;z-index:10;">'+value+'</div>';        
        return divToken;        
    }
    
    function returnBg(value) {        
        var divBg = '';        
        var classBg  = 'bg-'+value.toLowerCase();
        var CertificatePath = '/main/default_course_document/images/templates/certificates/';
        var imageBg  = value.toLowerCase()+'.jpg';
        divBg = '<div class="'+classBg+'" style="background-image:url('+CertificatePath+imageBg+');background-repeat:no-repeat;height:756px;width:1070px;z-index:-10;margin:0px;"></div>';        
        return divBg;
    }
    
    function addCombo( editor, comboName, styleType, lang, entries, defaultLabel, styleDefinition )
    {
            var config = editor.config;

            // Gets the list of fonts from the settings.
            var names = entries.split(';'), values = [];

            // Create style objects for all fonts.
            var styles = {};
            for (var i = 0 ; i < names.length ; i++)
            {
                    var parts = names[i];
                    if (parts)
                    {
                            parts = parts.split( '/' );
                            var vars = {}, name = names[ i ] = parts[ 0 ];
                            vars[ styleType ] = values[ i ] = parts[ 1 ] || name;
                            styles[ name ] = new CKEDITOR.style( styleDefinition, vars );
                            styles[ name ]._.definition.name = name;
                    }
                    else
                            names.splice( i--, 1 );
            }

            editor.ui.addRichCombo( comboName,
                    {                                                
                            label : (styleType == 'backgrounds'?'Backgrounds':'Tokens'),
                            title : lang.panelTitle,
                            className : 'cke_' + (styleType == 'backgrounds'?'certificateBg':'certificateToken'),
                            panel :
                            {
                                css : editor.skin.editor.css.concat( config.contentsCss ),
                                multiSelect : false,
                                attributes : {'aria-label' : lang.panelTitle}
                            },
                            init : function()
                            {
                                this.startGroup( lang.panelTitle );
                                for ( var i = 0 ; i < names.length ; i++) {
                                    var name = names[ i ];
                                    // Add the tag entry to the panel list.
                                    this.add( name, styles[ name ].buildPreview(), name );
                                }
                            },
                            onClick : function( value )
                            {   
                                if (styleType == 'backgrounds') {
                                    editor.setData(editor.getData() + returnBg(value));
                                } else {
                                    editor.setData(editor.getData() + returnToken(value));
                                }
                                editor.focus();                                    
                            },
                            onRender : function()
                            {
                                editor.on( 'selectionChange', function( ev )
                                {
                                    var currentValue = this.getValue();
                                    var elementPath = ev.data.path, elements = elementPath.elements;

                                    // For each element into the elements path.
                                    for ( var i = 0, element ; i < elements.length ; i++ )
                                    {
                                            element = elements[i];
                                            // Check if the element is removable by any of
                                            // the styles.
                                            for ( var value in styles )
                                            {
                                                    if ( styles[ value ].checkElementRemovable( element, true ) )
                                                    {
                                                            if ( value != currentValue )
                                                                    this.setValue( value );
                                                            return;
                                                    }
                                            }
                                    }

                                    // If no styles match, just empty it.
                                    this.setValue( '', defaultLabel );
                                },
                                this);
                            }
                    });
    }

    CKEDITOR.plugins.add('certificate', {
                requires : [ 'richcombo', 'styles' ],
		init : function( editor )
		{
                    var config = editor.config;
                    addCombo( editor, 'CertificateTokens', 'tokens', 'Token', config.certificate_tokens, config.certificate_tokens_defaultLabel, config.certificate_tokens_style);
                    addCombo( editor, 'CertificateBg', 'backgrounds', 'Background', config.certificateBg, config.certificateBg_defaultLabel, config.certificateBg_style);
		}
    });
    
})();

CKEDITOR.config.certificate_tokens_defaultLabel = '';
CKEDITOR.config.certificate_tokens =
        'Floating Text;' +
	'{StudentFirstName};'+
	'{StudentLastName};'+
        '{StudentFullName};'+
	'{TrainerFirstName};'+
        '{TrainerLastName};'+
        '{TrainerFullName};'+
        '{Date};'+
        '{ModuleName};'+
        '{CertificateMinScore};'+
        '{UserScore};'+
        '{SiteName};'+
        '{SiteUrl};'
    ;    
CKEDITOR.config.certificate_tokens_style =
	{
		element		: 'div',
		styles		: {'font-size' : '10px'},
		overrides	: [ {element : 'font', attributes : {'width' : '350px'}} ]
	};    
 
CKEDITOR.config.certificateBg_defaultLabel = ''; 
CKEDITOR.config.certificateBg =
        'Certificate01;' +
	'Certificate02;'+
	'Certificate03;'	
    ;        
CKEDITOR.config.certificateBg_style =
	{
		element		: 'div',
		styles		: {'font-size' : '10px'},
		overrides	: [ {element : 'font', attributes : {'width' : '350px'}} ]
	};  