<{extends file="admin/extends/list.block.tpl"}>

<{block "title"}>门店<{/block}>

<{block "name"}>shop<{/block}>

<{block "filter"}>
<{include file="admin/shop/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>门店名</th>
<th>所属用户</th>
<th>地址</th>
<th>电话</th>
<th>经度</th>
<th>纬度</th>
<th>状态</th>
<{/block}>

<{block "table-td-plus"}>
<td data-from="name" data-orderable="false">{{data}}</td>
<td data-from="user" data-orderable="false">{{data.username}}</td>
<td data-from="full_address">{{data}}</td>
<td data-from="phone">{{data}}</td>
<td data-from="longitude">{{data}}</td>
<td data-from="latitude">{{data}}</td>
<td data-from="shop_status">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个门店：{{full.name}}吗？<{/block}>