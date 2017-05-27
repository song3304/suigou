<{extends file="admin/extends/list.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>Banner<{/block}>

<{block "name"}>banner<{/block}>

<{block "filter"}>
<{include file="admin/banner/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>标题</th>
<th>图片</th>
<th>导航</th>
<th>门店</th>
<th>链接</th>
<th>排序</th>
<th>状态</th>
<{/block}>

<{block "table-td-plus"}>
<td data-from="title">{{data}}</td>
<td data-from="cover" data-orderable="false">
	<img src="<{''|attachment}>?id={{data}}&width=80&height=80" alt="avatar" class="img-rounded">
</td>
<td data-from="navigation">{{data.name}}</td>
<td data-from="shop">{{data.name}}</td>
<td data-from="" data-orderable="false">{{if full.pid==0}}<a href='{{full.url}}'>{{full.url}}</a>{{else}}<a href='<{'m/product/detail'|url}>?pid={{full.pid}}'>{{full.product.title}}</a>{{/if}}</td>
<td data-from="porder">{{data}}</td>
<td data-from=""  data-orderable="false"><a href='<{''|url}>/<{block "namespace"}>admin<{/block}>/banner/toggle/{{full.id}}'>{{if full.status==1}}√{{else}}x{{/if}}</a></td>
<{/block}>

<{block "table-td-options-delete-confirm"}>您确定删除这个banner：{{full.title}}吗？<{/block}>