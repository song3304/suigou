<{extends file="admin/extends/create.block.tpl"}>

<{block "head-plus"}>
<script src="<{'static/js/DatePicker/WdatePicker.js'|url}>"></script>
<{include file="common/uploader.inc.tpl"}>
<{/block}>

<{block "inline-script-plus"}>
$('#avatar_aid').uploader();
<{/block}>

<{block "title"}>微信用户<{/block}>

<{block "name"}>wechat/user<{/block}>

<{block "fields"}>
<{include file="admin/wechat/user/fields.inc.tpl"}>
<{/block}>
