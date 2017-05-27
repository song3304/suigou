<{extends file="admin/extends/edit.block.tpl"}>

<{block "head-plus"}>
<{include file="common/uploader.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#cover').uploader(undefined, undefined, undefined, undefined, 1);
<{/block}>

<{block "title"}>Banner<{/block}>
<{block "subtitle"}><{$_data.title}><{/block}>

<{block "name"}>banner<{/block}>

<{block "fields"}>
<{include file="admin/banner/fields.inc.tpl"}>
<{/block}>
