	CKEDITOR.dialog.add('jwplayer', function (editor) {
		var lang = editor.lang.jwplayer;
		var JWplayer = CKEDITOR.plugins.get('jwplayer').path + 'jwplayer/player.swf';
                var JWplayerJs = CKEDITOR.plugins.get('jwplayer').path + 'jwplayer/jwplayer.min.js';
                var JWplayerSkin = CKEDITOR.plugins.get('jwplayer').path + "jwplayer/skin/facebook.zip";
                var JWplayerJquery = CKEDITOR.plugins.get('jwplayer').path + "jwplayer/jquery-1.5.1.min.js";
                var oMedia = {} ;
                var is_new_videoplayer = true;
                
		function UpdatePreview() {
                    document.getElementById("_video_preview").innerHTML = ReturnPlayer()
		}
		function ReturnPlayer() {
                    // update values
                    UpdateMovie();
                    return getVideoInnerHTML();
		}

                function getVideoInnerHTML() {
                    var s = '' ;
                    var randomnumber = Math.floor( Math.random() * 1000001 ) ;                                                         
                    s += '<br />\n' ;
                    s += '<jwplayer id="player' + randomnumber + '-parent">\n';

                    // A hidden div containing setting, added width, height, overflow for MSIE7
                    s += '<div id="player' + randomnumber + '-config" style="display: none; visibility: hidden; width: 0px; height: 0px; overflow: hidden;">' ;                            
                    s += 'fileUrl='+oMedia['fileUrl']+' previewUrl='+oMedia['previewUrl']+' width='+oMedia['width']+' height='+oMedia['height']+' auto='+oMedia['auto']+' selectskin='+oMedia['selectskin'];
                    s += '</div>' ;

                    s += '<div id="test" style="border-style: none; height: ' + oMedia['height'] + 'px; width: ' + oMedia['width'] + 'px; overflow: hidden; background-color: rgb(220, 220, 220);">';
                    s += '<div id="player' + randomnumber + '" class="thePlayer">';  
                    s += '<script src="' + JWplayerJs + '" type="text/javascript"></script>';
                    s += '<div id="player' + randomnumber + '-parent2">Loading the player ...</div>';    
                    s += '<script type="text/javascript">';
                    s += 'jwplayer("player' + randomnumber + '-parent2").setup({';
                    s += 'flashplayer: "'+ JWplayer +'",';
                    s += 'autostart: "'+ oMedia['auto'] +'",';
                    s += 'file: "'+ oMedia['fileUrl'] +'",';
                    s += 'height: '+ oMedia['height'] +',';
                    s += 'width: '+ oMedia['width'] +',';
                    s += 'skin: "'+ oMedia['selectskin']+'"';
                    s += '});';        
                    s += '</script>';                        
                    s += '</div>';    
                    s += '</div>';
                    s += '</jwplayer>';                                                     
                    return s;
                }

                function UpdateMovie() {
                        oMedia['fileUrl']    = CKEDITOR.dialog.getCurrent().getContentElement('info', 'video_url').getValue();
                        oMedia['previewUrl'] = CKEDITOR.dialog.getCurrent().getContentElement('info', 'preview_url').getValue();
                        oMedia['width']      = CKEDITOR.dialog.getCurrent().getContentElement('info', 'width').getValue();
                        oMedia['height']     = CKEDITOR.dialog.getCurrent().getContentElement('info', 'height').getValue();
                        oMedia['auto']       = CKEDITOR.dialog.getCurrent().getContentElement('info', 'auto').getValue();
                        oMedia['selectskin'] = CKEDITOR.dialog.getCurrent().getContentElement('info', 'skin').getValue();                    
                }

                function LoadSelection(e) { 
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'video_url').setValue(e['fileUrl']);
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'preview_url').setValue(e['previewUrl']);
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'width').setValue(e['width']);
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'height').setValue(e['height']);
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'auto').setValue(e['auto']);
                        CKEDITOR.dialog.getCurrent().getContentElement('info', 'skin').setValue(e['selectskin']);
                }
                
                
		return {
			title: 'Video Player',
			minWidth: 520,
			minHeight: 340,
                        onShow : function()
			{
                            
                                // Clear previously saved elements.
                                this.fakeImage = this.jwplayerNode = null;

                                var fakeImage = this.getSelectedElement();
                                if ( fakeImage && fakeImage.data( 'cke-real-element-type' ) && fakeImage.data( 'cke-real-element-type' ) == 'jwplayer' )
                                {
                                        this.fakeImage = fakeImage;
                                        var jwplayerNode = editor.restoreRealElement(fakeImage), videos = [];                                        

                                        this.jwplayerNode = jwplayerNode;

                                        this.setupContent( jwplayerNode, videos );
                                }
                                else
                                        this.setupContent( null, [] );
                                
                                /*
                                var oSel = null ;
                                var configItem = null;
                                                            
				// Clear previously saved elements.
				this.fakeImage = this.jwplayerNode = null;
				var fakeImage = this.getSelectedElement();
                                //alert(fakeImage.data('cke-real-element-type'));
				if ( fakeImage && fakeImage.data( 'cke-real-element-type' ) && fakeImage.data('cke-real-element-type') == 'jwplayer' )
				{                                    
                                    var realElement = editor.restoreRealElement(fakeImage);                                    
                                    if (realElement.getName() == 'cke:jwplayer' ) {                                        
                                        oSel = realElement;                                        
                                        if ( oSel.getId() && oSel.getId().match(/^player[0-9]*-parent$/)) {    
                                            var divList = oSel.getElementsByTag('div');
                                            if ( divList.count() > 0 ) {
						configItem = divList.getItem(0);
                                                if (configItem.getId().match( /^player[0-9]*-config$/)) {                                               
                                                    var oC = configItem.getText().split(' ') ;
                                                    for (var o = 0 ; o < oC.length ; o++) {
                                                        var tmp = oC[o].split( '=' );
                                                        oMedia[tmp[0]] = tmp[1];
                                                    }
                                                    is_new_videoplayer = false ;                                                    
                                                }
                                            }                                            
                                        }                                        
                                    }
                                    // load Selection
                                    LoadSelection(oMedia);                                        
				}
				else {
                                    // new video
                                    oMedia = {};
                                    //this.setupContent( null, [] );
                                }
                                */
			},			
			onOk: function () {
                                                        
                            // If there's no selected element create one. Otherwise, reuse it
                            var jwplayerNode = null;
                            if ( !this.fakeImage )
                            {
                                    jwplayerNode = CKEDITOR.dom.element.createFromHtml( '<cke:jwplayer></cke:jwplayer>', editor.document );

                            }
                            else
                            {
                                    jwplayerNode = this.jwplayerNode;
                            }

                            var extraStyles = {}, videos = [];
                            this.commitContent(jwplayerNode, extraStyles, videos);

                            var innerHtml = getVideoInnerHTML();                            
                            jwplayerNode.setHtml(innerHtml);

                            // Refresh the fake image.
                            var newFakeImage = editor.createFakeElement( jwplayerNode, 'cke_jwplayer', 'jwplayer', false );
                            newFakeImage.setStyles( extraStyles );
                            if ( this.fakeImage )
                            {
                                    newFakeImage.replace( this.fakeImage );
                                    editor.getSelection().selectElement( newFakeImage );
                            }
                            else
                                    editor.insertElement( newFakeImage );
                            
                            /*
                            this.fakeImage = null;
                            var fakeImage  = this.getSelectedElement();
                            
                            var realElement = editor.restoreRealElement(fakeImage);
                            
                            // Refresh the fake image.
                            var newFakeImage = editor.createFakeElement( realElement, 'cke_jwplayer', 'jwplayer', false );                                                     
                            if (fakeImage && !is_new_videoplayer) {                               
                                UpdateMovie();
                                newFakeImage.replace(fakeImage);
                                editor.getSelection().selectElement( newFakeImage );
                                editor.setData(editor.getData());
                            }
                            else {
                                editor.insertElement( newFakeImage );
                                editor.setData(editor.getData()+ ReturnPlayer());
                            }
                            */
                            
                            /*if (!is_new_videoplayer) {                                                                
                                var oSel = null ;
                                var configItem = null;
                                                            
				// Clear previously saved elements.
				this.fakeImage = this.jwplayerNode = null;
				var fakeImage = this.getSelectedElement();
                                //alert(fakeImage.data('cke-real-element-type'));
				if ( fakeImage && fakeImage.data( 'cke-real-element-type' ) && fakeImage.data('cke-real-element-type') == 'jwplayer' )
				{
                                    var realElement = editor.restoreRealElement(fakeImage); 
                            
                                    if (realElement.getName() == 'cke:jwplayer' ) {
                                        //realElement.remove();
                                        //editor.getSelection().selectElement(realElement);
                                    }
                                }
                                editor.setData(editor.getData()+ ReturnPlayer());                                
                            }
                            else {
                                editor.setData(editor.getData() + ReturnPlayer());
                            }*/				
			},
			contents: [{
				id: 'info',
				label: '',
				title: '',
				expand: true,
				padding: 0,
				elements: [{
					type: 'vbox',
					widths: ['280px', '30px'],
					align: 'left',
					children: [{
						type: 'hbox',
						widths: ['280px', '30px'],
						align: 'left',
						children: [{
							type: 'text',
							id: 'video_url',
							label: 'Youtube URL Or Streaming URL',
							onChange: UpdatePreview
						}, {
							type: 'button',
							id: 'browse',
							//filebrowser: 'info:video_url',
                                                        filebrowser :
							{
								action : 'Browse',
								target: 'info:video_url',
								url: editor.config.filebrowserVideoBrowseUrl
							},
							label: editor.lang.common.browseServer,
							style: 'display:inline-block;margin-top:8px;'
						}]
					},				         
				    {
                                            type: 'hbox',
                                            widths: ['280px', '10px'],
                                            align: 'left',
                                            children:[{
                                                type: 'text',
                                                id: 'preview_url',
                                                label: 'Preview Image',
                                                onChange: UpdatePreview
                                            }, {
                                                    type : 'button',
                                                    id : 'browse',
                                                    style : 'display:inline-block;margin-top:8px;',
                                                    filebrowser :
                                                    {
                                                            action : 'Browse',
                                                            target: 'info:preview_url',
                                                            url: editor.config.filebrowserImageBrowseUrl
                                                    },
                                                    label : editor.lang.common.browseServer
                                            }]
					},				
					{
						type: 'hbox',
						widths: ['150px', '150px'],
						align: 'left',
						children: [{
							type: 'vbox',
							widths: ['150px', '150px'],
							align: 'left',
							children: [{
                                                                    type: 'select',
                                                                    id: 'skin',
                                                                    'default': 'facebook',
                                                                    label: 'Skin video Player',
                                                                    items: [['default', 'default'], ['simple', 'simple'], ['glow', 'glow'], ['snel', 'snel'], ['modieus', 'modieus'], ['stormtrooper', 'stormtrooper'], ['beelden', 'beelden'], ['stijl', 'stijl']],
                                                                    onChange: UpdatePreview
                                                                  }, 
                                                                  {
                                                                    type: 'text',
                                                                    id: 'width',
                                                                    style: 'width:95px',
                                                                    label: 'Width:',
                                                                    'default': 600,
                                                                    onChange: UpdatePreview
                                                                  }, 
                                                                  {
                                                                    type: 'text',
                                                                    id: 'height',
                                                                    style: 'width:95px',
                                                                    label: 'Height:',
                                                                    'default': 250,
                                                                    onChange: UpdatePreview
                                                                  }, 
                                                                  {
                                                                    type: 'checkbox',
                                                                    id: 'auto',
                                                                    'default': true,
                                                                    label: editor.lang.flash.chkPlay,
                                                                    onChange: UpdatePreview
                                                                  }
                                                         ]
                                                    }, {
							type: 'vbox',
							widths: ['280px', '10px'],
							align: 'left',
							children: [{
								type: 'html',
								id: 'preview',
								html: '<div id="_video_preview" ><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" height="200px" width="200px"> <param name="movie" value="' + JWplayer + '" /> <param name="allowfullscreen" value="true" /> <param name="allowscriptaccess" value="always" /> <param name="flashvars" value="autostart=false" /> <embed allowfullscreen="true" allowscriptaccess="always" flashvars="autostart=false" height="200px" id="player1" name="player1" src="' + JWplayer + '" width="200px"></embed></object></div>'
							}]
                                                    }]
                                            }]
                                    }]
			}],
			buttons: [CKEDITOR.dialog.okButton, CKEDITOR.dialog.cancelButton]                        		
		}
	});
