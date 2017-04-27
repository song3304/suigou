<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>地址<{/block}>

<{block "name"}>user_address<{/block}>

<{block "filter"}>
<{include file="admin/user_address/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>用户</th>
<th>收货人</th>
<th>地址</th>
<th>电话</th>
<th>邮编</th>
<{/block}>

<{block "table-td-plus"}>
<td data-from="user" data-orderable="false">{{data.username}}</td>
<td data-from="receiver">{{data}}</td>
<td data-from="full_address">{{data}}</td>
<td data-from="phone">{{data}}</td>
<td data-from="postal_code">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这项：{{full.full_address}}吗？<{/block}>