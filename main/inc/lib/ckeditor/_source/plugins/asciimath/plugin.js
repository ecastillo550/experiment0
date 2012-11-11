
/* For licensing terms, see /license.txt */

/**
 * Copyright (C) 2012 
 * AsciiMath plugin for CKEditor. Plugin developed by Dokeos Team based in the work of Peter Jipsen
 * 
 */
    CKEDITOR.plugins.add( 'asciimath',
    { 
            // This function called upon the initialization of the editor instance
            
            init: function( editor )
            {             
                    // Set the icon path of the asciimath plugin image                 
                    var iconPath = this.path + 'images/asciimath.gif';
                   
                    // Define an asciimath command that opens the asciimathDialog dialog  
                    
                    editor.addCommand( 'asciimath', new CKEDITOR.dialogCommand( 'asciimathDialog' ) );

                    // Define the properties of the asciimathDialog
                    
                    CKEDITOR.dialog.add( 'asciimathDialog', function ( editor )
                    {
                            var id = editor.id;
                            return {
                                    title : editor.lang.asciimath.title,
                                    minWidth : 860,
                                    minHeight : 470,
                                    contents :
                                    [
                                            {
                                                    id : 'iframe',
                                                    label : editor.lang.asciimath.title,
                                                    expand : true,
                                                    elements :
                                                    [
                                                            {
                                                                type : 'html',
                                                                id : 'pageMathMLEmbed',
                                                                label : editor.lang.asciimath.title,
                                                                html : '<div style="width:860px;height:470px"><iframe src="'+ CKEDITOR.plugins.getPath('asciimath') +'dialogs/editor.html" frameborder="0" name="iframeMathmlEditor'+id+'" id="iframeMathmlEditor'+id+'" allowtransparency="1" style="width:860px;height:470px;margin:0;padding:0;" scrolling="no"></iframe></div>'
                                                                
                                                            }
                                                    ]
                                            }

                                    ],
                                    onOk : function()
                                    {                                             
                                           var str = ''; 
                                           // Get the frame math editor 
                                           var frame = document.getElementById ('iframeMathmlEditor'+id);
                                           // Get the value of document in the dialog window
                                           var frameDoc = frame.contentWindow.document;
                                           // Get the value of the input text
                                           var str= frameDoc.getElementById('inputText').value;
                                           // Get the div where is showed the preview                                                     
                                           var newoutnode = '<span class="AM">'+frameDoc.getElementById('outputNodeFinal').innerHTML+'</span>';
                                           // Insert the html code created                                           
                                           editor.insertHtml(newoutnode); 
                                           // Clean the window
                                           frameDoc.getElementById('inputText').value = '';
                                           frameDoc.getElementById('outputNode').innerHTML ='';  
                                           frameDoc.getElementById('outputNodeFinal').innerHTML ='';                                           
                                    }
                            };
                    } );
                    
                    // Define a button that will be associated with the asciimath command
                    
                    editor.ui.addButton( 'asciimath',
                    {
                            label: editor.lang.asciimath.label_icon,
                            command: 'asciimath',
                            icon: iconPath
                    } );
            }
    } );

