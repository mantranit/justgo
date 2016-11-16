<?php

return [

//------------------------//
// SYSTEM SETTINGS
//------------------------//

    /**
     * Registration Needs Activation.
     *
     * If set to true users will have to activate their accounts using email account activation.
     */
    'rna' => true,

    /**
     * Login With Email.
     *
     * If set to true users will have to login using email/password combo.
     */
    'lwe' => false, 

    /**
     * Force Strong Password.
     *
     * If set to true users will have to use passwords with strength determined by StrengthValidator.
     */
    'fsp' => false,

    /**
     * Set the password reset token expiration time.
     */
    'user.passwordResetTokenExpire' => 3600,

//------------------------//
// EMAILS
//------------------------//

    /**
     * Email used in contact form.
     * Users will send you emails to this address.
     */
    'adminEmail' => 'duytancomputer350@gmail.com',

    /**
     * Not used in template.
     * You can set support email here.
     */
    'supportEmail' => 'duytancomputer350@gmail.com',

    'toolbarContent' => [
        'inline' => false,
        'language' => 'vi',
        'toolbar' => [
            ['name' => 'styles', 'items' => [ 'Format' ]],
            ['name' => 'document', 'items' => [ 'Templates' ]],
            ['name' => 'basicstyles', 'items' => [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ]],
            ['name' => 'paragraph', 'items' => [ 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Blockquote']],
            ['name' => 'insert', 'items' => [ 'Table', 'Image', 'Smiley', 'Iframe']],
            ['name' => 'links', 'items' => [ 'Link', 'Unlink', 'Anchor' ]],
            ['name' => 'clipboard', 'items' => ['PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']],
            ['name' => 'styles', 'items' => [ 'Styles', 'Font', 'FontSize' ]],
            ['name' => 'colors', 'items' => [ 'TextColor', 'BGColor' ]],
            ['name' => 'tools', 'items' => [ 'Maximize' ]],
        ],
    ],
    'toolbarDescription' => [
        'inline' => false,
        'language' => 'vi',
        'toolbar' => [
            ['name' => 'styles', 'items' => [ 'Format' ]],
            ['name' => 'basicstyles', 'items' => [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ]],
            ['name' => 'paragraph', 'items' => [ 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']],
            ['name' => 'insert', 'items' => [ 'Table', 'Smiley']],
            ['name' => 'links', 'items' => [ 'Link', 'Unlink', 'Anchor' ]],
            ['name' => 'clipboard', 'items' => ['Undo', 'Redo']],
            ['name' => 'styles', 'items' => [ 'Styles', 'Font', 'FontSize' ]],
            ['name' => 'colors', 'items' => [ 'TextColor', 'BGColor' ]],
            ['name' => 'tools', 'items' => [ 'Maximize' ]],
        ],
        'removePlugins' => 'elementspath',
        'resize_enabled' => false,
    ],
    'toolbarIntro' => [
        'inline' => false,
        'language' => 'vi',
        'toolbar' => [
            ['name' => 'styles', 'items' => [ 'Format' ]],
            ['name' => 'basicstyles', 'items' => [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ]],
            ['name' => 'paragraph', 'items' => [ 'NumberedList', 'BulletedList' ]],
            ['name' => 'insert', 'items' => [ 'Table', 'Smiley']],
            ['name' => 'links', 'items' => [ 'Link', 'Unlink', 'Anchor' ]],
            ['name' => 'clipboard', 'items' => ['Undo', 'Redo']],
            ['name' => 'tools', 'items' => [ 'Maximize' ]],
        ],
        'removePlugins' => 'elementspath',
        'resize_enabled' => false,
    ]
];
