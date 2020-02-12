<?php session_start();
if(!isset($_SESSION['account']) || empty($_SESSION['account'])){
    header('Location: ./login');
}else{
  //MoxieManager Override Config
  $_SESSION['isLoggedIn']	= true;
  //MoxieManager Override Config
  $_SESSION["moxiemanager.filesystem.rootpath"] = realpath(dirname(__FILE__)).'/uploads/'.$_SESSION['account'];
  //DB Configuratiobn
  require_once("../conn/mt4-config.php");
  include_once("../language.php");
  include_once("../include/function.php");

  $sql="SELECT u.*, t.title, c.countryName
        FROM `account-request` AS u
        LEFT JOIN `title` AS t ON t.titleid = u.titleid
        LEFT JOIN `countries` AS c ON c.countryCode = u.countryCode
        WHERE u.id=".$_SESSION['account'];
  $row = $db->get_row($sql);
  if(!empty($row)){
    $acc_name	    =	ucfirst($row->title).". ".ucfirst($row->firstname)." ".ucfirst($row->lastname);
    $acc_country  =	$row->countryCode;
    $acc_phone	  =	$row->phone;
    $acc_email    =	$row->email;
    $acc_type     =	$row->type;
    $acc_ibcode   =	$row->ibcode;
  }
}
//--------------
// Logout Check
//--------------
if(isset($_GET['action']) && $_GET['action']=='logout'){
	//session_destroy();
  unset($_SESSION["account"]);
	header('Location: ./login');
}
?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/sb-admin.css" rel="stylesheet">
<link href="css/plugins/morris.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="../components/jQuery-File-Upload-9.28.0/css/jquery.fileupload.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!--TinyMCE-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../components/tinymce_v4.5.5/tinymce/js/tinymce/tinymce.min.js" type="text/javascript"></script>
<link href="./style/content.css" type="text/css" rel="stylesheet" />
<link href="./style/WYSIWYG.css" type="text/css" rel="stylesheet" />
<!--Prism-->
<link href="../components/tinymce_plugins/prism/prism.css" type="text/css" rel="stylesheet" />
<script src="../components/tinymce_plugins/prism/prism.js"></script>

<script type="text/javascript" src="../components/jquery-loading-overlay-v1.5.3/src/loadingoverlay.min.js?v=2"></script>

<!--------------------------------------------------------->
<!-- Add jQuery library -->
<script type="text/javascript" src="../components/fancybox-v2.1.5/lib/jquery-1.10.1.min.js"></script>
<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="../components/fancybox-v2.1.5/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="../components/fancybox-v2.1.5/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="../components/fancybox-v2.1.5/source/jquery.fancybox.css?v=2.1.5" media="screen" />

<!-- Add Button helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="../components/fancybox-v2.1.5/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
<script type="text/javascript" src="../components/fancybox-v2.1.5/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

<!-- Add Media helper (this is optional) -->
<script type="text/javascript" src="../components/fancybox-v2.1.5/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<script type="text/javascript">
  $(document).ready(function() {
      $('.id-card').fancybox();
  });
</script>
<script>
//Tinymce Loadbalance
$(document).ready(function () {
	if (typeof tinymce == 'undefined') {
		var head = document.getElementsByTagName('head')[0],
			 script = document.createElement('script');
		script.src = '//tinymce.cachefly.net/4.3.10/tinymce.min.js';
		head.appendChild(script);
	}
	//Prepare Tinymce
	function initTinyMCE()
	{
		if(typeof tinymce == 'undefined') {
			setTimeout(initTinyMCE, 100);
			return;
		}
		//Start TinyMCE
		tinymce.init({
			selector: '#content',
			cache_suffix: '?v=4.3.10',
			height: 300,
			//Fix Toolbar on Top 
			//autofocus: true,
			//inline: true,
			//fixed_toolbar_container: '#mytoolbar',
			//Always visible the Toolbar
			init_instance_callback: function () {
				tinymce.activeEditor.focus();
			},
			setup: function (editor) {
				editor.on('blur', function () {
					//throw new Error('tiny mce hack workaround');
					return false;
				});
			},	
		
			autoresize_min_height: 300,
			autoresize_bottom_margin: 10,
			plugin_preview_width: "100%",
			width: "100%",
			paste_text_use_dialog: true,
			//paste_as_text: true,
			
			//Moxiemanager Files Setting
			relative_urls : false,
			remove_script_host : false,
			document_base_url : "https://cdn.pps-forex.com/uploads",
			
			theme: "modern",
			browser_spellcheck : true,
			autosave_ask_before_unload: false,
			
			content_css: [
				'https://www.pps-forex.com/account/style/font.css?v=' + new Date().getTime(),
				'https://www.pps-forex.com/account/style/WYSIWYG.css?v=' + new Date().getTime(),
			],
			
			external_plugins: {
				"moxiemanager": "https://pps-forex.com/components/tinymce_plugins/moxiemanager/plugin.js",
				"placeholder": "https://pps-forex.com/components/tinymce_plugins/placeholder/plugin.js",
				"youtube": "https://pps-forex.com/components/tinymce_plugins/youtube/plugin.js",
				"codemirror": "https://pps-forex.com/components/tinymce_plugins/tinymce-codemirror-master/plugins/codemirror/plugin.js"
			},
			//Moxie Manager Setting
			moxiemanager_title: 'Media Manager',
			moxiemanager_leftpanel: false,
			moxiemanager_remember_last_path: true,
			moxiemanager_upload_auto_close: true,
			
			moxiemanager_image_settings : { 
				moxiemanager_title: 'Image Manager',
				view : 'thumbs', 
				extensions : 'jpg,png,gif,tiff,svg',
			},
			
			moxiemanager_media_settings : {
				moxiemanager_title: 'Media Manager',
				view : 'thumbs', 
				extensions : 'mpg,mpeg,avi,wmv,mov,rm,ram,swf,flv,ogg,webm,mp4,mid,midi,wma,aac,ogg,mp3'
			},
			
			moxiemanager_file_settings : {
				moxiemanager_title: 'File Manager',
				view : 'thumbs', 
				extensions : 'html,txt,pdf,doc,xls'
			},
			//All Plugins
			plugins:[
							"moxiemanager placeholder youtube codemirror autoresize", 
							"advlist autolink lists link charmap print preview hr anchor pagebreak",
							"searchreplace wordcount visualblocks visualchars fullscreen",
							"insertdatetime nonbreaking save table directionality",
							"emoticons template paste textcolor colorpicker textpattern image media imagetools codesample"
							],
			//Toolbar	1				
			toolbar1: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media youtube",
			//Toolbar	2
			toolbar2: "print preview | forecolor backcolor emoticons | code fullscreen codesample",
			//Code Mirror
			codemirror: {
				indentOnInit: true,
				path: 'CodeMirror',
				config: {
					lineNumbers: true       
				}
			},
			//Valid Eliment
			extended_valid_elements : "a[class|name|href|target|title|onclick|rel],script[type|src],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],$elements",
	
			//New Features
			image_caption: true,
			media_live_embeds: true,
			imagetools_cors_hosts: ['cdn.pps-forex.com', 'codepen.io'],
			
			image_advtab: true,
			statusbar: true,
		});
	}
	//Load
	initTinyMCE();
});
</script>

<style>
  .id-card img{
    border-radius:5px; border:solid 1px #999; max-width:100%;
  }  
border-radius:5px; border:solid 1px #999; max-width:100%;
.badge:hover {
  color: #ffffff;
  text-decoration: none;
  cursor: pointer;
}
.badge-error {
  background-color: #b94a48;
}
.badge-error:hover {
  background-color: #953b39;
}
.badge-warning {
  background-color: #f89406;
}
.badge-warning:hover {
  background-color: #c67605;
}
.badge-success {
  background-color: #468847;
}
.badge-success:hover {
  background-color: #356635;
}
.badge-info {
  background-color: #3a87ad;
}
.badge-info:hover {
  background-color: #2d6987;
}
.badge-inverse {
  background-color: #333333;
}
.badge-inverse:hover {
  background-color: #1a1a1a;
}
</style>
</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
            <!-- Brand and toggle get grouped for better mobile display -->

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./"><table><tr><td><img src="./images/pps.png" style="height:24px;" /></td><td style="padding-left:20px;"> Account Management</td></tr></table></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                       <!--
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>Sokleng</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>Jenny Sopheak</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>Sor Chan</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        -->
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                        
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">1 Account... <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">1 Account... <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">1 Account... <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">1 Account... <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">1 Account... <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">1 Account... <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo ucwords($acc_name);?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#" id="logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>

    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <?php include("./menu.php");?>
    <!-- /.navbar-collapse -->
</nav>

  <div id="page-wrapper">
    <div class="container-fluid">