<{extends file="admin/extends/list.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>导航<{/block}>

<{block "name"}>navigation<{/block}>

<{block "filter"}>
<{include file="admin/navigation/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>名称</th>
<th>门店</th>
<th>排序</th>
<th>产品数量</th>
<{/block}>

<!-- 基本视图的Block -->

<{block "table-td-plus"}>
<td data-from="name">{{data}}</td>
<td data-from="shop" data-orderable="false">{{data.name}}</td>
<td data-from="porder">{{data}}</td>
<td data-from="product_cnt"><a href="<{'admin'|url}>/shop_product/?f[nid][in][]={{full.id}}">{{data}}</a></td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个导航：{{full.name}}吗？此操作会删除对应的导航！<{/block}>