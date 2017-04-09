/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */




    CKEDITOR.plugins.addExternal('dialog','http://cdn.grafcenter.pl/ckeditorPlugins/dialog/', 'plugin.js');
    CKEDITOR.plugins.addExternal('contextmenu','http://cdn.grafcenter.pl/ckeditorPlugins/contextmenu/', 'plugin.js');
    CKEDITOR.plugins.addExternal('clipboard','http://cdn.grafcenter.pl/ckeditorPlugins/clipboard/', 'plugin.js');
    CKEDITOR.plugins.addExternal('justify','http://cdn.grafcenter.pl/ckeditorPlugins/justify/', 'plugin.js');
    CKEDITOR.plugins.addExternal('table','http://cdn.grafcenter.pl/ckeditorPlugins/table/', 'plugin.js');
    CKEDITOR.plugins.addExternal('tableresize','http://cdn.grafcenter.pl/ckeditorPlugins/tableresize/', 'plugin.js');
    CKEDITOR.plugins.addExternal('panel','http://cdn.grafcenter.pl/ckeditorPlugins/panel/', 'plugin.js');
    CKEDITOR.plugins.addExternal('floatpanel','http://cdn.grafcenter.pl/ckeditorPlugins/floatpanel/', 'plugin.js');
    CKEDITOR.plugins.addExternal('panelbutton','http://cdn.grafcenter.pl/ckeditorPlugins/panelbutton/', 'plugin.js');
    CKEDITOR.plugins.addExternal('quicktable','http://cdn.grafcenter.pl/ckeditorPlugins/quicktable/', 'plugin.js');
    CKEDITOR.plugins.addExternal('button','http://cdn.grafcenter.pl/ckeditorPlugins/button/', 'plugin.js');
    CKEDITOR.plugins.addExternal('smiley','http://cdn.grafcenter.pl/ckeditorPlugins/smiley/', 'plugin.js');
    CKEDITOR.plugins.addExternal('font','http://cdn.grafcenter.pl/ckeditorPlugins/font/', 'plugin.js');
    CKEDITOR.plugins.addExternal('colorbutton','http://cdn.grafcenter.pl/ckeditorPlugins/colorbutton/', 'plugin.js');
    CKEDITOR.plugins.addExternal('colordialog','http://cdn.grafcenter.pl/ckeditorPlugins/colordialog/', 'plugin.js');
    CKEDITOR.plugins.addExternal('backgrounds','http://cdn.grafcenter.pl/ckeditorPlugins/backgrounds/', 'plugin.js');
    CKEDITOR.plugins.addExternal('autogrow','http://cdn.grafcenter.pl/ckeditorPlugins/autogrow/', 'plugin.js');
    CKEDITOR.plugins.addExternal('widget','http://cdn.grafcenter.pl/ckeditorPlugins/widget/', 'plugin.js');
    CKEDITOR.plugins.addExternal('pastefromexcel','http://cdn.grafcenter.pl/ckeditorPlugins/pastefromexcel/', 'plugin.js');
    CKEDITOR.plugins.addExternal('menu','http://cdn.grafcenter.pl/ckeditorPlugins/menu/', 'plugin.js');
    CKEDITOR.plugins.addExternal('dialogadvtab','http://cdn.grafcenter.pl/ckeditorPlugins/dialogadvtab/', 'plugin.js');



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
