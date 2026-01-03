/**
 * WordPress Gutenberg エディタ用マーカー機能
 * テキストを選択してマーカーボタンを押すと、<span class="marker">...</span>で囲む
 */
(function() {
    'use strict';

    // WordPressの依存関係が読み込まれるまで待つ
    if (typeof wp === 'undefined' || typeof wp.richText === 'undefined' || typeof wp.element === 'undefined') {
        return;
    }

    var registerFormatType = wp.richText.registerFormatType;
    var RichTextToolbarButton = wp.blockEditor ? wp.blockEditor.RichTextToolbarButton : wp.editor.RichTextToolbarButton;
    var Element = wp.element;
    var el = Element.createElement;

    /**
     * マーカーフォーマットタイプを登録
     */
    registerFormatType('nekofreaks-univ/marker', {
        title: 'マーカー',
        tagName: 'span',
        className: 'marker',
        edit: function(props) {
            var isActive = props.isActive;
            var value = props.value;
            var onChange = props.onChange;

            return el(RichTextToolbarButton, {
                icon: 'editor-underline', // マーカー用のアイコン（dashicons）
                title: 'マーカー',
                onClick: function() {
                    onChange(
                        wp.richText.toggleFormat(value, {
                            type: 'nekofreaks-univ/marker',
                        })
                    );
                },
                isActive: isActive,
            });
        },
    });
})();

