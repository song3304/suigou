<{extends file="admin/extends/edit.block.tpl"}>

<{block "title"}>栏目<{/block}>
<{block "subtitle"}><{$_data.name}><{/block}>

<{block "name"}>navigation<{/block}>

<{block "fields"}>
<{include file="admin/navigation/fields.inc.tpl"}>
<{/block}>
