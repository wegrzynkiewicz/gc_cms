<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>elFinder 2.1.x source version with PHP connector</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" />

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.15/css/elfinder.min.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.15/css/theme.min.css">

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.15/js/elfinder.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.15/js/i18n/elfinder.pl.js"></script>

    <script>
        // Helper function to get parameters from the query string.
        function getUrlParam(paramName) {
            var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
            var match = window.location.search.match(reParam) ;

            return (match && match.length > 1) ? match[1] : '' ;
        }

        $().ready(function() {
            var funcNum = getUrlParam('CKEditorFuncNum');

            var elf = $('#elfinder').elfinder({
                url : '/admin/elfinder/connector',
                getFileCallback : function(file) {
                    window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
                    elf.destroy();
                    window.close();
                },
                resizable: false
            }).elfinder('instance');
        });
    </script>

    <style>
        body{
            margin:0; padding:0;
        }
    </style>
</head>
<body>
	<div id="elfinder"></div>
</body>
</html>
