	CKEDITOR.dialog.add('jwplayer', function (editor) {
		var lang = editor.lang.jwplayer;
		var JWplayer = CKEDITOR.plugins.get('jwplayer').path + 'jwplayer/player.swf';

		function UpdatePreview() {
			document.getElementById("_video_preview").innerHTML = ReturnPlayer()
		}
		function ReturnPlayer() {
			var fileUrl = CKEDITOR.dialog.getCurrent().getContentElement('info', 'video_url').getValue();
		  var previewUrl = CKEDITOR.dialog.getCurrent().getContentElement('info', 'preview_url').getValue();
			var width = CKEDITOR.dialog.getCurrent().getContentElement('info', 'width').getValue();
			var height = CKEDITOR.dialog.getCurrent().getContentElement('info', 'height').getValue();
			var auto = CKEDITOR.dialog.getCurrent().getContentElement('info', 'auto').getValue();
			var skin = '';
			var selectskin = CKEDITOR.dialog.getCurrent().getContentElement('info', 'skin').getValue();
			if (selectskin != 'default') {
				skin = "&skin=" + CKEDITOR.plugins.get('jwplayer').path + "jwplayer/skin/" + selectskin + ".zip "
			}
			var JWEmbem = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'" + " width='" + width + "' height='" + height + "'>" + " <param name='movie' value='" + JWplayer + "'>" + " <param name='allowfullscreen' value='true'>" + " <param name='allowscriptaccess' value='always'>" + " <param name='flashvars' value='file=" + fileUrl + "&autostart=" + auto + "'>";
			if (selectskin != 'default') {
				JWEmbem += "<param name='flashvars' value='" + skin + "'>"
			}
		  
		  var preview = '';
		  
		  if(previewUrl != ''){
			preview = "&image=" + previewUrl;
		  }
		  
		  previewUrl
		  
			JWEmbem += " <embed id='player1' name='player1'";
			JWEmbem += " width='" + width + "' height='" + height + "'" + " src='" + JWplayer + "' allowscriptaccess='always'" + " allowfullscreen='true' flashvars='file=" + fileUrl + preview + skin + "&autostart=" + auto + "'/>" + "</object>";
		   
		  return JWEmbem
		}
		return {
			title: 'Video Player',
			minWidth: 520,
			minHeight: 340,
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
								'default': 'default',
								label: 'Skin video Player',
								items: [['default', 'default'], ['simple', 'simple'], ['glow', 'glow'], ['snel', 'snel'], ['modieus', 'modieus'], ['stormtrooper', 'stormtrooper'], ['beelden', 'beelden'], ['stijl', 'stijl']],
								onChange: UpdatePreview
							}, {
								type: 'text',
								id: 'width',
								style: 'width:95px',
						 label: 'Width:',
								onChange: UpdatePreview
							}, {
								type: 'text',
								id: 'height',
								style: 'width:95px',
								label: 'Height:',
								onChange: UpdatePreview
							}, {
								type: 'checkbox',
								id: 'auto',
								'default': true,
								label: editor.lang.flash.chkPlay,
								onChange: UpdatePreview
							}]
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
			buttons: [CKEDITOR.dialog.okButton, CKEDITOR.dialog.cancelButton],
			onOk: function () {
				editor.setData(editor.getData() + ReturnPlayer())
			},
			onShow : function()
			{
				// Clear previously saved elements.
				this.fakeImage = this.jwplayerNode = null;

				var fakeImage = this.getSelectedElement();
				if ( fakeImage && fakeImage.data( 'cke-real-element-type' ) && fakeImage.data( 'cke-real-element-type' ) == 'jwplayer' )
				{
					this.fakeImage = fakeImage;

					var jwplayerNodeNode = editor.restoreRealElement( fakeImage ),
					 jwplayers = [],
						sourceList = jwplayerNodeNode.getElementsByTag( 'source', '' );
					if (sourceList.count()==0)
						sourceList = jwplayerNodeNode.getElementsByTag( 'source', 'cke' );

					for ( var i = 0, length = sourceList.count() ; i < length ; i++ )
					{
						var item = sourceList.getItem( i );
						jwplayers.push( {src : item.getAttribute( 'src' ), type: item.getAttribute( 'type' )} );
					}

					this.jwplayerNode = jwplayerNode;

					this.setupContent( jwplayerNode, jwplayers );
				}
				else
					this.setupContent( null, [] );
			}
			
		}
	});
