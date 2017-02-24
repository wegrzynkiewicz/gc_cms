/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here. For example:
    //config.language = 'fr';
    //config.uiColor = '#AADC6E';





    config.disallowedContent = 'script; *[on*]';
    config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Language,About';
    //config.extraPlugins = 'chart,widget,lineutils,clipboard,dialog,tableresize,autogrow,btgrid,fontawesome,colordialog,symbol,pastefromexcel,ckeditortablecellsselection,quicktable,smiley,texttransform,backgrounds,lineheight,qrc,youtube,imagerotate,fixed';



    config.contentsCss = [
        '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'
    ];

    config.allowedContent = true;
    config.filebrowserBrowseUrl = '#';
};


    //usuniete pluginy = ,glyphicons,fixed,imageresponsive,image2,;
