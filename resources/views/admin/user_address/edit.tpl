<{extends file="admin/extends/edit.block.tpl"}>

<{block "title"}>地址<{/block}>
<{block "subtitle"}><{$_data.receiver}>-<{$_data.full_address}><{/block}>

<{block "name"}>user_address<{/block}>

<{block "fields"}>
<{include file="admin/user_address/fields.inc.tpl"}>
<{/block}>
