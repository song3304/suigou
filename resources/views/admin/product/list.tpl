<{extends file="admin/extends/list.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>商品<{/block}>

<{block "name"}>product<{/block}>

<{block "filter"}>
<{include file="admin/product/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>名称</th>
<th>门店</th>
<th>市场价</th>
<th>优惠价</th>
<th>库存</th>
<th>状态</th>
<{/block}>

<!-- 基本视图的Block -->

<{block "table-td-plus"}>
<td data-from="title">{{data}}</td>
<td data-from="shop" data-orderable="false">{{data.name}}</td>
<td data-from="market_price">{{data}}</td>
<td data-from="price">{{data}}</td>
<td data-from="count">{{data}}</td>
<td data-from=""  data-orderable="false"><a href='<{''|url}>/<{block "namespace"}>admin<{/block}>/product/toggle/{{full.id}}'>{{if full.status==1}}√{{else}}x{{/if}}</a></td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个商品：{{full.title}}吗？此操作会删除对应的商品！<{/block}>