/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */




    CKEDITOR.plugins.addExternal('dialog','/assets/admin/ckeditorPlugins/dialog/', 'plugin.js');
    CKEDITOR.plugins.addExternal('contextmenu','/assets/admin/ckeditorPlugins/contextmenu/', 'plugin.js');
    CKEDITOR.plugins.addExternal('clipboard','/assets/admin/ckeditorPlugins/clipboard/', 'plugin.js');
    CKEDITOR.plugins.addExternal('justify','/assets/admin/ckeditorPlugins/justify/', 'plugin.js');
    CKEDITOR.plugins.addExternal('table','/assets/admin/ckeditorPlugins/table/', 'plugin.js');
    CKEDITOR.plugins.addExternal('tableresize','/assets/admin/ckeditorPlugins/tableresize/', 'plugin.js');
    CKEDITOR.plugins.addExternal('panel','/assets/admin/ckeditorPlugins/panel/', 'plugin.js');
    CKEDITOR.plugins.addExternal('floatpanel','/assets/admin/ckeditorPlugins/floatpanel/', 'plugin.js');
    CKEDITOR.plugins.addExternal('panelbutton','/assets/admin/ckeditorPlugins/panelbutton/', 'plugin.js');
    CKEDITOR.plugins.addExternal('quicktable','/assets/admin/ckeditorPlugins/quicktable/', 'plugin.js');
    CKEDITOR.plugins.addExternal('button','/assets/admin/ckeditorPlugins/button/', 'plugin.js');
    CKEDITOR.plugins.addExternal('smiley','/assets/admin/ckeditorPlugins/smiley/', 'plugin.js');
    CKEDITOR.plugins.addExternal('font','/assets/admin/ckeditorPlugins/font/', 'plugin.js');
    CKEDITOR.plugins.addExternal('colorbutton','/assets/admin/ckeditorPlugins/colorbutton/', 'plugin.js');
    CKEDITOR.plugins.addExternal('colordialog','/assets/admin/ckeditorPlugins/colordialog/', 'plugin.js');
    CKEDITOR.plugins.addExternal('backgrounds','/assets/admin/ckeditorPlugins/backgrounds/', 'plugin.js');
    CKEDITOR.plugins.addExternal('autogrow','/assets/admin/ckeditorPlugins/autogrow/', 'plugin.js');
    CKEDITOR.plugins.addExternal('widget','/assets/admin/ckeditorPlugins/widget/', 'plugin.js');
    CKEDITOR.plugins.addExternal('pastefromexcel','/assets/admin/ckeditorPlugins/pastefromexcel/', 'plugin.js');
    CKEDITOR.plugins.addExternal('menu','/assets/admin/ckeditorPlugins/menu/', 'plugin.js');
    CKEDITOR.plugins.addExternal('dialogadvtab','/assets/admin/ckeditorPlugins/dialogadvtab/', 'plugin.js');



CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here. For example:
    //config.language = 'fr';
    //config.uiColor = '#AADC6E';


    config.disallowedContent = 'script; *[on*]';
    config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Language,About';
    config.extraPlugins ='justify,tableresize,panel,floatpanel,panelbutton,quicktable,button,smiley,font,colorbutton,colordialog,dialog,backgrounds,clipboard,contextmenu,table,autogrow,widget,pastefromexcel,menu,dialogadvtab';

    //config.extraPlugins = 'chart,widget,lineutils,clipboard,dialog,tableresize,autogrow,btgrid,fontawesome,colordialog,symbol,pastefromexcel,ckeditortablecellsselection,quicktable,smiley,texttransform,backgrounds,lineheight,qrc,youtube,imagerotate,fixed';



    config.contentsCss = [
        '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'
    ];

    config.allowedContent = true;
    config.filebrowserBrowseUrl = '#';


};


    //usuniete pluginy = ,glyphicons,fixed,imageresponsive,image2,;
