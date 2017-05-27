<{extends file="admin/extends/create.block.tpl"}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{include file="common/editor.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#cover_aids').uploader(undefined, undefined, undefined, undefined, 20);
var $editor_content = UE.getEditor('content1',$.ueditor_default_setting.simple);
<{/block}>

<{block "title"}>导航商品<{/block}>

<{block "name"}>shop_product<{/block}>

<{block "fields"}>
<{include file="admin/shop_product/fields.inc.tpl"}>
<{/block}>
