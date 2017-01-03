$(function() {

    CKEDITOR.on('dialogDefinition', function(event) {
        var editor = event.editor;
        var dialogDefinition = event.data.definition;
        var tabCount = dialogDefinition.contents.length;
        for (var i = 0; i < tabCount; i++) { // cycle to replace the click of button "View on the server"

            if (!dialogDefinition.contents[i]) {
                continue;
            }

            var browseButton = dialogDefinition.contents[i].get('browse');

            if (browseButton !== null) {
                browseButton.hidden = false;
                browseButton.onClick = function(dialog, i) {

                    var dialogName = CKEDITOR.dialog.getCurrent()._.name;

                    var elfNode = $('<div \>').css({
                        "z-index": "100000"
                    });
                    elfNode.dialogelfinder({
                        title: '',
                        url: '/admin/elfinder/connector',
                        useBrowserHistory: false,
                        resizable: false,
                        getFileCallback: function(file) {
                            var url = file.url;
                            var dialog = CKEDITOR.dialog.getCurrent();
                            if (dialogName == 'image') {
                                var urlObj = 'txtUrl'
                            } else if (dialogName == 'flash') {
                                var urlObj = 'src'
                            } else if (dialogName == 'files' || dialogName == 'link') {
                                var urlObj = 'url'
                            } else {
                                return;
                            }
                            dialog.setValueOf(dialog._.currentTabId, urlObj, url);
                            elfNode.dialogelfinder('close');
                        }
                    });
                }
            }
        }
    })
});
