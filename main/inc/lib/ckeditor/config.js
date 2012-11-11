/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/*CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};
*/
CKEDITOR.editorConfig = function(config) {
    config.enterMode = CKEDITOR.ENTER_BR;
    config.defaultLanguage = 'en';
    config.language = 'en';
    config.extraPlugins = 'asciimath,audio,video,MediaEmbed,certificate,mascotmanager,mindmaps,youtube,vimeo,videoplayer,toolbarswitch';
    // Define if the toolbar can be collapsed by the user. If disabled, the collapser button will not be displayed
    config.toolbarCanCollapse = false;

    config.filebrowserBrowseUrl = '/main/inc/lib/ckeditor/kcfinder/browse.php?type=files&lms=dokeos';
    config.filebrowserImageBrowseUrl = '/main/inc/lib/ckeditor/kcfinder/browse.php?type=images&lms=dokeos';
    config.filebrowserMascotmanagerBrowseUrl = '/main/inc/lib/ckeditor/kcfinder/browse.php?type=mascot&lms=dokeos';
    config.filebrowserMindmapsBrowseUrl = '/main/inc/lib/ckeditor/kcfinder/browse.php?type=mindmaps&lms=dokeos';
    config.filebrowserFlashBrowseUrl = '/main/inc/lib/ckeditor/kcfinder/browse.php?type=animations&lms=dokeos';
    config.filebrowserVideoplayerBrowseUrl = '/main/inc/lib/ckeditor/kcfinder/browse.php?type=animations&lms=dokeos';
    config.filebrowserAudioBrowseUrl = '/main/inc/lib/ckeditor/kcfinder/browse.php?type=audio&lms=dokeos';
    config.filebrowserVideoBrowseUrl = '/main/inc/lib/ckeditor/kcfinder/browse.php?type=video&lms=dokeos';

    config.filebrowserUploadUrl = '/main/inc/lib/ckeditor/kcfinder/upload.php?type=files&lms=dokeos';
    config.filebrowserImageUploadUrl = '/main/inc/lib/ckeditor/kcfinder/upload.php?type=images&lms=dokeos';
    config.filebrowserMascotmanagerUploadUrl = '/main/inc/lib/ckeditor/kcfinder/browse.php?type=mascot&lms=dokeos';
    config.filebrowserMindmapsUploadUrl = '/main/inc/lib/ckeditor/kcfinder/browse.php?type=mindmaps&lms=dokeos';
    config.filebrowserFlashUploadUrl = '/main/inc/lib/ckeditor/kcfinder/upload.php?type=animations&lms=dokeos';
    config.filebrowserVideoplayerUploadUrl = '/main/inc/lib/ckeditor/kcfinder/upload.php?type=animations&lms=dokeos';
    config.filebrowserAudioUploadUrl = '/main/inc/lib/ckeditor/kcfinder/upload.php?type=audio&lms=dokeos';
    config.filebrowserVideoUploadUrl = '/main/inc/lib/ckeditor/kcfinder/upload.php?type=video&lms=dokeos';

	   config.toolbar = 'Notebook';
	   config.toolbar_Notebook =
		[
			{ name: 'document',  items : [ 'Undo','Redo'] },
			{ name: 'document1', items : [ 'Link','Unlink' ] },
			{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio'] },
			{ name: 'document3', items : [ 'SpecialChar'] },
			{ name: 'document4', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','TextColor'] },
			{ name: 'document5', items : [ 'Font','FontSize'] },
			{ name: 'document6', items : [ 'Bold','Italic','Underline'] },
			{ name: 'document7', items : [ 'JustifyLeft','JustifyCenter','JustifyRight'] }
		];
	   config.toolbar = 'NotebookStudent';
	   config.toolbar_NotebookStudent =
		[
			{ name: 'document',  items : [ 'Undo','Redo'] },
			{ name: 'document1', items : [ 'Link','Unlink' ] },
			{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio'] },
			{ name: 'document3', items : [ 'SpecialChar'] },
			{ name: 'document4', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','TextColor'] },
			{ name: 'document5', items : [ 'Font','FontSize'] },
			{ name: 'document6', items : [ 'Bold','Italic','Underline'] },
			{ name: 'document7', items : [ 'JustifyLeft','JustifyCenter','JustifyRight'] }
		];

	   config.toolbar = 'Documents';
	   config.toolbar_Documents =
		[
                        { name: 'document',  items : [ 'Bold','Italic','Underline'] },
                        { name: 'document1', items : [ 'TextColor','BulletedList','NumberedList'] },
			{ name: 'document2', items : [ 'Copy','PasteFromWord','Link','Unlink'] },
			{ name: 'document3', items : [ 'Undo','Redo'] },
                        { name: 'document4', items : [ 'Image','MascotManager','MindmapsManager','Audio','VideoPlayer'] },
                        { name: 'document5', items : [ 'asciimath','Table','SpecialChar','Styles','Format','FontSize','Preview','Maximize'] }
		];

	   config.toolbar = 'DocumentsStudent';
	   config.toolbar_DocumentsStudent =
		[
			{ name: 'document',  items : [ 'Save','Maximize','-','PasteFromWord','-','Undo','Redo'] },
			{ name: 'document1', items : [ 'Link','Unlink'] },
			{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio','Smiley','PageBreak','Iframe'] },
			{ name: 'document3', items : [ 'Table','HorizontalRule', 'SpecialChar','ShowBlocks'] },
			{ name: 'document4', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','TextColor' ] },
			{ name: 'document5', items : [ 'Bold','Italic','Underline'] },
			{ name: 'document6', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','Styles'] },
			{ name: 'document7', items : [ 'Format','Font','FontSize'] }
		];

	   config.toolbar = 'TrainingDescription';
	   config.toolbar_TrainingDescription =
			[
				{ name: 'document',  items : [ 'Undo','Redo'] },
				{ name: 'document1', items : [ 'Link','Unlink'] },
				{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio'] },
				{ name: 'document3', items : [ 'SpecialChar'] },
				{ name: 'document4', items : [ 'NumberedList','BulletedList','-','TextColor'] },
				{ name: 'document5', items : [ 'Font','FontSize'] },
				{ name: 'document6', items : [ 'Bold','Italic','Underline'] },
				{ name: 'document7', items : [ 'JustifyLeft','JustifyCenter','JustifyRight'] },
				{ name: 'document8', items : [ 'Source'] }
			];

	   config.toolbar = 'LearningPathDocuments';
	   config.toolbar_LearningPathDocuments =
		[
			{ name: 'document',  items : [ 'Save','Maximize','-','PasteFromWord','-','Undo','Redo' ] },
			{ name: 'document1', items : [ 'Link','Unlink' ] },
			{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio','Smiley','PageBreak','Iframe'] },
			{ name: 'document3', items : [ 'Table','HorizontalRule', 'SpecialChar','ShowBlocks'] },
			{ name: 'document4', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','TextColor'] },
			{ name: 'document5', items : [ 'Bold','Italic','Underline'] },
			{ name: 'document6', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','Styles'] },
			{ name: 'document7', items : [ 'Format','Font','FontSize'] }
		];

	   config.toolbar = 'Glossary';
	   config.toolbar_Glossary =
			[
				{ name: 'document',  items : [ 'Undo','Redo'] },
				{ name: 'document1', items : [ 'Link','Unlink'] },
				{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio'] },
				{ name: 'document3', items : [ 'SpecialChar'] },
				{ name: 'document4', items : [ 'NumberedList','BulletedList','-','TextColor'] },
				{ name: 'document5', items : [ 'Font','FontSize'] },
				{ name: 'document6', items : [ 'Bold','Italic','Underline'] },
				{ name: 'document7', items : [ 'JustifyLeft','JustifyCenter','JustifyRight'] },
				{ name: 'document8', items : [ 'Source'] }
			];

	   config.toolbar = 'Announcements';
	   config.toolbar_Announcements =
		[
			{ name: 'document',  items : [ 'Bold','Italic','Underline'] },
                        { name: 'document1', items : [ 'TextColor','BulletedList','NumberedList'] },
			{ name: 'document2', items : [ 'Copy','PasteFromWord','Link','Smiley'] }
		];

	   config.toolbar = 'AgendaStudent';
	   config.toolbar_AgendaStudent =
		[
			{ name: 'document',  items : [ 'Save','Maximize','-','PasteFromWord','-','Undo','Redo' ] },
			{ name: 'document1', items : [ 'Link','Unlink' ] },
			{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio','Smiley','PageBreak','Iframe'] },
			{ name: 'document3', items : [ 'Table','HorizontalRule', 'SpecialChar','ShowBlocks'] },
			{ name: 'document4', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','TextColor'] },
			{ name: 'document5', items : [ 'Bold','Italic','Underline'] },
			{ name: 'document6', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','Styles'] },
			{ name: 'document7', items : [ 'Format','Font','FontSize'] }
		];

	   config.toolbar = 'Agenda';
	   config.toolbar_Agenda =
		[
			{ name: 'document',  items : [ 'Save','Maximize','-','PasteFromWord','-','Undo','Redo' ] },
			{ name: 'document1', items : [ 'Link','Unlink' ] },
			{ name: 'document2', items : ['Image','MascotManager','MindmapsManager','VideoPlayer','Audio','Smiley','PageBreak','Iframe'] },
			{ name: 'document3', items : [ 'Table','HorizontalRule', 'SpecialChar','ShowBlocks'] },
			{ name: 'document4', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','TextColor'] },
			{ name: 'document5', items : [ 'Bold','Italic','Underline'] },
			{ name: 'document6', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','Styles'] },
			{ name: 'document7', items : [ 'Format','Font','FontSize'] }
		];

	   config.toolbar = 'Survey';
	   config.toolbar_Survey =
		[
			{ name: 'document',  items : [ 'Save','Maximize','-','PasteFromWord','-','Undo','Redo' ] },
			{ name: 'document1', items : [ 'Link','Unlink' ] },
			{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio','Smiley','PageBreak','Iframe'] },
			{ name: 'document3', items : [ 'Table','HorizontalRule', 'SpecialChar','ShowBlocks'] },
			{ name: 'document4', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','TextColor'] },
			{ name: 'document5', items : [ 'Bold','Italic','Underline'] },
			{ name: 'document6', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','Styles'] },
			{ name: 'document7', items : [ 'Format','Font','FontSize'] }
		];

	   config.toolbar = 'Project';
	   config.toolbar_Project =
		[
			{ name: 'document',  items : [ 'Save','Maximize','-','PasteFromWord','-','Undo','Redo' ] },
			{ name: 'document1', items : [ 'Link','Unlink' ] },
			{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio','Smiley','PageBreak','Iframe'] },
			{ name: 'document3', items : [ 'Table','HorizontalRule', 'SpecialChar','ShowBlocks'] },
			{ name: 'document4', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','TextColor'] },
			{ name: 'document5', items : [ 'Bold','Italic','Underline'] },
			{ name: 'document6', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','Styles'] },
			{ name: 'document7', items : [ 'Format','Font','FontSize'] }
		];

	   config.toolbar = 'ProjectStudent';
	   config.toolbar_ProjectStudent =
		[
			{ name: 'document',  items : [ 'Save','Maximize','-','PasteFromWord','-','Undo','Redo' ] },
			{ name: 'document1', items : [ 'Link','Unlink' ] },
			{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio','Smiley','PageBreak','Iframe'] },
			{ name: 'document3', items : [ 'Table','HorizontalRule', 'SpecialChar','ShowBlocks'] },
			{ name: 'document4', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','TextColor'] },
			{ name: 'document5', items : [ 'Bold','Italic','Underline'] },
			{ name: 'document6', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','Styles'] },
			{ name: 'document7', items : [ 'Format','Font','FontSize'] }
		];

	   config.toolbar = 'Introduction';
	   config.toolbar_Introduction =
		[
			{ name: 'document',  items : [ 'Save','Maximize','-','PasteFromWord','-','Undo','Redo','CreateDiv' ] },
			{ name: 'document1', items : [ 'Link','Unlink' ] },
                    { name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio','Smiley','PageBreak'] },
			{ name: 'document3', items : [ 'Table','HorizontalRule', 'SpecialChar','ShowBlocks'] },
			{ name: 'document4', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','TextColor'] },
			{ name: 'document5', items : [ 'Bold','Italic','Underline'] },
			{ name: 'document6', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','Styles'] },
			{ name: 'document7', items : [ 'Format','Font','FontSize'] },
			{ name: 'document8', items : [ 'Source'] }
		];

	   config.toolbar = 'Forum';
	   config.toolbar_Forum =
		[
			{ name: 'document',  items : [ 'Bold','Italic','Underline'] },
                        { name: 'document1', items : [ 'TextColor','BulletedList','NumberedList'] },
			{ name: 'document2', items : [ 'Copy','PasteFromWord','Link','Unlink'] },
			{ name: 'document3', items : [ 'Undo','Redo'] },
                        { name: 'document4', items : [ 'Image','MascotManager','MindmapsManager','Audio','VideoPlayer'] },
                        { name: 'document5', items : [ 'asciimath','Table','SpecialChar','Styles','Format','FontSize','Preview','Maximize'] }
		];

	   config.toolbar = 'ForumStudent';
	   config.toolbar_ForumStudent =
		[
			{ name: 'document',  items : [ 'Save','Maximize','-','PasteFromWord','-','Undo','Redo' ] },
			{ name: 'document1', items : [ 'Link','Unlink' ] },
			{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio','Smiley','PageBreak','Iframe'] },
			{ name: 'document3', items : [ 'Table','HorizontalRule', 'SpecialChar','ShowBlocks'] },
			{ name: 'document4', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','TextColor'] },
			{ name: 'document5', items : [ 'Bold','Italic','Underline'] },
			{ name: 'document6', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','Styles'] },
			{ name: 'document7', items : [ 'Format','Font','FontSize'] },
			{ name: 'document8', items : [ 'Source'] }
		];

	   config.toolbar = 'Profile';
	   config.toolbar_Profile =
			[
				{ name: 'document',  items : [ 'Undo','Redo'] },
				{ name: 'document1', items : [ 'Link','Unlink'] },
				{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio'] },
				{ name: 'document3', items : [ 'SpecialChar'] },
				{ name: 'document4', items : [ 'NumberedList','BulletedList','-','TextColor'] },
				{ name: 'document5', items : [ 'Font','FontSize'] },
				{ name: 'document6', items : [ 'Bold','Italic','Underline'] },
				{ name: 'document7', items : [ 'JustifyLeft','JustifyCenter','JustifyRight'] },
				{ name: 'document8', items : [ 'Source'] }
			];

	   config.toolbar = 'Messages';
	   config.toolbar_Messages =
			[
                                { name: 'document',  items : [ 'Bold','Italic','Underline'] },
                                { name: 'document1', items : [ 'TextColor','BulletedList','NumberedList'] },
                                { name: 'document2', items : [ 'Copy','PasteFromWord','Link','Smiley'] }
			];

	   config.toolbar = 'PortalNews';
	   config.toolbar_PortalNews =
			[
                                { name: 'document',  items : [ 'Bold','Italic','Underline'] },
                                { name: 'document1', items : [ 'TextColor','BulletedList','NumberedList'] },
                                { name: 'document2', items : [ 'Copy','PasteFromWord','Link','Smiley'] }
			];

	   config.toolbar = 'Catalogue';
	   config.toolbar_Catalogue =
			[
				{ name: 'document',  items : [ 'Undo','Redo'] },
				{ name: 'document1', items : [ 'Link','Unlink'] },
				{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio'] },
				{ name: 'document3', items : [ 'SpecialChar'] },
				{ name: 'document4', items : [ 'NumberedList','BulletedList','-','TextColor'] },
				{ name: 'document5', items : [ 'Font','FontSize'] },
				{ name: 'document6', items : [ 'Bold','Italic','Underline'] },
				{ name: 'document7', items : [ 'JustifyLeft','JustifyCenter','JustifyRight'] },
				{ name: 'document8', items : [ 'Source'] }
			];

	   config.toolbar = 'Quiz_Media';
	   config.toolbar_Quiz_Media =
		   [
			{ name: 'document',   items : ['PasteFromWord','Image','VideoPlayer','Audio','Source'] }
		   ];

	   config.toolbar = 'TestQuestionDescription';
	   config.toolbar_TestQuestionDescription =
		   [
			{ name: 'document',   items : ['FontSize','Font','PasteFromWord','Image','TextColor'] },
			{ name: 'document2',  items : ['Bold','Italic','Underline', ,'-','NumberedList','BulletedList','-','SpecialChar','JustifyLeft','JustifyCenter','JustifyRight'] },
		   ];

           config.toolbar = 'CertificateTemplates';
	   config.toolbar_CertificateTemplates =
		   [
			{ name: 'document',  items : ['FontSize','Font','CertificateTokens','CertificateBg','Image','TextColor'] },
			{ name: 'document2', items : ['Bold','Italic','Underline', '-','NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight'] },
                        { name: 'document3', items : ['Maximize','Source'] }
		   ];

	   config.toolbar = 'TestProposedFeedback';
	   config.toolbar_TestProposedFeedback =
		   [
			{ name: 'document',   items : ['Bold','Italic','Underline', '-','NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight'] },
			{ name: 'document1',   items : ['PasteFromWord','Image','TextColor','-','Source'] }
		   ];

	   config.toolbar = 'TestProposedAnswer';
	   config.toolbar_TestProposedAnswer =
		   [
                   	{ name: 'document',   items : ['Bold','Italic','Underline','JustifyLeft','JustifyCenter','JustifyRight','TextColor'] },
			{ name: 'document1',  items : ['NumberedList','BulletedList','Image','VideoPlayer','Audio','Source'] }
		   ];
           
	   config.toolbar = 'AdminTemplates';
	   config.toolbar_AdminTemplates =
		[
			{ name: 'document',  items : [ 'Save','Maximize','-','PasteFromWord','-','Undo','Redo' ] },
			{ name: 'document1', items : [ 'Link','Unlink' ] },
			{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio','Smiley','PageBreak','Iframe'] },
			{ name: 'document3', items : [ 'Table','HorizontalRule', 'SpecialChar','ShowBlocks'] },
			{ name: 'document4', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','TextColor'] },
			{ name: 'document5', items : [ 'Bold','Italic','Underline'] },
			{ name: 'document6', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','Styles'] },
			{ name: 'document7', items : [ 'Format','Font','FontSize'] },
			{ name: 'document8', items : [ 'Source'] }
		];

	   config.toolbar = 'PortalHomePage';
	   config.toolbar_PortalHomePage =
		[
			{ name: 'document',  items : [ 'Save','Maximize','-','PasteFromWord','-','Undo','Redo' ] },
			{ name: 'document1', items : [ 'Link','Unlink' ] },
			{ name: 'document2', items : [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio','Smiley','PageBreak','Iframe'] },
			{ name: 'document3', items : [ 'Table','HorizontalRule', 'SpecialChar','ShowBlocks'] },
			{ name: 'document4', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','TextColor'] },
			{ name: 'document5', items : [ 'Bold','Italic','Underline'] },
			{ name: 'document6', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','Styles'] },
			{ name: 'document7', items : [ 'Format','Font','FontSize'] },
			{ name: 'document8', items : [ 'Source'] }
		];
           config.toolbar = 'EmailTemplates';
	   config.toolbar_EmailTemplates =
		[
			{ name: 'document',  items : [ 'Bold','Italic','Underline'] },
                        { name: 'document1', items : [ 'TextColor','BulletedList','NumberedList'] },
			{ name: 'document2', items : [ 'Copy','PasteFromWord','Link','Smiley'] }
		];
                
           // This is the full tollbar for all buttons.
            config.toolbar = 'FullTollbar';
            config.toolbar_FullTollbar =
            [
                { name: 'document',  items :   [ 'Save','Undo','Redo','Maximize','-','PasteFromWord','-','Undo','Redo','CreateDiv' ] },
                { name: 'document1', items :   [ 'Link','Unlink' ] },
                { name: 'document2', items :   [ 'Image','MascotManager','MindmapsManager','VideoPlayer','Audio','Smiley','PageBreak'] },
                { name: 'document3', items :   [ 'Table','HorizontalRule', 'SpecialChar','ShowBlocks',] },
                { name: 'document4', items :   [ 'NumberedList','BulletedList','-','Outdent','Indent','TextColor'] },
                { name: 'document5', items :   [ 'Bold','Italic','Underline'] },
                { name: 'document6', items :   [ 'JustifyLeft','JustifyCenter','JustifyRight','Styles'] },
                { name: 'document7', items :   [ 'Format','Font','FontSize'] },
                { name: 'document8', items :   [ 'Source'] },
                { name: 'document9', items :   ['NewPage','Preview','Templates'] },
                { name: 'document10', items :  ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'] },
                { name: 'document11', items :  ['Find','Replace','SelectAll','RemoveFormat'] },
                { name: 'document12', items :  ['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'] },
                { name: 'document13', items :  ['Strike','-','Subscript','Superscript'] },
                { name: 'document14', items :  ['Blockquote','JustifyBlock','Anchor','BGColor', 'About'] }
 
            ];     
             
             
	};
