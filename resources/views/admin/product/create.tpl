<{extends file="admin/extends/create.block.tpl"}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{include file="common/editor.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#cover_aids').uploader(undefined, undefined, undefined, undefined, 20);
var $editor_content = UE.getEditor('content1',$.ueditor_default_setting.simple);
<{/block}>

<{block "title"}>商品<{/block}>

<{block "name"}>product<{/block}>

<{block "fields"}>
<{include file="admin/product/fields.inc.tpl"}>
<{/block}>
