<{extends file="admin/extends/list.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>导航商品<{/block}>

<{block "name"}>shop_product<{/block}>

<{block "table-th-plus"}>
<th>门店</th>
<th>导航</th>
<th>商品</th>
<th>排序</th>
<{/block}>

<!-- 基本视图的Block -->

<{block "table-td-plus"}>
<td data-from="shop" data-orderable="false">{{data.name}}</td>
<td data-from="navigation" data-orderable="false">{{data.name}}</td>
<td data-from="product" data-orderable="false">{{data.title}}</td>
<td data-from="porder">{{data}}</td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除导航({{full.navigation.name}})下这个商品：{{full.product.name}}吗？此操作会删除对应的商品！<{/block}>