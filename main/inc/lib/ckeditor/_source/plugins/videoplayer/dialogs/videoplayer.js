/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

(function()
{
   
	/*
	 * It is possible to set things in three different places.
	 * 1. As attributes in the object tag.
	 * 2. As param tags under the object tag.
	 * 3. As attributes in the embed tag.
	 * It is possible for a single attribute to be present in more than one place.
	 * So let's define a mapping between a sementic attribute and its syntactic
	 * equivalents.
	 * Then we'll set and retrieve attribute values according to the mapping,
	 * instead of having to check and set each syntactic attribute every time.
	 *
	 * Reference: http://kb.adobe.com/selfservice/viewContent.do?externalId=tn_12701
	 */
	var ATTRTYPE_OBJECT = 1,
		ATTRTYPE_PARAM = 2,
		ATTRTYPE_EMBED = 4;

	var attributesMap =
	{
               
		id : [ { type : ATTRTYPE_OBJECT, name :  'id' } ],
		classid : [ { type : ATTRTYPE_OBJECT, name : 'classid' } ],
		codebase : [ { type : ATTRTYPE_OBJECT, name : 'codebase'} ],
		pluginspage : [ { type : ATTRTYPE_EMBED, name : 'pluginspage' } ],
		src : [ { type : ATTRTYPE_PARAM, name : 'movie' }, { type : ATTRTYPE_EMBED, name : 'src' }, { type : ATTRTYPE_OBJECT, name :  'data' } ],
		name : [ { type : ATTRTYPE_EMBED, name : 'name' } ],
		align : [ { type : ATTRTYPE_OBJECT, name : 'align' } ],
		title : [ { type : ATTRTYPE_OBJECT, name : 'title' }, { type : ATTRTYPE_EMBED, name : 'title' } ],
		'class' : [ { type : ATTRTYPE_OBJECT, name : 'class' }, { type : ATTRTYPE_EMBED, name : 'class'} ],
		width : [ { type : ATTRTYPE_OBJECT, name : 'width' }, { type : ATTRTYPE_EMBED, name : 'width' } ],
		height : [ { type : ATTRTYPE_OBJECT, name : 'height' }, { type : ATTRTYPE_EMBED, name : 'height' } ],
		hSpace : [ { type : ATTRTYPE_OBJECT, name : 'hSpace' }, { type : ATTRTYPE_EMBED, name : 'hSpace' } ],
		vSpace : [ { type : ATTRTYPE_OBJECT, name : 'vSpace' }, { type : ATTRTYPE_EMBED, name : 'vSpace' } ],
		style : [ { type : ATTRTYPE_OBJECT, name : 'style' }, { type : ATTRTYPE_EMBED, name : 'style' } ],
		type : [ { type : ATTRTYPE_EMBED, name : 'type' } ]
	};

	var names = [ 'play', 'loop', 'menu', 'quality', 'scale', 'salign', 'wmode', 'bgcolor', 'base', 'flashvars', 'allowScriptAccess',
		'allowFullScreen' ];
	for ( var i = 0 ; i < names.length ; i++ )
		attributesMap[ names[i] ] = [ { type : ATTRTYPE_EMBED, name : names[i] }, { type : ATTRTYPE_PARAM, name : names[i] } ];
	names = [ 'allowFullScreen', 'play', 'loop', 'menu' ];
	for ( i = 0 ; i < names.length ; i++ )
		attributesMap[ names[i] ][0]['default'] = attributesMap[ names[i] ][1]['default'] = true;

	var defaultToPixel = CKEDITOR.tools.cssLength;
        
        
        
        
        
	function loadValue( objectNode, embedNode, paramMap )
	{
            
            var CurrObj = CKEDITOR.dialog.getCurrent();
            var tab = CurrObj.definition.dialog._.currentTabId;
            
            switch (tab) {
                   
                   case 'Upload':
                        var attributes = attributesMap[ this.id ];
                        if ( !attributes )
                                return;

                        var isCheckbox = ( this instanceof CKEDITOR.ui.dialog.checkbox );
                        for ( var i = 0 ; i < attributes.length ; i++ )
                        {
                                var attrDef = attributes[ i ];
                                switch ( attrDef.type )
                                {
                                        case ATTRTYPE_OBJECT:
                                                if ( !objectNode )
                                                        continue;
                                                if ( objectNode.getAttribute( attrDef.name ) !== null )
                                                {
                                                        var value = objectNode.getAttribute( attrDef.name );
                                                        if ( isCheckbox )
                                                                this.setValue( value.toLowerCase() == 'true' );
                                                        else
                                                                this.setValue( value );
                                                        return;
                                                }
                                                else if ( isCheckbox )
                                                        this.setValue( !!attrDef[ 'default' ] );
                                                break;
                                        case ATTRTYPE_PARAM:
                                                if ( !objectNode )
                                                        continue;
                                                if ( attrDef.name in paramMap )
                                                {
                                                        value = paramMap[ attrDef.name ];
                                                        if ( isCheckbox )
                                                                this.setValue( value.toLowerCase() == 'true' );
                                                        else
                                                                this.setValue( value );
                                                        return;
                                                }
                                                else if ( isCheckbox )
                                                        this.setValue( !!attrDef[ 'default' ] );
                                                break;
                                        case ATTRTYPE_EMBED:
                                                if ( !embedNode )
                                                        continue;
                                                if ( embedNode.getAttribute( attrDef.name ) )
                                                {
                                                        value = embedNode.getAttribute( attrDef.name );
                                                        if ( isCheckbox )
                                                                this.setValue( value.toLowerCase() == 'true' );
                                                        else
                                                                this.setValue( value );
                                                        return;
                                                }
                                                else if ( isCheckbox )
                                                        this.setValue( !!attrDef[ 'default' ] );
                                }
                        }
                       break;
                   
                   case 'info':
                       
                       break;
            }
             
             
            
		
                
                
                
	}
        
        
        
	function commitValue( objectNode, embedNode, paramMap )
	{
                              
               var CurrObj = CKEDITOR.dialog.getCurrent();
               var tab = CurrObj.definition.dialog._.currentTabId;
               
               switch (tab) {
                   
                   case 'Upload':
                        var attributes = attributesMap[this.id];
                        if (!attributes) return;

                        var isRemove = ( this.getValue() === '' ),
                        isCheckbox = ( this instanceof CKEDITOR.ui.dialog.checkbox );

                        for ( var i = 0 ; i < attributes.length ; i++ )
                        {
                            var attrDef = attributes[i];
                            switch ( attrDef.type )
                            {
                                case ATTRTYPE_OBJECT:
                                        // Avoid applying the data attribute when not needed (#7733)
                                        if ( !objectNode || ( attrDef.name == 'data' && embedNode && !objectNode.hasAttribute( 'data' ) ) )
                                                continue;
                                        var value = this.getValue();
                                        if ( isRemove || isCheckbox && value === attrDef[ 'default' ] )
                                                objectNode.removeAttribute( attrDef.name );
                                        else
                                                objectNode.setAttribute( attrDef.name, value );
                                        break;
                                case ATTRTYPE_PARAM:
                                        if ( !objectNode )
                                                continue;
                                        value = this.getValue();
                                        if ( isRemove || isCheckbox && value === attrDef[ 'default' ] )
                                        {
                                                if ( attrDef.name in paramMap )
                                                        paramMap[ attrDef.name ].remove();
                                        }
                                        else
                                        {
                                                if ( attrDef.name in paramMap )
                                                        paramMap[ attrDef.name ].setAttribute( 'value', value );
                                                else
                                                {
                                                        var param = CKEDITOR.dom.element.createFromHtml( '<cke:param></cke:param>', objectNode.getDocument() );
                                                        param.setAttributes( { name : attrDef.name, value : value } );
                                                        if ( objectNode.getChildCount() < 1 )
                                                                param.appendTo( objectNode );
                                                        else
                                                                param.insertBefore( objectNode.getFirst() );
                                                }
                                        }
                                        break;
                                case ATTRTYPE_EMBED:
                                        if ( !embedNode )
                                                continue;
                                        value = this.getValue();
                                        if ( isRemove || isCheckbox && value === attrDef[ 'default' ])
                                                embedNode.removeAttribute( attrDef.name );
                                        else
                                                embedNode.setAttribute( attrDef.name, value );
                            }
                        }
                       break;
                  case 'info':   // video plugin tab
                        var value=this.getValue();
                        if (!value && this.id=='id') value = generateId();
                        //videoNode.setAttribute( this.id, value);
                        //if (!value) return;
                        switch( this.id )
                        {
                            case 'poster':
                                    embedNode.backgroundImage = 'url(' + value + ')';
                                    break;
                            case 'width':
                                    embedNode.width = value + 'px';
                                    break;
                            case 'height':
                                    embedNode.height = value + 'px';
                                    break;
                            case 'autoplay':
                            case 'loop':
                            case 'fullscreen':
                                    value = value=='true'?true:false;
                                    break;                    
                        }
                      break;
                   
               }
               
		
	}
        
        
        
        

	CKEDITOR.dialog.add( 'videoplayer', function( editor )
	{       
            
               
                
                var me = this;
                //var Video
                var src_video;
                var lang = editor.lang.video;
                var JWplayer = CKEDITOR.plugins.get('video').path + 'jwplayer/player.swf';
                var JWplayerJs = CKEDITOR.plugins.get('video').path + 'jwplayer/jwplayer.js';
                var JWplayerSkin = CKEDITOR.plugins.get('video').path + "jwplayer/skin/facebook.zip";
                var JWswfobject = CKEDITOR.plugins.get('video').path + 'jwplayer/swfobject.js';
                var oMedia = [] ;
                var is_new_videoplayer = true; 
                
                //function video
                function commitSrc( videoNode, extraStyles, videos )
                {
                    var match = this.id.match(/(\w+)(\d)/),
                    id = match[1],
                    number = parseInt(match[2], 10);
                    var video = videos[number] || (videos[number]={});
                    video[id] = this.getValue();
                }
                function loadSrc( videoNode, videos )
                {
                    var match = this.id.match(/(\w+)(\d)/),
                    id = match[1],
                    number = parseInt(match[2], 10);
                    var video = videos[number];
                    if (!video) return;
                    this.setValue( video[ id ] );
                }
                
                /*function commitValue( videoNode, extraStyles )
                {
                    var value=this.getValue();
                    if (!value && this.id=='id') value = generateId();
                    //videoNode.setAttribute( this.id, value);
                    //if (!value) return;
                    switch( this.id )
                    {
                        case 'poster':
                                extraStyles.backgroundImage = 'url(' + value + ')';
                                break;
                        case 'width':
                                extraStyles.width = value + 'px';
                                break;
                        case 'height':
                                extraStyles.height = value + 'px';
                                break;
                        case 'autoplay':
                        case 'loop':
                        case 'fullscreen':
                                value = value=='true'?true:false;
                                break;                    
                    }
                }*/
                
                function loadValue(videoNode)
                {
                    if ( videoNode ) {
                        this.setValue( videoNode.getAttribute( this.id ) );
                    }
                    else {
                        if ( this.id == 'id') this.setValue(generateId());
                    }
                }
                function generateId()
                {
                        var now = new Date();
                        return 'video' + now.getFullYear() + now.getMonth() + now.getDate() + now.getHours() + now.getMinutes() + now.getSeconds();
                }
                function UpdateMovie() {
                        oMedia['fileUrl']    = CKEDITOR.dialog.getCurrent().getContentElement('info', 'src0').getValue();
                        oMedia['fileUrlHtml']    = CKEDITOR.dialog.getCurrent().getContentElement('info', 'src1').getValue();
                        oMedia['previewUrl'] = CKEDITOR.dialog.getCurrent().getContentElement('info', 'poster').getValue();
                        oMedia['width']      = CKEDITOR.dialog.getCurrent().getContentElement('info', 'width').getValue();
                        oMedia['height']     = CKEDITOR.dialog.getCurrent().getContentElement('info', 'height').getValue();                

                        oMedia['cmbAlign']   = CKEDITOR.dialog.getCurrent().getContentElement('info', 'cmbAlign').getValue();
                        oMedia['cmbBuffer']   = CKEDITOR.dialog.getCurrent().getContentElement('info', 'cmbBuffer').getValue();
                        oMedia['autoplay']   = CKEDITOR.dialog.getCurrent().getContentElement('info', 'autoplay').getValue();
                        oMedia['loop']   = CKEDITOR.dialog.getCurrent().getContentElement('info', 'loop').getValue();
                        oMedia['fullscreen']   = CKEDITOR.dialog.getCurrent().getContentElement('info', 'fullscreen').getValue();

                }
                function LoadSelection(e) { 
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'src0').setValue(e['fileUrl']);
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'src1').setValue(e['fileUrlHtml']);
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'poster').setValue(e['previewUrl']);
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'width').setValue(e['width']);
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'height').setValue(e['height']);

                        e['autoplay'] = e['autoplay'] == 'true'?true:false;
                        e['loop'] = e['loop'] == 'true'?true:false;
                        e['fullscreen'] = e['fullscreen'] == 'true'?true:false;


                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'cmbAlign').setValue(e['cmbAlign']);
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'cmbBuffer').setValue(e['cmbBuffer']);
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'autoplay').setValue(e['autoplay']);
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'loop').setValue(e['loop']);
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'fullscreen').setValue(e['fullscreen']);
                }
                
                function getVideoInnerHTML(playerid) {
                        var s = '' ;            
                        var streaming = false;

                        var sExt = oMedia['fileUrl'].match( /\.(flv|mpg|mpeg|mp4|avi|wmv|mov|asf)$/i);
                        if ( sExt.length && sExt.length > 0 ) {
                            sExt = sExt[0];
                        } else {
                            sExt = '';
                        }

                        // A hidden div containing setting, added width, height, overflow for MSIE7
                        s += '<div id="player' + playerid + '-config" style="display: none; visibility: hidden; width: 0px; height: 0px; overflow: hidden;">' ;                            
                        s += 'fileUrl='+oMedia['fileUrl']+' fileUrlHtml='+oMedia['fileUrlHtml']+' previewUrl='+oMedia['previewUrl']+' width='+oMedia['width']+' height='+oMedia['height']+' cmbAlign='+oMedia['cmbAlign']+' cmbBuffer='+oMedia['cmbBuffer']+' autoplay='+oMedia['autoplay']+' loop='+oMedia['loop']+' fullscreen='+oMedia['fullscreen'];
                        s += '</div>' ;
                        s += '<div id="test" style="border-style: none; height: ' + oMedia['height'] + 'px; width: ' + oMedia['width'] + 'px; overflow: hidden; background-color: rgb(220, 220, 220);">';
                        s += '<div id="player' + playerid + '" class="thePlayer">';  

                        if (sExt == '.flv' || sExt == '.mp4' || sExt == '.mov') {

                            if (/(rtmp:\/\/)/i.test(oMedia['fileUrl'])) {
                                streaming = true;
                            }

                            if (streaming) {

                                var exploded = oMedia['fileUrl'].split('/');       
                                var theFile  = exploded[exploded.length-1];
                                var thePath  = oMedia['fileUrl'].replace("/"+theFile, "");
                                s += '<script src="' + JWplayerJs + '" type="text/javascript"></script>';
                                s += '<div id="player' + playerid + '-parent2">Loading the player ...</div>';        
                                s += '<script type="text/javascript">';
                                s += '  jwplayer("player' + playerid + '-parent2").setup({';        
                                s += '      height: '+oMedia['height']+',';
                                s += '      width: '+oMedia['width']+',';
                                if (oMedia['previewUrl'] != "") { s += 'image: "'+oMedia['previewUrl']+'",' }
                                s += '      autostart: "'+ (oMedia['autoplay'] == true? 'true' : 'false') +'",';
                                s += '      repeat: "'+ (oMedia['loop'] == true? 'always' : '') +'",';
                                s += '      modes: [';
                                s += '              { ';
                                s += '                  type: "flash",';
                                s += '                  src: "'+ JWplayer +'",';
                                s += '                  bufferlength: '+oMedia['cmbBuffer']+',';     
                                s += '                  stretching: "exactfit",';                    
                                s += '                  config: { ';
                                s += '                              file: "'+theFile+'",';
                                s += '                              streamer: "'+thePath+'",';
                                s += '                              provider: "rtmp"';
                                s += '                          }';
                                s += '              }';

                                if (oMedia['fileUrlHtml'].length > 0) {
                                    s += '         ,{ ';
                                    s += '              type: "html5",';
                                    s += '              bufferlength: '+oMedia['cmbBuffer']+',';     
                                    s += '              stretching: "exactfit",';
                                    s += '              config: { ';
                                    s += '                        file: "'+oMedia['fileUrlHtml']+'"';
                                    s += '                      }';
                                    s += '          }';
                                }                    

                                s += '             ],';           
                                s += '      skin: "'+ JWplayerSkin +'"';
                                s += '  });';

                                if (oMedia['fullscreen'] == false) {        
                                    s += 'jwplayer("player' + playerid + '-parent2").getPlugin("controlbar").hide();';                    
                                }

                                s += '</script>';  

                            } else {

                                s += '<script src="' + JWplayerJs + '" type="text/javascript"></script>';
                                s += '<div id="player' + playerid + '-parent2">Loading the player ...</div>';    
                                s += '<script type="text/javascript">';
                                s += 'jwplayer("player' + playerid + '-parent2").setup({';
                                s += 'flashplayer: "'+ JWplayer +'",';            
                                if (oMedia['previewUrl'] != "") { s += 'image: "'+oMedia['previewUrl']+'",' }

                                s += 'autostart: "'+ (oMedia['autoplay'] == true? 'true' : 'false') +'",';                
                                s += 'repeat: "'+ (oMedia['loop'] == true? 'always' : '') +'",';
                                s += 'bufferlength: '+oMedia['cmbBuffer']+',';
                                s += 'stretching: "exactfit",';
                                s += 'height: '+ oMedia['height'] +',';
                                s += 'width: '+ oMedia['width'] +',';
                                s += 'skin: "'+ JWplayerSkin+'",';
                                s += 'levels: [';
                                s += ' {  file: "'+ oMedia['fileUrl'] +'" }';                    
                                if (oMedia['fileUrlHtml'].length > 0) {
                                    s += ' ,{  file: "'+ oMedia['fileUrlHtml'] +'" }';
                                }                                        
                                s += ']';                    
                                s += '});';        

                                if (oMedia['fullscreen'] == false) {        
                                    s += 'jwplayer("player' + playerid + '-parent2").getPlugin("controlbar").hide();';                    
                                }

                                s += '</script>';

                            }
                        } 
                        else {
                        // only embed for other video types
                            pluginspace = 'http://www.microsoft.com/Windows/MediaPlayer/' ;
                            codebase = 'http://www.microsoft.com/Windows/MediaPlayer/' ;
                            classid = 'classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95"' ;
                            sType = ( sExt == '.mpg' || sExt == '.mpeg' ) ? 'video/mpeg' :
                                                    (sExt == '.avi' || sExt == '.wmv' || sExt == '.asf' ) ? 'video/x-msvideo' :
                                                    (sExt == '.mov') ? 'video/quicktime' :
                                                    (sExt == '.mp4') ? 'video/mpeg4-generic' :
                                                    'video/x-msvideo' ;
                        s += '<embed type="' + sType + '" src="' + oMedia['fileUrl'] + '" ' +
                            'autosize="false" ' +
                            'fullscreen="true" ' +
                            'autostart="' + (oMedia['autoplay'] == true? 'true' : 'false')  + '" ' +
                            'loop="' + (oMedia['loop'] == true? 'true' : 'false') + '" ' +
                            'showcontrols="'+ (oMedia['fullscreen'] == true? 'true' : 'false') +'"' +
                            'showpositioncontrols="'+ (oMedia['fullscreen'] == true? 'true' : 'false') +'" ' +
                            'showtracker="true"' +
                            'showaudiocontrols="'+ (oMedia['fullscreen'] == true? 'true' : 'false') +'" ' +
                            'showgotobar="true" ' +
                            'showstatusbar="true" ' +
                            'pluginspace="' + pluginspace + '" ' +
                            'codebase="' + codebase + '"' ;
                        s += 'width="' + oMedia['width'] + '" height="' + oMedia['height'] + '"' ;
                        s += '></embed>' ;                        
                        }
                        s += '</div>';    
                        s += '</div>';                                              
                        return s;
                    }
                    // set align to selected element
                    function setCustomAlign(editor, alignment) {                                    
                        var selection = editor.getSelection(), enterMode = editor.config.enterMode;
                        if (!selection) return;
                        var bookmarks = selection.createBookmarks(), ranges = selection.getRanges(true);
                        var iterator, block;
                        var useComputedState = editor.config.useComputedState;
                        useComputedState = useComputedState === undefined || useComputedState;

                        for (var i = ranges.length - 1 ; i >= 0 ; i--) {
                                iterator = ranges[i].createIterator();
                                iterator.enlargeBr = enterMode != CKEDITOR.ENTER_BR;
                                while ((block = iterator.getNextParagraph(enterMode == CKEDITOR.ENTER_P ? 'p' : 'div'))) {
                                    block.removeAttribute( 'align' );
                                    block.removeStyle( 'text-align' );
                                    block.setAttribute('align', alignment);
                                }
                        }
                        editor.focus();
                        editor.forceNextSelectionCheck();
                        selection.selectBookmarks( bookmarks );
                    }
                 // To automatically get the dimensions of the poster image
                    var onImgLoadEvent = function()
                    {
                            // Image is ready.
                            var preview = this.previewImage;
                            preview.removeListener( 'load', onImgLoadEvent );
                            preview.removeListener( 'error', onImgLoadErrorEvent );
                            preview.removeListener( 'abort', onImgLoadErrorEvent );

                            this.setValueOf( 'info', 'width', preview.$.width );
                            this.setValueOf( 'info', 'height', preview.$.height );
                    };

                    var onImgLoadErrorEvent = function()
                    {
                            // Error. Image is not loaded.
                            var preview = this.previewImage;
                            preview.removeListener( 'load', onImgLoadEvent );
                            preview.removeListener( 'error', onImgLoadErrorEvent );
                            preview.removeListener( 'abort', onImgLoadErrorEvent );
                    };
                //end function video
               
               //var flash
               var src_flash;
		var makeObjectTag = !editor.config.flashEmbedTagOnly,
			makeEmbedTag = editor.config.flashAddEmbedTag || editor.config.flashEmbedTagOnly;
		var previewPreloader,
			previewAreaHtml = '<div>' + CKEDITOR.tools.htmlEncode( editor.lang.common.preview ) +'<br>' +
			'<div id="cke_FlashPreviewLoader' + CKEDITOR.tools.getNextNumber() + '" style="display:none"><div class="loading">&nbsp;</div></div>' +
			'<div id="cke_FlashPreviewBox' + CKEDITOR.tools.getNextNumber() + '" class="FlashPreviewBox"></div></div>';

		return {
                                            
			title : editor.lang.videoplayer.title,
			minWidth : 420,
			minHeight : 310,
                       
			onShow : function()
			{
                             var CurrObj = CKEDITOR.dialog.getCurrent();
                             var tab = CurrObj.definition.dialog._.currentTabId;

                              switch(tab) {
                              case 'Upload':
                                            //is tab is Flash
                                            // Clear previously saved elements.
                                            this.fakeImage = this.objectNode = this.embedNode = null;
                                            previewPreloader = new CKEDITOR.dom.element( 'embed', editor.document );

                                            // Try to detect any embed or object tag that has Flash parameters.
                                            var fakeImage = this.getSelectedElement();
                                            if ( fakeImage && fakeImage.data( 'cke-real-element-type' ) && fakeImage.data( 'cke-real-element-type' ) == 'flash' )
                                            {
                                                    this.fakeImage = fakeImage;

                                                    var realElement = editor.restoreRealElement(fakeImage),
                                                    objectNode = null, embedNode = null, paramMap = {};
                                                    if ( realElement.getName() == 'cke:object' )
                                                    {
                                                            objectNode = realElement;
                                                            var embedList = objectNode.getElementsByTag( 'embed', 'cke' );
                                                            if ( embedList.count() > 0 )
                                                                    embedNode = embedList.getItem( 0 );
                                                            var paramList = objectNode.getElementsByTag( 'param', 'cke' );
                                                            for ( var i = 0, length = paramList.count() ; i < length ; i++ )
                                                            {
                                                                    var item = paramList.getItem( i ),
                                                                            name = item.getAttribute( 'name' ),
                                                                            value = item.getAttribute( 'value' );
                                                                    paramMap[ name ] = value;
                                                            }
                                                    }
                                                    else if ( realElement.getName() == 'cke:embed' )
                                                            embedNode = realElement;

                                                    this.objectNode = objectNode;
                                                    this.embedNode = embedNode;

                                                    this.setupContent( objectNode, embedNode, paramMap, fakeImage );
                                            }                                   
                              break;
                              case 'info':
                                            // Clear previously saved elements.
                                            this.fakeImage = this.videoNode = configItem = null;
                                            var fakeImage = this.getSelectedElement();
                                            if ( fakeImage && fakeImage.data( 'cke-real-element-type' ) && fakeImage.data( 'cke-real-element-type' ) == 'video' )
                                            {
                                                this.fakeImage = fakeImage;
                                                var videoNode = editor.restoreRealElement(fakeImage), videos = [];
                                                if (videoNode.getName() == 'cke:jwvideo' ) {
                                                    if ( videoNode.getId() && videoNode.getId().match(/^playervideo[0-9]*-parent$/)) {
                                                        var divList = videoNode.getElementsByTag('div');
                                                        if ( divList.count() > 0 ) {
                                                            configItem = divList.getItem(0);
                                                            if (configItem.getId().match( /^playervideo[0-9]*-config$/)) {
                                                                var oC = configItem.getText().split(' ');
                                                                for (var o = 0 ; o < oC.length ; o++) {
                                                                    var tmp = oC[o].split( '=' );
                                                                    videos[tmp[0]] = tmp[1];
                                                                }
                                                                is_new_videoplayer = false ;                                                    
                                                            }
                                                        }                                            
                                                    }                                        
                                                }
                                                this.videoNode = videoNode;
                                                this.setupContent(videoNode, videos);
                                                LoadSelection(videos);
                                            }
                                            else
                                                    this.setupContent( null, [] );
                              break;
                          
                             }
                             
                              
                               
				
			},
			onOk : function()
			{
                                var CurrObj = CKEDITOR.dialog.getCurrent();
                                var tab = CurrObj.definition.dialog._.currentTabId;
                                
                               src_flash = this.getValueOf( 'Upload', 'src' );
                               src_video = this.getValueOf( 'info', 'src0' );
                                                           
                                 
                               switch(tab){
                                   case 'Upload':
                                       
                                       if (src_flash){
                                           var         objectNode = null,
                                                    embedNode = null,
                                                    paramMap = null;

                                            if ( !this.fakeImage )
                                            {
                                                    if ( makeObjectTag )
                                                    {
                                                            objectNode = CKEDITOR.dom.element.createFromHtml( '<cke:object></cke:object>', editor.document );
                                                            var attributes = {
                                                                    classid : 'clsid:d27cdb6e-ae6d-11cf-96b8-444553540000',
                                                                    codebase : 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0'
                                                            };
                                                            objectNode.setAttributes( attributes );
                                                    }
                                                    if ( makeEmbedTag )
                                                    {
                                                            embedNode = CKEDITOR.dom.element.createFromHtml( '<cke:embed></cke:embed>', editor.document );
                                                            embedNode.setAttributes(
                                                                    {
                                                                            type : 'application/x-shockwave-flash',
                                                                            pluginspage : 'http://www.macromedia.com/go/getflashplayer'
                                                                    } );
                                                            if ( objectNode )
                                                                    embedNode.appendTo( objectNode );
                                                    }
                                            }
                                            else
                                            {
                                                    objectNode = this.objectNode;
                                                    embedNode = this.embedNode;
                                            }

                                            // Produce the paramMap if there's an object tag.
                                            if ( objectNode )
                                            {
                                                    paramMap = {};
                                                    var paramList = objectNode.getElementsByTag( 'param', 'cke' );
                                                    for ( var i = 0, length = paramList.count() ; i < length ; i++ )
                                                            paramMap[ paramList.getItem( i ).getAttribute( 'name' ) ] = paramList.getItem( i );
                                            }

                                            // A subset of the specified attributes/styles
                                            // should also be applied on the fake element to
                                            // have better visual effect. (#5240)
                                            var extraStyles = {}, extraAttributes = {};
                                            this.commitContent( objectNode, embedNode, paramMap, extraStyles, extraAttributes );
                                            
                                            // Refresh the fake image.
                                            var newFakeImage = editor.createFakeElement( objectNode || embedNode, 'cke_flash', 'flash', true );
                                            newFakeImage.setAttributes( extraAttributes );
                                            newFakeImage.setStyles( extraStyles );
                                            if ( this.fakeImage )
                                            {
                                                    newFakeImage.replace( this.fakeImage );
                                                    editor.getSelection().selectElement( newFakeImage );
                                            }
                                            else //this inserted code flash empty
                                            editor.insertElement( newFakeImage );
                                           
                                       }
                                       
                                       
                                   
                                   break;
                                   
                                   case 'iframe':
                                       
                                       for (var i=0; i<window.frames.length; i++) {
                                    if(window.frames[i].name == 'iframeMediaEmbed') {
                                        var content = window.frames[i].document.getElementById("embed").value;
                                    }
                                }
                                final_html = 'MediaEmbedInsertData|---' + escape('<div class="media_embed">'+content+'</div>') + '---|MediaEmbedInsertData';
                                    editor.insertHtml(final_html);
                                    updated_editor_data = editor.getData();
                                    clean_editor_data = updated_editor_data.replace(final_html,'<div class="media_embed">'+content+'</div>');
                                    editor.setData(clean_editor_data);
                                       
                                   break;
                                   
                                   case 'info':
                                                
                                            if(src_video){
                                                // If there's no selected element create one. Otherwise, reuse it
                                                UpdateMovie(); 
                                                var randomnumber = generateId();
                                                var videoNode = null;
                                                if ( !this.fakeImage )
                                                {
                                                        videoNode = CKEDITOR.dom.element.createFromHtml( '<cke:jwvideo></cke:jwvideo>', editor.document );
                                                        videoNode.setAttributes(
                                                        {
                                                                id : 'player'+randomnumber+'-parent',
                                                                width: oMedia['width'],
                                                                height: oMedia['height'],
                                                                poster: oMedia['previewUrl']
                                                        });
                                                }
                                                else
                                                {
                                                        this.videoNode.removeAttribute('width');
                                                        this.videoNode.removeAttribute('height');
                                                        this.videoNode.removeAttribute('poster');
                                                        this.videoNode.setAttributes(
                                                        {
                                                                width: oMedia['width'],
                                                                height: oMedia['height'],
                                                                poster: oMedia['previewUrl']
                                                        });
                                                        videoNode = this.videoNode;
                                                }

                                                var extraStyles = {}, videos = [];
                                                this.commitContent( videoNode, extraStyles, videos );                                               
                                                var innerHtml = getVideoInnerHTML(randomnumber);

                                                videoNode.setHtml(innerHtml);                        

                                                // Refresh the fake image.
                                                var newFakeImage = editor.createFakeElement( videoNode, 'cke_jwvideo', 'video', false );
                                                newFakeImage.setStyles( extraStyles );
                                                if ( this.fakeImage )
                                                {
                                                    newFakeImage.replace( this.fakeImage );
                                                    editor.getSelection().selectElement(newFakeImage );
                                                }
                                                else 
                                                    editor.insertElement(newFakeImage);

                                                // alignment
                                                setCustomAlign(editor, oMedia['cmbAlign']);
                                            }
                                   break;


                                                }
				
				
			},

			onHide : function()
			{   
                            var CurrObj = CKEDITOR.dialog.getCurrent();
                                var tab = CurrObj.definition.dialog._.currentTabId;
                                
                              
                               switch(tab){
                                   case 'Upload':
                                             if ( this.preview )
                                              this.preview.setHtml('');
                                   break;
                                   case 'info':
                                        if ( this.previewImage )
                                        {
                                                this.previewImage.removeListener( 'load', onImgLoadEvent );
                                                this.previewImage.removeListener( 'error', onImgLoadErrorEvent );
                                                this.previewImage.removeListener( 'abort', onImgLoadErrorEvent );
                                                this.previewImage.remove();
                                                this.previewImage = null;		// Dialog is closed.
                                        }
                                   break; 
                           }
                            
                            
                            
				
                                    
                                    
                                    
                                    
			},
                        
			contents : [
                                {
					id : 'Upload',
					hidden : true,
					filebrowser : 'uploadButton',
					label : 'Flash',
                                        
					elements :
					[
						{
							type : 'file',
							id : 'upload',
							label : editor.lang.common.upload,
							size : 38
						},
						{
							type : 'fileButton',
							id : 'uploadButton',
							label : editor.lang.common.uploadSubmit,
							filebrowser : 'Upload:src',
							'for' : [ 'Upload', 'upload' ]
						},
                                                {
							type : 'vbox',
							padding : 0,
							children :
							[
								{
									type : 'hbox',
									widths : [ '280px', '110px' ],
									align : 'right',
									children :
									[
										{
											id : 'src',
											type : 'text',
											label : editor.lang.common.url,
											required : true,
											//validate : CKEDITOR.dialog.validate.notEmpty( editor.lang.flash.validateSrc ),
											setup : loadValue,
											commit : commitValue,
											onLoad : function()
											{
												var dialog = this.getDialog(),
												updatePreview = function( src ){
													// Query the preloader to figure out the url impacted by based href.
													previewPreloader.setAttribute( 'src', src );
													dialog.preview.setHtml( '<embed height="100%" width="100%" src="'
														+ CKEDITOR.tools.htmlEncode( previewPreloader.getAttribute( 'src' ) )
														+ '" type="application/x-shockwave-flash"></embed>' );
												};
												// Preview element
												dialog.preview = dialog.getContentElement( 'Upload', 'preview' ).getElement().getChild( 3 );
                                                                                               
												// Sync on inital value loaded.
												this.on( 'change', function( evt ){
                                                                                                               
														if ( evt.data && evt.data.value ){
															updatePreview( evt.data.value );
                                                                                                                        
                                                                                                                        
                                                                                                                }
													} );
												// Sync when input value changed.
												this.getInputElement().on( 'change', function( evt ){
                                                                                                       
													updatePreview( this.getValue() );
												}, this );
											}
										},
										{
											type : 'button',
											id : 'browse',
											filebrowser : 'Upload:src',
											hidden : true,
											// v-align with the 'src' field.
											// TODO: We need something better than a fixed size here.
											style : 'display:inline-block;margin-top:10px;',
											label : editor.lang.common.browseServer
										}
                                                                                
									]
								}
							]
						},
						{
							type : 'hbox',
							widths : [ '25%', '25%', '25%', '25%', '25%' ],
							children :
							[
								{
									type : 'text',
									id : 'width',
									style : 'width:95px',
									label : editor.lang.common.width,
									validate : CKEDITOR.dialog.validate.htmlLength( editor.lang.common.invalidHtmlLength.replace( '%1', editor.lang.common.width ) ),
									setup : loadValue,
									commit : commitValue
								},
								{
									type : 'text',
									id : 'height',
									style : 'width:95px',
									label : editor.lang.common.height,
									validate : CKEDITOR.dialog.validate.htmlLength( editor.lang.common.invalidHtmlLength.replace( '%1', editor.lang.common.height ) ),
									setup : loadValue,
									commit : commitValue
								},
								{
									type : 'text',
									id : 'hSpace',
									style : 'width:95px',
									label : editor.lang.flash.hSpace,
									validate : CKEDITOR.dialog.validate.integer( editor.lang.flash.validateHSpace ),
									setup : loadValue,
									commit : commitValue
								},
								{
									type : 'text',
									id : 'vSpace',
									style : 'width:95px',
									label : editor.lang.flash.vSpace,
									validate : CKEDITOR.dialog.validate.integer( editor.lang.flash.validateVSpace ),
									setup : loadValue,
									commit : commitValue
								}
							]
						},

						{
							type : 'vbox',
							children :
							[
								{
									type : 'html',
									id : 'preview',
									style : 'width:95%;',
									html : previewAreaHtml
								}
							]
						}
					]
				},
                                {
                             id : 'iframe',
                             label : 'Youtube & Vimeo',
                             expand : true,
                             elements :
                                   [
                                      {
						               type : 'html',
						               id : 'pageMediaEmbed',
						               label : 'Embed Media',
						               style : 'width : 100%;',
						               html : '<iframe src="/main/inc/lib/ckeditor/_source/plugins/MediaEmbed/dialogs/mediaembed.html" frameborder="0" name="iframeMediaEmbed" id="iframeMediaEmbed" allowtransparency="1" style="width:100%;margin:0;padding:0;"></iframe>'
						              }
                                   ]
                          },
                {
				id : 'info',
                                label:'Movie/Media File',
				elements :
				[
					{
						type : 'hbox',
						widths: [ '', '100px'],
                                                children : [
							{
								type : 'text',
								id : 'src0',
								label : lang.sourceVideo,
                                                                required : true,
//                                                                validate : function()
//                                                                {
//                                                                    
//                                                                    if (this.getValue().length == 0) {
//                                                                        alert(lang.validateSrc);
//                                                                        return false;
//                                                                    }
//                                                                    
//                                                                    if (!(/\.(flv|mpg|mpeg|mp4|avi|wmv|mov|asf)/i.test(this.getValue()))) {
//                                                                        alert(lang.invalidFileType) ;
//                                                                        return false ;
//                                                                    }
//                                                                        
//                                                                },
								commit : commitSrc,
								setup : loadSrc
							},
							{
								type : 'button',
								id : 'browse',
								hidden : 'true',
								style : 'display:inline-block;margin-top:10px;',
								filebrowser :
								{
									action : 'Browse',
									target: 'info:src0',
									url: editor.config.filebrowserVideoBrowseUrl || editor.config.filebrowserBrowseUrl
								},
								label : editor.lang.common.browseServer
							}
                                                ]
					},
                                        {
						type : 'hbox',
						widths: [ '', '100px'],
                                                children : [
							{
								type : 'text',
								id : 'src1',
								label : lang.sourceVideoHtml,
                                                                required : true,
                                                                validate : function()
                                                                {
                                                                    if (this.getValue().length > 0 && !(/\.(ogg|ogv|mp4|webm)/i.test(this.getValue()))) {
                                                                        alert(lang.invalidFileType) ;
                                                                        return false ;
                                                                    }                                                                        
                                                                },
								commit : commitSrc,
								setup : loadSrc
							},
							{
								type : 'button',
								id : 'browse',
								hidden : 'true',
								style : 'display:inline-block;margin-top:10px;',
								filebrowser :
								{
									action : 'Browse',
									target: 'info:src1',
									url: editor.config.filebrowserVideoBrowseUrl || editor.config.filebrowserBrowseUrl
								},
								label : editor.lang.common.browseServer
							}
                                                ]
					},
					{
						type : 'hbox',
						widths: [ '25%', '25%', '25%', '25%'],
						children : [
							{
								type : 'text',
								id : 'width',
								label : editor.lang.common.width,
								'default' : 400,
								validate : CKEDITOR.dialog.validate.notEmpty( lang.widthRequired ),
								commit : commitValue,
								setup : loadValue
							},
							{
								type : 'text',
								id : 'height',
								label : editor.lang.common.height,
								'default' : 300,
								validate : CKEDITOR.dialog.validate.notEmpty(lang.heightRequired ),
								commit : commitValue,
								setup : loadValue
							},
                                                        {
                                                            id : 'cmbAlign',
                                                            type : 'select',
                                                            widths : [ '35%','65%' ],
                                                            style : 'width:90px',
                                                            label : editor.lang.common.align,
                                                            'default' : '',
                                                            items :
                                                            [
                                                                    [ editor.lang.common.notSet , ''],
                                                                    [ editor.lang.common.alignLeft , 'left'],
                                                                    [ editor.lang.common.alignRight , 'right'],
                                                                    [ editor.lang.common.alignCenter , 'center']
                                                            ]   
                                                        },
                                                        {
                                                            id : 'cmbBuffer',
                                                            type : 'select',
                                                            widths : [ '35%','65%'],
                                                            style : 'width:90px',
                                                            label : lang.bufferVideo,
                                                            'default' : 1,
                                                            items :
                                                            [
                                                                    [1,1],[2,2],[3,3],[4,4],[5,5],
                                                                    [6,6],[7,7],[8,8],[9,9],[10,10],
                                                                    [11,11],[12,12],[13,13],[14,14],[15,15],
                                                                    [16,16],[17,17],[18,18],[19,19],[20,20]
                                                            ]   
                                                        }
                                                    ]
					},
                                        {
						type : 'hbox',
						widths: [ '25%', '25%', ''],
						children : [
							{
								type : 'checkbox',
								id : 'autoplay',
								label : lang.autoPlay,
								//'default' : true,
								commit : commitValue,
								setup : loadValue
							},
							{
								type : 'checkbox',
								id : 'loop',
								label : lang.loop,
								//'default' : true,
								commit : commitValue,
								setup : loadValue
							},
                                                        {
								type : 'checkbox',
								id : 'fullscreen',
								label : lang.fullScreen,
								//'default' : true,
								commit : commitValue,
								setup : loadValue
							}
                                                    ]
					},
					{
						type : 'hbox',
						widths: [ '', '10px'],
                                                children : [
							{
								type : 'text',
								id : 'poster',
								label : lang.poster,
								commit : commitValue,
								setup : loadValue                                                                
							},
							{
								type : 'button',
								id : 'browse',
								hidden : 'true',
								style : 'display:inline-block;margin-top:10px;',
								filebrowser :
								{
									action : 'Browse',
									target: 'info:poster',
									url: editor.config.filebrowserImageBrowseUrl || editor.config.filebrowserBrowseUrl
								},
								label : editor.lang.common.browseServer
							}]						
					}
				]
			}
                                
				
				
			]
		};
	} );
})();
