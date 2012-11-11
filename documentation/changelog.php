<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>


	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Dokeos 2.2 MOBILE - Changelog</title>
	
	<link rel="stylesheet" href="../main/css/dokeos2_tablet/default.css" type="text/css" media="screen,projection" />
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<script type="text/javascript" src="../main/inc/lib/javascript/jquery-1.4.2.min.js" language="javascript" />
	<script type="text/javascript" language="javascript">
		jQuery(document).ready( function($) {
			// Expand or collapse the help
			$('#help-link').click(function () {
				$('#help-content').slideToggle('fast', function() {
					if ( $(this).hasClass('help-open') ) {
						$('#help a').css({'backgroundImage':'url("../main/img/screen-options-right.gif")'});
						$(this).removeClass('contextual-help-open');
					} else {
						$('#help a').css({'backgroundImage':'url("../main/img/screen-options-right-up.gif")'});
						$(this).addClass('help-open');
					}
				});
				return false;
			});
		});
	</script></head><body>
	<div id="header">
		<div id="header1">
				<div class="headerinner">
					<div id="institution">Dokeos 2.2 MOBILE Changelog</div>
				</div>
		</div>
		<div id="header2">
			<div class="headerinner">
				<ul id="dokeostabs">
                                        <li class="install" id="current"><a href="../main/install/index.php">Installation</a></li>
                                        <li class="guide_na"> <span><a href="../../documentation/installation_guide.php" target="_blank">Installation guide</a></span></li>
				</ul>
				<div style="clear: both;" class="clear"> </div>
			</div>
		</div>

		<div id="header4">
			<div class="headerinner">
				<div id="help-content">
					<strong>General help</strong><br />
					<a href="../../documentation/installation_guide.html" target="_blank">read the installation guide (the document you are currently looking at)</a><br />
					<a href="http://dokeos.com/en/manual/installation" target="_blank">Read a more up to date installation manual on http://www.dokeos.com</a><br /><br />
				</div>
				<div id="help">
					<a href="#" style="" id="help-link">Help</a>
				</div>
			</div>
		</div>
	</div>

	<div id="main">
		<div class="actions">
			<a href="readme.html">About Dokeos</a> 
			<a href="installation_guide.html">Installation Guide</a>
			<a href="license.html">GPL license</a>
			<a href="credits.html">Credits</a>
			<a href="dependencies.html">Dependencies</a>
			<a href="changelog.html">Changelog</a>
			<a href="http://www.dokeos.com">Website</a>	
		</div>

		<div id="content">

			
<h1>Dokeos 2.2 MOBILE - June 2012<br />
</h1>
Dokeos 2.2 MOBILE is a HTML5-focussed release to fit with new demand of
versatile project working indifferently on Computer, Laptop, Windows,
Mac, Linux, Any Browser and Tablets (iPad and Android).<br />
 
<h3>Innovations</h3>

			
<ul>
<li>New design : Black Tablet style</li>
  <li>New avatars : illustrate lessons with Mister Dokeos character</li>
  <li>CK Editor replaces FCK Editor (still in BETA phase)</li>
  <li>Microsoft Explorer 6 backwards compliance efforts for big companies still using Explorer 6 <br />
  </li>
  <li>Authoring engine refactored : quicker and more reliable</li>
  <li>Quiz tool : improved question categories, new templates, new behaviour for drag and drop questions</li>
  <li>Quiz tool : Scenario interface clearer</li>
  <li>Surveys : improved XLS export</li>
  <li>Portal home design : improved aesthetics no snapshot anymore, drawing only</li>
  <li>Multilanguage management : imroved translation tool and Menu to select default language</li>
  <li>Social network : easier to add "friends" thanks to better notification system</li>
  <li>E-commerce feature now complete (see Admin interface) and accepting Paypal, Atos and Cheque payment</li>
  <li>Catalogue more flexible: you can sell programmes, but also sessions and courses</li>
  <li>Webex videoconferencing integrated (plugin)</li>
  <li>Wiki : adding a wiki link has never been, easier</li>
  <li>Groups : new scenario tool to allow collaboration / competition / tutoring</li>
  <li>Assignments : better scoring and global remarks display</li>
  <li>Course copy : now accepts courses bigger than 500 Mb</li>
  <li>Notes : simplified</li>
  <li>Glossary : automatic highlight of definitions improved</li>
  <li>Automatic emails : added automatic emails to quiz feedback</li>
  <li>HTML 5 : replaced Flash-based audio player with HTML5 based audio player</li>
  <li>HTML5 : example videos are now MP4 instead of FLV</li>
</ul>

			
<h3>Bug fixes</h3>

			
<ul>
<li>Accents in document names fixed</li>
  <li>Centered label for portal home slider</li>
  <li>Scorm player : reporting fixes for Articulate content</li>
  <li>Scorm player : reporting fixes for Interaction SCORM events</li>
  <li>Scorm player : Javascript fixes to avoid reporting errors</li>
  <li>Scorm player : improved display to optimize space</li>
  <li>Scorm player : improved export of modules authored with Dokeos Author</li>
  <li>Mindmaps : broken link to Dokeos Mind fixed</li>
  <li>Blogs : improved overall ergonmics<br />
  </li>
</ul>
<h1>Dokeos 2.1 TABLET- September 2011<br />
</h1>Dokeos 2.1 TABLET is a tablet-pc compliance release (iPads,
Android tablets...) and bugfixing release with a strong focus on
HTML5&nbsp; and code improvement <h3>Innovations</h3>
			<ul>
				<li>New TABLET CSS style</li>
  <li>Replaced Flash based video player with FW player, compliant with MP4 videos running in a HTML5</li>
  <li>One unique scenario to simplify quiz building</li>
  <li>New player for SCORM course modules with improved reporting and a new ergonomic design</li>
  <li>Slider on portal home to add dynamic information, advertisement, latest news, programme description</li>
  <li>Catalogue feature to complete Sessions management. Now possible
to build a whole training programme with topics, training product
description, groups registration</li>
  <li>Drag and drop quizzes now working in tablets</li>
  <li>Integration with Google Calendar</li>
  <li>Improved audio recorder on top of slides</li>
  <li>Overall speed improvement : pages load faster thanks to HTML5 code refactoring</li>
  <li>Better compliance with Internet Explorer 7, 8 and 9</li>
  <li>Improved administration pannel : less options, clearer navigation in an administration block</li>
  <li>Social network : now possible to invite people in a simple and
notified way. Possible to find contacts to send internal messages
individually or collectively<br />
  </li>
  <li>Two new widgets: 'Tabbed RSS' that allows you to add multiple RSS
feeds in one tab and thus saving space. 'Wiki' widget that allows you
to add one or multiple wiki pages as a widget</li>

			</ul>
			<h3>Bug fixes</h3>
			<ul>
				<li>Quiz display improved</li>
  <li>Drag and drop quizzes now working in all browsers</li>
  <li>Scoring bugs fixed</li>
  <li>SCORM reporting : now providing a coherent scoring calculation for Captivate and ENI Editions modules</li>
  <li>Alphabetical sorting of lists (Users, Courses...) fixed<br />
  </li>
  <li>Changing the properties of a widget outside a training is now again possible</li>

				<li>Performance improvement on the 'my trainings' page</li>
				<li>Cleanup of documentation</li>
				<li>Bugfix:
If in a widgetised portal and training homepage the same widgets are
activated and on the portal the widget is given a deviant title then
this title was also passed to the training widget if the default title
was used</li>
			</ul>


			<h1>Dokeos 2.0 Release - March 2011</h1>
Dokeos 2.0 brings the web 2.0 experience to your elearning and
collaboration platform with a true social platform and a lot of drag
and drop interactions. Dokeos 2.0 is a major release offering a
complete revolution as compared to Dokeos 1.8. We experienced that
teachers, trainers, students and trainees tend to use only a few
features in classical learning management systems. For two reasons: <ol>
				<li> Learning management systems remain complex and far
from the kind of software usability you find on a telephone, an Apple
or Ubuntu-based computer;</li>
				<li>The rich variety of pedagogical
scenarios (social networking, clinical case studies, serious games...)
is hampered by software complexity.</li>
			</ol> Dokeos solves these
two problems by offering a easy to use elearning platform that offers
scenarios and templates where needed. <br />
Dokeos 2.0 does not focus on adding new and trendy features nor does it
follows the hype of adding features that are only usefull to a limited
set of very highly skilled and experienced users and simply because
adding these features is possible. Instead we focus on the common user
and good and solid elearning solutions. We want to give the user
control over the content and allow her/him to create the elearning
training that (s)he has in mind with as little effort as needed and ans
quickly and easy as possible. <h3>Innovations</h3>
			<ul>
				<li>AGENDA, Now visual and drag &amp; drop, like Google Agenda</li>
				<li>AUTHOR, Create courses online</li>
				<li>CATALOG, Displays a nice list of courses to register, with an access to the course description</li>
				<li>CASE STUDIES, design real-life situations and problem based learning</li>
				<li>CMS, Edit portal homepage and news and rely on templates to build information easily</li>
				<li>DIGITAL LIBRARY, A full-text visual search that generates thumbnails of resources</li>
				<li>DOCUMENT TEMPLATES, Ease productivity with 30 content templates based on visual metaphors for the explanation</li>
				<li>DRAG&amp; DROP MATCHING, Experience touchscreen quizzes for an intuitive gathering of information</li>
				<li>ERGONOMICS, interface simplified</li>
				<li>GLOSSARY, Now visual, ergonomic and displays definitions in content : Documents, Quizzes, Wiki</li>
				<li>GRAPHICAL DESIGN, new design with Oxygen Icons and a display imagined by Fran�oise Desmartin</li>
				<li>GRADEBOOK, Generate reports on a&nbsp; blended learning scenario including face-to-face exams and presence sheets</li>
				<li>FIX WIDTH INTERFACE, designed for a 1024 pixels screen, improved ergonomics</li>
				<li>MEDIABOX, a simple-to-use interface to exchange data and media with your mobile</li>
				<li>MINDMAPS, Create diagrams, import them into Dokeos and use them as a navigation support, an explanation tool</li>
				<li>MOBILE COMPLIANCE, Dokeos 2.0 works in iPads, Android smartphones, most mobile devices</li>
				<li>NOTEBOOK, Students can save information when attending a face-to-face course</li>
				<li>QUIZBUILDER, rely on templates to create sophisticated quizzes rapidly and efficiently</li>
				<li>REPORTING, Now graphical with a synthetic view on progress, groups, time etc.</li>
				<li>SCENARIO, structure course material along a pedagogical strategy</li>
				<li>SERIOUS GAME, Import serious games and play them online with reporting</li>
				<li>SECURITY, Configure passwords requirements like "change password at first login"</li>
				<li>SOCIAL NETWORK, allow students collaborate informally</li>
				<li>SURVEYS, Now easy to use with nice cross-reporting</li>
				<li>THIRD PART CONTENT, Improved display of courses built in other authoring tools. Dokeos is more transparent</li>
				<li>TOUCHSCREEN-READY, move information with your fingertips on a touchscreen display, thanks to Ajax drag &amp; drop</li>
				<li>VIDEO INTEGRATION, Import Flash video, MPG</li>
				<li>VISUAL INTERFACE, Less words, less buttons, a smartphone-oriented interface</li>
				<li>WEB 2.0 TECHNOLOGY, Podcasts, Wiki, Blogs, YouTube, Facebook-like social network, RSS feeds</li>
			</ul>

	
			<h1>Dokeos 1.8.6.2 - February 2011</h1>
	
			<h3>Innovations</h3> 
			<ul>
			  <li>Implemented by-session content creation tools updates</li>
			  <li>Added tabs editor (from admin)</li>
			  <li>Added courses catalog</li>
			  <li>Added a link to export course in the (platform administrator -&gt; course list) (DT#4257)</li> 
			  <li>Added sessions history (optional access to previous sessions in read-only for students)</li>
			  <li>Added advanced search  in sessions: you can also search by session name, session category, tutor and visibility. (DT#5541)</li>
			  <li>Added
an option to configure courses as "auto-registered" (every user has it
in his courses list and is automatically subscribed)</li>
			  <li>Added chat tool to the groups(DT#3318)</li>
			  <li>Allowed password to be recovered using username *or* e-mail</li>
			  <li>Added editable section to the registration form</li>
			  <li>Reporting: notification of user who have never been active yet</li>
			  <li>Reporting:
the additional user profiles (defined by the platform administrator
through platform administration &gt; profiling) can now be displayed
also. </li>
			  <li>Subscribing users in a course: you can also
filter on a certain addtional user profile field or search inside the
values of the additional user profiles fields when subscribing a user
in a course (through user/subscribe_user.php) </li>
			  <li>Added Send a email to a portal administrator upon course creation (DT#3489)</li>
			  <li>Added Chat tool is now private when are in sessions or groups (DT#5558)</li>
			  <li>Wiki:
Posibility to definition of wiki pages as tasks for students. Add
feedback to student wiki pages, sincronized with their progress in the
task. Posibility to establish a time limit for each wiki page.
Posibility to establish a max number of words into each wiki page.
Posibility to establish a max number versions for each page. Improve
control of concurrent users. Improvements in the use of wiki pages such
as portfolios of student (individual task)</li>
			  <li>Added when a
user is enrolled only in one course, go directly to the course after
the login (defined by the platform administrator through platform
administration &gt; configuration setting &gt; training)- DT#3466</li>
			  <li>Added user' photo into user list interface - DT#5496</li>
			  <li>Disabled
field trainers(tutor name) in create course form from user portal, by
default is current user's name, you can modify this field into setting
course - DT#5496 </li>
			  <li>Added option to export the trainings list to CSV file in Administration&gt;Trainings - DT#4256</li>
			  <li>Gradebook automatic deleted bug of a link fixed DT#5229</li>
			  <li>User tags added DT#5508</li>
			  <li>Who is online look revamped DT#5490</li>
			  <li>New search tool added DT#5610 </li>	
			  <li>User groups added  DT#5611 </li>  
			  <li>Social network tab added</li>
			  <li>Easy construction of presentations with the images of document tool</li>
			  <li>Performance improvement when getting a list of users (for instance in the dropbox when sending a new document)</li>
			  <li>Platform setting (in User category) that determines how the users should be sorted: by first name or by last name</li>
			</ul>
			<h3>Bug fixes</h3>
			<ul>
			  <li>Online editor: A upgrade from FCKEditor 2.6.4.1 to <strong>FCKEditor 2.6.5, Build 23959</strong> has been implemented. (#2867)</li>
			  <li>Fixed a bug in course homepage always showing a box even when no tools were shown (r8747:3ad59f6aed1f)</li>
			  <li>Score result in reporting is expressed as a percentage</li>
			  <li>CSV export of reporting no longer contains html code in the last column</li>
			  <li>The course list is now sorted like you have defined on the course management page</li>
			</ul>
	
			<h3>CSS changes</h3>
			<ul>
			  <li>No major change, no old styles update required</li>
			</ul>
			<h3>Known issues</h3>
			<ul>
			  <li>In Hotspot under Windows� (server-side), uploading a PNG file results in an unstable exercise</li>
			</ul>
			<h3>Deprecated files</h3>
			<ul>
				<li>No important file removed, no change required</li>
			</ul>



	<h1>Dokeos 1.8.6.1 - August 2009</h1>
	<h3>Release notes - summary</h3>
	<p>Dokeos
1.8.6.1 is a minor&nbsp;release including just a few new features,
mostly focused on internationalization, and several bugfixes.</p>
	<h3>New Features</h3>
	<ul>
	  <li>Implemented new sub-language feature by which language terms redefinition becomes possible through the admin section (FS#4321)</li>
	  <li>Admin: Terms and conditions added DT#4320</li>
	  <li>Improvements in document tool, allow seeing glossary terms (FS#4337)</li>
	  <li>Small improvements in SCORM export(FS#4300)</li>
	  <li>At the beginning of the installation script, added an imperative check for PHP 5 has been added. (FS#4296)</li>
	  <li>When
the system Dokeos is switched into "Test server" mode, a clickable
indicator appears in the footer. This indicator is visible by platform
administrators only. (FS#4341)</li>
	  <li>A transliteration function
has been added. Currently, it is used in uploading files. Files with
non-English names get names that contain ASCII letters only, remaining
readable in the corresponding language. Rationale: The PHP5 run-time
environment does not manage file name encodings, adding such a
non-native feature involves too much work. For avoiding character
encoding problems, transliteration of file names is the possible
solution. (FS#306)</li>
	  <li>An internationalization option has been added for improving sorting in arbitrary language. When the <a href="http://php.net/manual/en/book.intl.php" target="_blank">intl</a>
php-extension has been installed, various sorting routines exploit it
for better sorting. Rationale: The PHP5 run-time environment does not
provide native and reliable way of sorting UTF-8 strings. (FS#306)</li>
	  <li>Installation
script: The page about system requilements has been updated. Also, at
the very beginning, a check has been added whether the <a href="http://php.net/manual/en/book.mbstring.php" target="_blank">mbstring</a> php-extension is installed - see <a href="http://dokeos.com/forum/viewtopic.php?t=29548" target="_blank">the related forum topic</a>. (FS#306)</li>
	  <li>A new php-based configuration for the online editor has been implemented, see <i>dokeos/main/inc/lib/fckeditor/myconfig.php</i>. Also, toolbar definitions have been split in separate php-files within the directory <i>dokeos/main/inc/lib/fckeditor/toolbars/</i> . Customization of the editor is more convenient and flexible now. (FS#2867)</li>
	  <li>Online editor: A upgrade from FCKEditor 2.6.4 to <strong>FCKEditor 2.6.4.1</strong> has been implemented. (FS#4383)</li>
	  <li>Online
editor: Blocking copy/paste for trainees has been added. The feature is
configurable through editing the toolbar definition files within the
directory <i>dokeos/main/inc/lib/fckeditor/toolbars/</i> . (FS#2867)</li>
	  <li>Online editor: Preview tabs have been added to the dialogs for inserting video, flv-video, and YouTube video. (FS#2867)</li>
	  <li>Online editor: The <strong>audio</strong>
plugin has been activated by default as an implementation of the
"Insert audio / Audio properties" dialog. This new plugin is intended
to replace the "MP3" plugin. (FS#2867)</li>
	  <li>Online editor: The
simple file manager, the advanced file manager and the image manager
have been integrated by default with the editor's dialog system. Thus,
they work faster and in a more secure way. (FS#2867)</li>
	  <li>Online editor: Configuration of the <strong>mimetex</strong> plugin has been reworked to gain simplicity. The procedure for configuration has been updated, see <a href="http://www.dokeos.com/forum/viewtopic.php?t=29594" target="_blank">the related forum topic</a>. (FS#2867)</li>
	  <li>Online editor: A new <strong>asciimath</strong> plugin for inserting mathematical formulas has been added. It is based on the <a href="http://mathcs.chapman.edu/%7Ejipsen/mathml/asciimath.html" target="_blank">ASCIIMathML.js</a> library. (FS#2867)</li>
	  <li>Social:
Added possibility to define RSS feeds inside personal page of social
network (need to define an 'rssfeeds' extra user text field)</li>
	</ul>
	<h3>Bug fixes</h3>
	<ul>
	  <li>Online editor: Several known bug-fixes from FCKEditor 2.6.5 SVN have been implemented, tickets <a href="http://dev.fckeditor.net/ticket/1537" target="_blank">#1537</a>, <a href="http://dev.fckeditor.net/ticket/2156" target="_blank">#2156</a>, <a href="http://dev.fckeditor.net/ticket/2689" target="_blank">#2689</a>, <a href="http://dev.fckeditor.net/ticket/2821" target="_blank">#2821</a>, <a href="http://dev.fckeditor.net/ticket/2856" target="_blank">#2856</a>, <a href="http://dev.fckeditor.net/ticket/2874" target="_blank">#2874</a>, <a href="http://dev.fckeditor.net/ticket/2915" target="_blank">#2915</a>, <a href="http://dev.fckeditor.net/ticket/3120" target="_blank">#3120</a>, <a href="http://dev.fckeditor.net/ticket/3181" target="_blank">#3181</a>, <a href="http://dev.fckeditor.net/ticket/3427" target="_blank">#3427</a>, <a href="http://dev.fckeditor.net/ticket/3429" target="_blank">#3429</a>, <a href="http://dev.fckeditor.net/ticket/3439" target="_blank">#3439</a>, <a href="http://dev.fckeditor.net/ticket/3446" target="_blank">#3446</a>, <a href="http://dev.fckeditor.net/ticket/3481" target="_blank">#3481</a>, <a href="http://dev.fckeditor.net/ticket/3677" target="_blank">#3677</a>, <a href="http://dev.fckeditor.net/ticket/3818" target="_blank">#3818</a>, <a href="http://dev.fckeditor.net/ticket/3880" target="_blank">#3880</a>, <a href="http://dev.fckeditor.net/ticket/3925" target="_blank">#3925</a>. (FS#2867)</li>
	  <li>Online editor: The toolbar icons have been upgraded to those from FCKEditor 3.0. (FS#2867)</li>
	  <li>A solution has been implemented for fixing the <a href="http://bugs.adobe.com/jira/browse/FP-529" target="_blank">"__flash__removeCallback" bug</a>, which affects the media player on Internet Explorer browser. (FS#4378 and FS#2867)</li>
	  <li>Quiz: fixed bug in multiple-choice/single-answer questions results (whereby the wrong answer was saved)</li>
	  <li>Admin: Added courses from sessions inside AJAX popup of courses list in users list (SVN#22398)</li>
	  <li>Admin: Showing full-length course titles in list of courses while adding to sessions(SVN#22399)</li>
	  <li>Admin: Added session name in title of session edition pages(SVN#22400)</li>
	</ul>
	<br />
	<h3>CSS changes</h3>
	<ul>
	  <li>Sticky footer now available in all Dokeos stylesheets. If you own a custom stylesheet you will need to update it, see <a href="https://bts.dokeos.com/issues/show/3549">DT#3549</a> for further details.</li>
	</ul>

	<br />
	<h3>Known issues</h3>
	<br />
	<h3>Deprecated files</h3>
	<ul>
	  <li>The whole main/inc/lib/fckeditor/editor/filemanager/browser/default/connectors/ directory should be removed for security reasons</li>
	</ul>
	<br />
	<h1>Dokeos 1.8.6 <span style="font-style: italic;">Svalbard</span> - June 2009</h1>
	<h3>Release notes - summary</h3>
	<p>Dokeos 1.8.6 Svalbard is a major&nbsp;release including new features.&nbsp;</p>
	<h3>New Features</h3>
	<ul>
	  <li>FCKEditor 2.6.4, build 21629 added (FS#2528 and FS#2867)</li>
	  <li>Improvements to the profiling tool (previously called "User fields") to improve presentation and flexibility, and allow edition</li>
	  <li>Added new authorized charsets for learning path tool</li>
	  <li>Official code available in My Reporting (FS#2640)</li>
	  <li>Added possibility to switch fill-in-the-blanks answers (FS#2683)</li>
	  <li>Now hiding database password field with *** in install/upgrade procedure (FS#2680)</li>
	  <li>Added attempts limit to tests</li>
	  <li>Hide language form if only one language available</li>
	  <li>Added possibility for the course teacher and tutor to delete quiz attempts by users</li>
	  <li>Added possibility for session coaches to register external users directly to their session (FS#2700)</li>
	  <li>Added possibility to allow coach to access a defined number of days before and after a session (FS#2724)</li>
	  <li>Activates unique (ajax) and multiple (multiple select) inscriptions for courses and users in sessions (FS#2719)</li>
	  <li>Handling of sessions in tools has been improved : for example we can't see anymore an annoucment of another session (FS#2743)</li>
	  <li>Tests
: In students results page, set the question comment in red when the
student's answer is wrong. Set in green when the answer id good</li>
	  <li>New audio recorder in learning path</li>
	  <li>New mp3 player (FS#2977)</li>
	  <li>New Glossary tool (FS#3248)</li>
	  <li>Integrated the gradebook at course level (FS#3173)</li>
	  <li>New wiki tool (considerably improved, built on CoolWiki plugin) (FS#2873)</li>
	  <li>Remove possibility to delete system directories in documents tool (FS#1522)</li>
	  <li>Database
server: no more need for special SQL modes for MySQL 5.0 to be turned
off through the "sql_mode" setting. The Dokeos system does it
internally (FS#2787)</li>
	  <li>Some low-level functions that intensively use the language translation sub-system have been optimized for speed (FS#3260)</li>
	  <li>Documents tool: The document-type icons have been made clickable (FS#3296)</li>
	  <li>Documents tool: Online editor has been disabled for HotPotatoes tests in order their functionality to be preserved (FS#3345)</li>
	  <li>Allow ZIP export of assignments for teacher and tutor </li>
	  <li>Added attach documents to Agenda</li>
	  <li>Added Web Services Interface (SOAP)</li>
	  <li>Added Google Maps support</li>
	  <li>Added Imagemap editor</li>
	  <li>Online editor: Inserting links to YouTube streaming service has been added (FS#2867)</li>
	  <li>Improved
chat (open in new window option, smileys, teacher/learner difference
and time indication for each message, user picture showing directly,
possibility to hold several conversations in several courses at the
same time)</li>
	  <li>Option to hide/show e-mail addresses to all users (FS#3244)</li>
	  <li>Added an introduction section for each group area (FS#3200)</li>
	  <li>New Global Agenda (FS#3391)</li>
	  <li>New Notebook tool in courses</li>
	  <li>Added reporting on the last connections of a user in the chat</li>
	  <li>Added link create course message to go directly to the course(SVN#17497)</li>
	  <li>Added ability to take partial surveys and finish them later (FS#2510)</li>
	  <li>New Survey Feature: Surveys without invitation mail (FS#3403)</li>
	  <li>Added Booking system (a.k.a Reservation 2 Extension) (FS#821)</li>
	  <li>Added user profiling fields in auto-registration page (FS#2666)</li>
	  <li>Added check for writeable status of session save path in installation directory (FS#2970)</li>
	  <li>Allow forum threads to be moved (FS#3460)</li>
	  <li>Minor - Added update information for quizzes (FS#3417)</li>
	  <li>Sending e-mails to all admin on user account creation confirmation (FS#3475)</li>
	  <li>Changed user profile setting defaults to make phone field disabled and picture enabled (FS#3474)</li>
	  <li>Added intermediary buttons in platform settings pages to avoid scrolling too much to apply atomic changes (FS#3473)</li>
	  <li>Simplify default platform language choice by adding quick icon (FS#3472)</li>
	  <li>Session admins can now add users to the portal (FS#3476)</li>
	  <li>Added Advanced File Manager (FCKEditor plugin) to improve flexibility in files upload (FS#2970)</li>
	  <li>Added New Message Tool (a.k.a Message 2 Plugin) (FS#3503)</li>
	  <li>Added Question difficulty level in Exercises (FS#3515)</li>
	  <li>Added Removed buggy audio recorder and added new MP3 player with easy upload (FS#3515)</li>
	  <li>Improved Survey export (SVN#17927)</li>
	  <li>Students can now view their uploaded works in Work tool (FS#3486)</li>
	  <li>Implemented
	add to calendar an assignment with the date when it is completely
	closed, also when you remove it from assignment tool, it's removed into
	calendar too, the same case when it's edited, for that I had to change
	the value of add_calendar field into student_publication_assignment
	table, now when it's sent to calendar this value is the id into
	calendar_event table, instead this value is 0.</li>
	  <li>Added Social tool + friend list (FS#3383)</li>
	  <li>Added introduction section to blog and course description (FS#3165)</li>
	  <li>Added import/export (CSV/XML) of extra user fields</li>
	  <li>Added ability to import users in XML and subscribe to visual code (FS#3552)</li>
	  <li>Added pChart v1.1.2 library to manage charts in Gradebook tool(FS#3718) and the Access details of a user </li>
	  <li>Added SHA1 as a possibility to encrypt user passwords (FS#3798)</li>
	  <li>Added global templates to use between courses (SVN#18955)</li>
	  <li>Added To change your password, you must enter your current password (SVN#19225)</li>
	  <li>Added New Dokeos stylesheets </li>
	  <li>Improvements to the User profile</li>
	  <li>Improvements to the Learning path display view (no more frames)</li>
	  <li>Added HTML Purifier</li>
	  <li>Added tracking/logging of admin activity FS#842</li>
	</ul>
	<br />
	<h3>Bug fixes</h3>
	<ul>
	  <li>Improved security in exercises module</li>
	  <li>Fixed issue in dropbox documents zipping feature - see <a href="http://www.dokeos.com/forum/viewtopic.php?t=13345">related forum post</a></li>
	  <li>Increased size of php_session data field to allow for reasonable-sized session to be kept in the database (FS#2657)</li>
	  <li>Fixed a few issues in mailing and codes for survey tool (FS#2662)</li>
	  <li>Considerably improved migration of SCORM learning paths from Dokeos 1.6.x to 1.8.x</li>
	  <li>Added student-view link for platform admin</li>
	  <li>Fixed bug about last access reporting in dropbox tool (FS#2458)</li>
	  <li>Saving survey invitation's mail subject (FS#2662)</li>
	  <li>Various improvements in clone cleanliness - avoiding many notice-level error reports</li>
	  <li>Fixed user picture problems in admin pages</li>
	  <li>Mysql error fixed in Reporting in a single DB installation (FS#2638)</li>
	  <li>Fixed phone number field missing during registration (FS#2639)</li>
	  <li>Fixed breadcrumb in portal administration (FS#2642)</li>
	  <li>Fixed issues in FCKeditor edition of documents with video, flash and mp3 included (FS#2679)</li>
	  <li>Fixed security issue affecting Windows servers with system file inclusion on homepage (FS#2692)</li>
	  <li>Fixed one-question-per-page view in Quiz tool (FS#2678)</li>
	  <li>Removed possible risk of having a database code too large for the course.db_name field (FS#2426)</li>
	  <li>Added missing online help for blogs (FS#811)</li>
	  <li>Fixed bug showing whole article as link in blog (FS#811)</li>
	  <li>Fixed bug whereby the course permissions were not updated when using the multiple-action mode in course users list</li>
	  <li>Fixed bug preventing opening of a learning path item following a failed prerequisite condition (SVN#15853)</li>
	  <li>Fixed bug preventing the activation of plugins (FS#2771)</li>
	  <li>Fixed bug adding double comments in dropbox tool in IE only (FS#2757)</li>
	  <li>Fixed IMS/QTI2 little export problem (FS#2634)</li>
	  <li>The learners can't send files anymore to other learners if "Do not allow
	students to send documents to other students within a course" is false
	(FS#2780)</li>
	  <li>The mails sent in exercises tool are sent from the address defined in admin (FS#2712)</li>
	  <li>"Next" and "Previous" page now works when searching a session (FS#2721)</li>
	  <li>Fixed bug when launching a quiz with one question per page (FS#2738)</li>
	  <li>Fixed javascript bug with swap menu in ie6 (FS#2815)</li>
	  <li>Fixed bug in surveys when we want to display answers of an invited person (FS#2731)</li>
	  <li>Fixed
	bug when copying a course with surveys. There is now a check for
	existing surveys with the same code and language (FS#2734)</li>
	  <li>Fixed bug when seeing matching results in quiz tool (SVN#15987)</li>
	  <li>Added filtering of SCORM objectives when writing to DB (SVN#16437)</li>
	  <li>Removed duplication of database write operations for SCORM objectives (SVN#16438)</li>
	  <li>Fixed HTTP_REFERER bug in ical_export (FS#3041)</li>
	  <li>Fixed bug in SQL queries for new installs, preventing the creation of the course_module table (FS#3040)</li>
	  <li>Fixed
	the fact that the password was never sent by e-mail when encrypted,
	even when it had just been changed for a user, causing a useless e-mail
	to be sent (SVN#16673)</li>
	  <li>Fixed bug in users pictures display when using the tuning setting of splitting users dirs (SVN#16673)</li>
	  <li>Fixed bug in documents picture gallery preventing uppercase image extensions to be seen (SVN#16755)</li>
	  <li>Fixed bug whereby the repeated agenda items in groups were visible to all (FS#3095)</li>
	  <li>Fixed bug whereby e-mails sent did not have the standard syntax (SVN#16708)</li>
	  <li>Fixed bug whereby an empty institution name gave a useless output in the header (SVN#16710)</li>
	  <li>Fixed bug whereby questions ordering was broken when deleting one question in the middle (SVN#16879)</li>
	  <li>Fixed
	bug in user fields, not displayed the default value in profile and add
	user, and you could modify this values(see FS#3307) </li><li>Fixed bug in link (see FS#3306)</li>
	  <li>Improved display of human resource manager option (see FS#3304)</li>
	  <li>Documents tool, folder selector: Fixed a bug that prevented Home (root) folder to be shown (FS#3089)</li>
	  <li>Users tool: Fixed a bug preventing detailed information about a user to be shown or edited (FS#3009)</li>
	  <li>Fixed a bug causing various problems due to improper priority order of loading PEAR packages (FS#3237)</li>
	  <li>The
	PclZip library has been upgraded to version 2.6. Additionally, a known
	bug has been fixed - improper processing of the option
	PCLZIP_OPT_REMOVE_PATH on Windows (FS#3243)</li>
	  <li>Fixed a bug causing improper numeric sorting of data displayed in various tables (FS#3282)</li>
	  <li>Agenda tool: Fixed a wrong range for hour selection. The bug has been reported and solved in a forum by TL (FS#3324)</li>
	  <li>Agenda tool: style changes - Align drop-down lists in date and time when you add a new calendar event and modify it</li>
	  <li>Fixed Date Validation  when you add a new exercises and modify it (FS#3249)</li>
	  <li>Tests tool: Fixed broken filter on orphan questions in questions pool, reported and solved in the forums by mark111 (FS#3329)</li>
	  <li>Fixed security flaw allowing anonymous user to enter "open to the platform" courses (FS#3359 - SVN#17499)</li>
	  <li>Fixed forum visibility bug for private groups forum (FS#3327)</li>
	  <li>Fixed many links bugs when using a forum inside a learning path (FS#3256)</li>
	  <li>Fixed: dropbox changed notification icon appears while dropbox inaccessable (FS#3395)</li>
	  <li>Fixed: access to a hidden document was possible (FS#2835)</li>
	  <li>Dropbox fix: move multiple selected files to category feature is back. (FS#3005)</li>
	  <li>Fixed: Long lines in Announcements did not show up in email (FS#2988)</li>
	  <li>Fixed: the productions users aren't saved in the the correct directory (FS#3456)</li>
	  <li>Fixed error in install/htaccess.dist whereby the url-append was not set correctly (SVN#17791)</li>
	  <li>Fixed missing check on cDir in local.inc.php (SVN#17793)</li>
	  <li>Removed possibility to create sub-directories in the dropbox tool - wasn't working anyway for various versions (FS#3434)</li>
	  <li>Improved access control for group tool (FS#3209)</li>
	  <li>Fixed profiling date field popup bug (FS#2985)</li>
	  <li>Added check on max members in group before subscribing new people (FS#3453)</li>
	  <li>Changed usage of mail functions to use api_mail() everywhere and fix mail headers problems (FS#2445)</li>
	  <li>Fixed bug changing the language to false in platform settings (FS#3472)</li>
	  <li>Fixed various HTTPS + IE related bugs, related to caching in general (SVN#17795)</li>
	  <li>Fixed 31 bugs in file/image/sounds/flash uploads/delete/permissions in profile/homepage/agenda edition pages</li>
	  <li>Fixed a bug in migration for several versions at once whereby new course tools were repeated several times (SVN#17935)</li>
	  <li>Fixed security issue allowing users to upload php files on the server through FCKEditor (FS#2970)</li>
	  <li>Fixed folders by default into document tool must not be removed - see FS#3611</li>
	  <li>Fixed qualification of themes into forum tool - see FS#3609</li>
	  <li>allow show results with floating point,in exercice tool - (partial FS#3630) - SVN#18367</li>
	  <li>Fixed event into agenda when it's sent from assignment and Improved display form when you create an assignment - see FS#3583</li>
	  <li>Fixed difficulty of the question lost - see FS#3659</li>
	  <li>Fixed XML user import for single courses import (related to FS#3552)</li>
	  <li>Fixed bug with user image not showing in upgrade from previous versions</li>
	  <li>Fixed bugs causing wrong attempts to translate some icons on course homepage when the server is in testing mode (FS#3285)</li>
	  <li>A
	fix for the Oogie converter to work on Windows OS has been applied.
	Initial code has been proposed in the Dokeos forums by �yvind Johansen
	(oyvind) and wilbrod - see FS#3969</li>
	  <li>Fixed Windows-related
	bugs preventing creation of SCORM packages from presentations, see
	FS#3972. The problem has been reported in the Dokeos forums by
	irvienhooi</li>
	  <li>Some minor bugs have been fixed in "Document Metadata" form (FS#4030)</li>
	  <li>Fixed a bug preventing updating dates of group documents after edition. Many thanks to Ludwig Theunis, nickname: TL (FS#4072)</li>
	</ul>
	<br />
	<h3>CSS changes</h3>
	<ul>
	  <li>Added classes glossary-term, glossary-term-title, glossary-term-desc, glossary-term-action-links for the glossary tool</li>
	  <li>Added personal-notes tool-related styles</li>
	  <li>Changed many things in the public-admin style (Dokeos default) to improve
	design - will probably affect other styles a little despite efforts not to</li>
	  <li>Added new styles</li>

	</ul>
	<br />
	<h3>Important language changes</h3>
	<ul>
	  <li>Changed "courses" to "trainings" in English and "Cours" to
	"Formations" in French. This change is likely to be very confusing to
	most users! Please either update your language files or warn your users
	if you are willing to keep that change.</li>
	  <li>Changed "Learning Path" link to "Course" in English and French</li>
	  <li>Changed and unified work/assignment/student publications tool as "assignments"</li>
	  <li>Changed "Dropbox" tool to "Documents sharing" (or "Documents sharing space" when referring to one's own space in the tool)</li>
	  <li>Changed "Student View" link to "Teacher view" and vice-versa</li>
	  <li>Many buttons now have more defined action names</li>
	</ul>
	<br />
	<h3>Known issues</h3>
	<ul>
	  <li>Inserting the same exercise twice in one learning path may generate score inconsistencies</li>
	</ul>
	<br />
	<h3>Deprecated files</h3>
	<ul>
	  <li>The whole main/inc/lib/xajax/tests/ should be removed</li>
	</ul>
	<br />
	<h1>Dokeos 1.8.5 <span style="font-style: italic;">Valparaiso</span>, June 2008</h1>
	<h3>Release notes - summary</h3>
	<p>Dokeos 1.8.5 is a major bug fixing release but includes interesting new features as well.&nbsp;</p>
	<h3>New Features</h3>

	<ul>
		<li>Considerable security improvements - 2 major and 1 minor security patches have been applied since the latest stable version</li>
		<li>SCORM
	export improvement (now generates SCORM 1.2 compliant packages and
	transforms Dokeos quizzes into SCO items, using interactions as a bonus)</li>
		<li>Possibility to filter extension of submitted files all around Dokeos</li>
		<li>OpenID authentication support</li>
		<li>Possibility to import Word documents</li>
		<li>Possibility to import docx and pptx documents (new MS-Office format)</li>
		<li>Grades,
	evaluations and success certificates available thanks to the
	integration of the gradebook extension. Activating this module will
	clash with a gradebook extension installation made previously</li>
		<li>Coloured icons added to courses list in administration panel to show access permissions</li>
		<li>Logout button now shows the username of the current user</li>
		<li>Student view re-activated and fully-functional</li>
		<li>Searching
	the forum is now possible so you can use the forum as a knowledge base.
	The search results are highlighted throughout the forum and you can
	search on multiple words also. </li>
	    <li>Group members are now displayed in a sortable table</li>
		<li>Possibility to export survey results in XLS format</li>
		<li>Documents, Works and Dropbox tools usability has been improved in many ways</li>
	    <li>In the agenda, you can display the X upcoming events (can be configured by the platform admin)</li>
	    <li>The course agenda now has a month view like the my agenda</li>
	    <li>In
	the user list of the platform administration you can now quickly see
	for what courses the user is subscribed by hovering over the courses
	icon</li>
	    <li>The platform system announcements can now be sent through email also</li>
		<li>User
	fields have been added globally, allowing you to add user data like
	birthdate, mother tongue, city or whatever data you want to ask your
	users</li>
		<li>LDAP
			<ul>
				<li>The LDAP code has changed. If you had some customisations there, you might want to save them and re-apply them after the upgrade</li>
				<li>Functions renamed to respect coding conventions and use ldap_ namespace</li>
				<li>Most
	parameters moved to the administration panel. You will need to
	configure the administration panel with the settings that were
	previously in ldap_var.inc.php</li>
				<li>Added non-anonymous mode (just add a login and a password in the configuration panel)</li>
				<li>Added search domain configuration through panel</li>
				<li>Added customizable field-check for student-teacher switch</li>
				<li>The installation guide has been updated to help you find your way through the new LDAP configuration panel</li>
				<li>You still need to activate LDAP by uncommenting two lines in configuration.php</li>
		    </ul>
		</li>
	    <li>New stylesheets can be added through the platform administration interface</li>
	    <li>Notification
	by email has been improved in the forum. You can now indicate that you
	want to be informed of messages on the forum level or on the thread
	level, even if you did not participate in the discussion yet. </li>
	    <li>The
	platform administrator can decide to display the courses that are not
	open on the login page. When these courses are displayed on the campus
	startpage then the user that is logged in can quickly subscribe to this
	course.</li>
	    <li>When creating a new group you can decide to create
	a public or private forum or no forum at all. These are group category
	settings.</li>
	    <li>Group forum is also displayed in the group space</li>
	    <li>Surveys that are not based on invitation but open to all (or certain) members of the course are now available</li>
	    <li>Agenda
	    	<ul>
	    		<li>iCal import and export of course events, with a choice of public, private or confidential markers</li>
	    		<li>Repetitive
	course events can be created (and exported to iCal). Repetitions types
	supported are: daily, weekly, monthly by date (e.g. the 5th of each
	month) and yearly by date</li>
	   		</ul>
		</li>
		<li>Document templates have been greatly improved to speed-up custom course content creation</li>
		<li>Audiorecorder
	(depending on streaming server) now records sounds in the
	document/audio directory, making them easily reusable by the course
	admin</li>
		<li>Audiorecorder is not loaded by default (took too long) and you can load it with a simple click</li>
		<li>W3C - Compliance with XHTML 1.0 Transitional has been improved</li>
		<li>Tracking - A new page to display access details by user is available under the Reporting tab, in the user details in a course</li>
		<li>Removed header from learning path tool. It was taking too much space and was not flexible enough for CSS styling</li>
		<li>Improved speed of 1.6 to 1.8 migration by adding indexes</li>
	    </ul>
	<br />
	<h3>Bug fixes</h3>
	<ul>
		<li>Prerequisites management in learning paths fixed (includes quizzes, hotpotatoes and SCORM)</li>
		<li>Various minor bugs fixed in the learning path tool (scoring, copy, re-ordering)</li>
		<li>Various minor bugs fixed in the session handling</li>
		<li>Fixes to the survey tool (date management, questions order in export)</li>
		<li>Fixes to the calendar tool (access by students)</li>
		<li>Fixes to the announcement tool (access by students)</li>
		<li>Fixes to the group tool (default group settings)</li>
		<li>Bugfix: complete export in survey tool displayed the question of all the surveys and not only those of the selected survey</li>
	    <li>Bugfix:
	registering a new user resulted in the language field of the user being
	empty which resulted in an english profile by default. This has now
	been changed to the platform language. </li>
	    <li>Performance improvement in the user list of the platform administration </li>
		<li>Bugfix: group tutors were not migrated from 1.6 to 1.8</li>
		<li>SCORM export: fixes in export method</li>
		<li>Documentation is now fully XHTML 1.0 Transitional compliant</li>
		<li>Fix FCKeditor Flash upload lack of usability and problems with IE</li>
	</ul>
	<br />
	<h3>Known issues</h3>
	<ul>
	    <li>Audiorecorder takes a few seconds to write the audio file
	back to the document directory, so the page shouldn't be changed too
	quickly after recording a sound track</li>
	    <li>When migrating from 1.6 to 1.8, some SCORM learning paths might need to be re-imported, which means their tracking is lost</li>
	</ul>



	<h1>Dokeos 1.8.4 - September 2007</h1>
	<h3>Release notes - summary</h3>
	<p>Dokeos
	1.8.4 is both a features and Bug fixing major release.&nbsp;</p>
	<h3>New Features</h3>
	<ul>
	  <li>Templates. See <a href="http://www.dokeos.com/templates.php">http://www.dokeos.com/templates.php</a></li>
	  <li>Wide Hotspots tests to allow real-life situations simulation</li>

	  <li>Flash video import and streaming</li>

	  <li>Installation guide renewed. See&nbsp;<a href="http://www.dokeos.com/doc/installation_guide.html">http://www.dokeos.com/doc/installation_guide.html</a></li>

	  <li>Added animated Mr Dokeos character : <a href="http://www.dokeos.com/mrdokeos.php">http://www.dokeos.com/mrdokeos.php</a></li>

	  <li>English and Dutch teacher manual added</li>

	  <li>Assignments form now fills automatically with document title and user name</li>

	  <li>Document authoring space now bigger</li>

	  <li>IMS/QTI export of tests</li>
	  <li>Export of media (images, Flash, Audio) and tests in SCORM export</li>
	  <li>Agenda default time management for an event improved</li>
	  <li>Oogie PowerPoint converter setup simplified</li>
	  <li>Improved support for other character sets (enabling better support for
	UTF-8 and russian and asian fonts)</li>

	</ul>

	<br />

	<h3>Bug fixes</h3>

	<ul>
	  <li>Upgrade script improved : now possible to upgrade direct from 1.6 to 1.8.4.&nbsp;</li>
	  <li>Blogs user rights</li>
	  <li>FCK Editor image import</li>
	  <li>Videoconferencing slides now include Documents directory of course</li>
	  <li>SCORM content can be displayed Full Screen</li>
	  <li>SCORM interactions now properly running</li>
	  <li>Hotspots tests redesigned and bigger hotspots zone</li>
	  <li>Alphabetical sorting of lists fixed</li>
	  <li>Excel export in reporting now removes HTML tags</li>
	  <li>My profile page display layout</li>
	  <li>Import HotPotatoes tests scoring</li>
	  <li>Images gallery in Documents bad display</li>
	  <li>Agenda default date now more relevant</li>
	  <li>Tests random questions order option clarified</li>
	  <li>Templates editing and media removal now easier</li>
	  <li>Apostrophe bug in Learning path Build mode</li>
	  <li>Table of contents wider in Learning path</li>
	  <li>Audio player now autostarts</li>
	  <li>Spelling mistakes in French and English</li>
	  <li>Group features now related to group, not generic</li>
	  <li>Blogs SQL errors fixed</li>
	  <li>Introduction images were missing in tests reporting</li>
	  <li>SCORM export now working</li>
	  <li>My agenda Personal events editor bug fixed</li>
	  <li>Oogie PowerPoint import installation easier</li>
	  <li>Time spent on platform tracking improved</li>
	  <li>Course Backup/restore bugs fixed</li>
	  <li>Course copy bugs fixed</li>
	  <li>Default visibility status of learning paths fixed</li>
	  <li>Images gallery display reordering</li>
	  <li>Agenda default time management for an event improved</li>
	  <li>Groups display alphabetical sorting fixed</li>
	</ul>


	<h1>Dokeos 1.8 - May 2007</h1>

	<h3>Release notes - summary</h3>

	<p>Dokeos 1.8 is a major release. The software becomes a complete suite
	including not only a learning management system and a learners
	administration dashboard, but also an easy-to-use authoring system and
	a simple videoconferencing interface.</p>



	<h3>New Features</h3>

	<ul>
	      <li> Ms-PowerPoint� to Learning Path conversion</li>
	      <li>Integrated Live Conferencing&nbsp;</li>
	      <li>Templates and styles for rapid online authoring</li>
	      <li>Search engine&nbsp;</li>
	      <li>New question types: hotspots and&nbsp;open answers</li>
	      <li>Reporting dashboard with export to Ms-Excel</li>
	      <li>Surveys</li>
	      <li>Educational blogs</li>
	      <li>Learning Path: better import and export of SCORM, IMS and  AICC </li>
	      <li>Documents tool: PowerPoint and Word into HTML file type  conversion</li>
	      <li>Tests tool: less sequential and more user-friendly</li>
	      <li>Forum : better admin and content management</li>
	      <li>code cleanup </li>
	      <li>new nice looking icons</li>
	      <li>new layout for the course homepage</li>
	      <li>Version check: be informed when a new Dokeos release is available.  </li>
	      <li>Platform Statistics so you can boast with your campus. </li>
	</ul>


	<h1>Dokeos 1.6.5 - July 2006 </h1>

	<h3>Release notes - summary</h3>

	<p>Security Release. 1 bug has been fixed. Click the link below to see the complete list of bugfixes<br />
	<a href="http://www.dokeos.com/wiki/index.php/Dokeos_1.6.5_release_notes_and_changelog">http://www.dokeos.com/wiki/index.php/Dokeos_1.6.5_release_notes_and_changelog</a></p>



	<h1>Dokeos 1.6.4 April 2006 </h1>

	<h3>Release notes - summary</h3>
	<p>Bugfix release. 2 bugs have been fixed. One security hole has been fixed <br />


	    Click the link below to see the complete list of bugfixes<br />


	    <a href="http://www.dokeos.com/wiki/index.php/Dokeos_1.6.4_release_notes_and_changelog">http://www.dokeos.com/wiki/index.php/Dokeos_1.6.4_release_notes_and_changelog</a></p>



	<h1>Dokeos 1.6.3 February 2006 </h1>



	<h3>Release notes - summary</h3>



	<p>Bugfix release. 44 bugs have been fixed. Click the link below to see the complete list of bugfixes<br />


	    <a href="http://www.dokeos.com/wiki/index.php/Dokeos_1.6.3_release_notes_and_changelog">http://www.dokeos.com/wiki/index.php/Dokeos_1.6.3_release_notes_and_changelog</a> </p>



	<h1>Dokeos 1.6.2 - September 2005</h1>



	<h3>Release notes - summary</h3>



	<p>Bugfix release. 14 bugs have been fixed. Click the link below to see the complete list of bugfixes<br />


	    <a href="http://www.dokeos.com/wiki/index.php/Dokeos_1.6.2_release_notes_and_changelog">http://www.dokeos.com/wiki/index.php/Dokeos_1.6.2_release_notes_and_changelog</a></p>



	<h1>Dokeos 1.6.1 - August 2005</h1>



	<h3>Release notes - summary</h3>



	<p>Bugfix release. 31 bugs have been fixed. Click the link below to see the complete list of bugfixes<br />


	    <a href="http://www.dokeos.com/wiki/index.php/Dokeos_1.6.1_release_notes_and_changelog">http://www.dokeos.com/wiki/index.php/Dokeos_1.6.1_release_notes_and_changelog</a></p>



	<h1>Dokeos 1.6 - July 2005</h1>

	<h3>Release notes - summary</h3>
	<p>In Dokeos 1.6, security and interoperability have been improved. Protection<br /> for documents has improved, and courses have more accessibility options.<br />
	      Password encryption is enabled by default. The php.ini setting <br />
	    "register globals" does not have be on anymore.<br />
	    <a href="http://www.dokeos.com/wiki/index.php/Dokeos_1.6_release_notes">http://www.dokeos.com/wiki/index.php/Dokeos_1.6_release_notes </a></p>

	<h3>New Features</h3>
	<ul>
		<li>Campus home page can be edited online</li>
		<li> Improved translations, made with the new Dokeos translation tool</li>
		<li> Language switch - when you enter the portal, you can choose your language.</li>
		<li>
Who is online: a list of users who are logged in, you can click to see
their pictures and portfolio, or click to talk to them through our
built-in web chat tool.</li>
		<li>Learning path - import and export of SCORM packages, improved layout,	prerequisites based on score in tests</li>
		<li> Agenda - many new options, e.g. every user can add personal agenda items.</li>
		<li>Document tool - many new options, improved layout, improved HtmlArea</li>
		<li> Security - PHP register globals setting don't need to be on anymore</li>
		<li>
Administration section - all functions are easier to access, you can
configure many options through the web interface instead of by digging
through the code. </li>
	      <li> Improved course management -
completely rewritten course import/export functions, easily copy
content from one course to another</li>
	      <li> Plugins and modularity - new system to add plugins to Dokeos more easily</li>
	      <li> API libraries - our function libraries have been expanded and improved</li>
	      <li>Interoperability: support for SCORM import/export, XML import/export for
		some features, IEEE LOM Metadata support in documents and groups, import of
		Hotpotatoes, connection with QuestionMark (this last one will be available
		as plugin).</li>
	</ul>



	<h3>Roadmap</h3>
	<p><a href="http://www.dokeos.com/wiki/index.php/Roadmap_1.6">http://www.dokeos.com/wiki/index.php/Roadmap_1.6</a></p>



			<h1>Dokeos 1.5.5   </h1>
			<ul>
				<li>Learning path : Scorm content import tool</li>
				<li> WYSIWYG editor : create content on the fly</li>
				<li> Table of contents : structure content on the fly</li>
				<li> Dropbox : peer2peer content sharing management</li>
				<li> Links categories : structure links catalogue</li>
				<li>New navigation : one click to tool</li>
				<li> Events since my last visit : be informed of what has changed since your last login</li>
				<li> My agenda : synthetic weekly view of all the events related to you</li>
				<li> Add a picture to my profile : see who is who</li>
				<li> Security : privacy and anti-cracking protection</li>
				<li> 5 more languages : russian, catalan, vietnamese, brazilian, thai and a revised chinese</li>
				<li> New chat tool : real-time textual discussion</li>
				<li> Audio &amp; video conference : real-time live broadcasting of events + textual interaction with ore than 200 people.</li>
				<li> Announcements to some users or some groups only</li>
				<li> Time-based learning management : add resources to time line in Agenda</li>
				<li> Audio &amp; video in Tests tool : create listening comprehensions, situation-based questions on the fly</li>
				<li> Forum thread/flat view : see discussions in more detail</li>
				<li>Forum email notification : get an email when your forum topic is active</li>
				<li>
language revision : dokeos vocabulary has been generalised to be
adapted to different types of organisations and not only universities</li>
			</ul>

			<div style="font-style: italic; padding-top: 20px;"><span style="font-weight: bold;">United States</span>&nbsp; : Dokeos, Faneuil Hall Marketplace Boston, Massachusetts 02109 United
States Tel. +1 617-973-5180 Email: support@dokeos.com<br />

<br />

<span style="font-weight: bold;">Europe</span> : Dokeos, 54/56 avenue Hoche 75008 Paris Tel : +33 (0)1 56 60 54 90 Email : sales.fr@dokeos.com<br />

</div>
		</div>
	</div>
</body></html>