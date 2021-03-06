<?php require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>elFinder 2.1.x source version with PHP connector</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" />

    <style>
        body{
            margin:0; padding:0;
        }
    </style>
</head>
<body>
	<div id="elfinder"></div>

    <?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>

    <script>
        function getUrlParam(paramName) {
            var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
            var match = window.location.search.match(reParam) ;

            return (match && match.length > 1) ? match[1] : '' ;
        }

        $().ready(function() {
            var funcNum = getUrlParam('CKEditorFuncNum');

            var elf = $('#elfinder').elfinder({
                getFileCallback : function(file) {
                    window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
                    elf.destroy();
                    window.close();
                },
                resizable: false,
                url: '<?=$uri->make($config['elfinder']['uri'])?>',
                lang: '<?=getVisitorLang()?>',
            }).elfinder('instance');
        });
    </script>

</body>
</html>
