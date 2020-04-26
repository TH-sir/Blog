require('./bootstrap');

require("inline-attachment/src/inline-attachment.js");

require("inline-attachment/src/codemirror-4.inline-attachment.js");

window.markdown_editor = function () {
    window.SimpleMDE = require('simplemde');
    // Most options demonstrate the non-default behavior
    var unique_id = $('#slug').val() ? $('#slug').val() : 'markdown';
    var markdown = new SimpleMDE({
        autofocus: true,
        autosave: {
            enabled: true,
            uniqueId: unique_id,
            delay: 1000
        },
        element: document.getElementById("markdown"),
        insertTexts: {
            horizontalRule: ["", "\n\n-----\n\n"],
            image: ["![](https://", ")"],
            link: ["[", "](https://)"],
            table: ["", "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text     | Text      | Text     |\n\n"],
        },
        placeholder: "在这写上你的想法...",
        spellChecker: false,
        renderingConfig: {
            codeSyntaxHighlighting: true
        },
        showIcons: ["code", "horizontal-rule", "table", "strikethrough", "heading-1", "heading-2", "heading-3"],
        toolbar: [

            {
                name: "加粗",
                action: SimpleMDE.toggleBold,
                className: "fa fa-bold",
                title: "加粗"
            },

            {
                name: "bold",
                action: SimpleMDE.toggleItalic,
                className: "fa fa-italic",
                title: "斜体"
            },

            {
                name: "strikethrough",
                action: SimpleMDE.toggleStrikethrough,
                className: "fa fa-strikethrough",
                title: "删除线"
            },

            '|',

            {
                name: "heading",
                action: SimpleMDE.toggleHeadingSmaller,
                className: "fa fa-header",
                title: "标题"
            },

            {
                name: "heading-1",
                action: SimpleMDE.toggleHeading1,
                className: "fa fa-header fa-header-x fa-header-1",
                title: "一级标题"
            },

            {
                name: "heading-2",
                action: SimpleMDE.toggleHeading2,
                className: "fa fa-header fa-header-x fa-header-2",
                title: "二级标题"
            },

            {
                name: "heading-3",
                action: SimpleMDE.toggleHeading1,
                className: "fa fa-header fa-header-x fa-header-3",
                title: "三级标题"
            },

            '|',

            {
                name: "code",
                action: SimpleMDE.toggleCodeBlock,
                className: "fa fa-code",
                title: "插入代码"
            },

            {
                name: "quote",
                action: SimpleMDE.toggleBlockquote,
                className: "fa fa-quote-left",
                title: "引用"
            },

            {
                name: "unordered-list",
                action: SimpleMDE.toggleUnorderedList,
                className: "fa fa-list-ul",
                title: "无序列表"
            },

            {
                name: "ordered-list",
                action: SimpleMDE.toggleOrderedList,
                className: "fa fa-list-ol",
                title: "有序列表"
            },

            {
                name: "horizontal-rule",
                action: SimpleMDE.drawHorizontalRule,
                className: "fa fa-minus",
                title: "插入水平线"
            },

            '|',

            {
                name: "link",
                action: SimpleMDE.drawLink,
                className: "fa fa-link",
                title: "超链接"
            },

            {
                name: "image",
                action: SimpleMDE.drawImage,
                className: "fa fa-picture-o",
                title: "插入图片"
            },

            {
                name: "table",
                action: SimpleMDE.drawTable,
                className: "fa fa-table",
                title: "插入表格"
            },

            '|',

            {
                name: "preview",
                action: SimpleMDE.togglePreview,
                className: "fa fa-eye no-disable",
                title: "预览"
            },

            {
                name: "side-by-side",
                action: SimpleMDE.toggleSideBySide,
                className: "fa fa-columns no-disable no-mobile",
                title: "实时预览"
            },

            {
                name: "fullscreen",
                action: SimpleMDE.toggleFullScreen,
                className: "fa fa-arrows-alt no-disable no-mobile",
                title: "切换全屏"
            },

            {
                name: "guide",
                action: function customFunction(editor) {
                    window.open("https://vienblog.com/markdown-yu-fa")
                },
                className: "fa fa-question-circle",
                title: "帮助"
            }
        ]
    });

    markdown.codemirror.on("change", function () {
        var html = markdown.value();
        $('input[name="markdown"]').val(html);
    });

    var inlineAttachmentConfig = {
        uploadUrl: '/admin/upload/image/article',
        extraHeaders: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    };

    inlineAttachment.editors.codemirror4.attach(markdown.codemirror,
        inlineAttachmentConfig);
}

