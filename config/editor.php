<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Configuration option for Editor.md
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options for Editor.md. For all the
    | configuration options, please see the offcial website of Editor.md :
    | https://pandao.github.io/editor.md/
    |
    */
    'width' => '100%',
    'height' => '640',
    'saveHTMLToTextarea' => 'true',
    'emoji' => 'false',
    'emojiPath' => '//staticfile.qnssl.com/emoji-cheat-sheet/1.0.0/',
    'taskList' => 'true',
    'tex' => 'false',
    'toc' => 'false',
    'tocm' => 'false',
    'codeFold' => 'true',
    'flowChart' => 'false',
    'sequenceDiagram' => 'false',
    'path'=> '/vendor/editor.md/lib/',
    'imageUpload' => 'false',
    'imageFormats' => ["jpg", "gif", "png"],
    'imageUploadURL' => '/xetaravel-editor-md/upload/picture',
    'toolbarIcons' => '() => editormd.toolbarModes[simple]', // full, simple, mini

    /*
    |--------------------------------------------------------------------------
    | Destination Path for uploaded files
    |--------------------------------------------------------------------------
    |
    | Here you may specify where to upload the files.
    |
    */
   'baseUploadPath' => 'editor-md/uploads/content/'
];
