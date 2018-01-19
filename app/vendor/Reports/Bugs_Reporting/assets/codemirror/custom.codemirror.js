
/**
* Theme: Velonic Admin Template
* Author: Coderthemes
* Code Editors pages
*/

!function($) {
    "use strict";

    var CodeEditor = function() {};

    CodeEditor.prototype.getSelectedRange = function(editor) {
        return { from: editor.getCursor(true), to: editor.getCursor(false) };
    },
    CodeEditor.prototype.autoFormatSelection = function(editor) {
        var range = this.getSelectedRange(editor);
        editor.autoFormatRange(range.from, range.to);
    },
    CodeEditor.prototype.commentSelection = function(isComment, editor) {
        var range = this.getSelectedRange(editor);
        editor.commentRange(isComment, range.from, range.to);
    },
    CodeEditor.prototype.init = function() {
        var $this = this;
        //init plugin
        CodeMirror.fromTextArea(document.getElementById("code"), {
            mode: {name: "xml", alignCDATA: true},
            lineNumbers: true
        });
        //example 2
        CodeMirror.fromTextArea(document.getElementById("code2"), {
            mode: {name: "javascript"},
            lineNumbers: true,
            theme: 'ambiance'
        });

        //example 3
        var editor = CodeMirror.fromTextArea(document.getElementById("code3"), {
            mode: {name: "javascript"},
            lineNumbers: true,
        });
        CodeMirror.commands["selectAll"](editor);

        //binding controlls
        $('.autoformat').click(function(){
            $this.autoFormatSelection(editor);
        });
        
        $('.comment').click(function(){
            $this.commentSelection(true, editor);
        });
        
        $('.uncomment').click(function(){
            $this.commentSelection(false, editor);
        });
    },
    //init
    $.CodeEditor = new CodeEditor, $.CodeEditor.Constructor = CodeEditor
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.CodeEditor.init()
}(window.jQuery);
