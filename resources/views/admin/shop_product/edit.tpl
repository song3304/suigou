<{extends file="admin/extends/edit.block.tpl"}>

<{block "title"}>导航商品<{/block}>
<{block "subtitle"}><{$_data.navigation.name}>-<{$_data.product.title}><{/block}>

<{block "name"}>shop_product<{/block}>

<{block "fields"}>
<{include file="admin/shop_product/fields.inc.tpl"}>
<{/block}>
