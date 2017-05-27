<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Addons\Core\Controllers\ApiTrait;
use DB;
use App\ShopProduct;

class ShopProductController extends Controller
{
	use ApiTrait;
	//public $RESTful_permission = 'product';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$shop_product = new ShopProduct;
		$size = $request->input('size') ?: config('size.models.'.$shop_product->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('admin.shop_product.list');
	}

	public function data(Request $request)
	{
		$shop_product = new ShopProduct;
		$builder = $shop_product->newQuery()->with(['shop','navigation','product']);
		
		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder->orderBy('porder','desc'), null, ['shop_products.*']);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$shop_product = new ShopProduct;
		$builder = $shop_product->newQuery()->with(['shop','navigation','product']);
		$size = $request->input('size') ?: config('size.export', 1000);
		
		$data = $this->_getExport($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		         $value['shop_name'] =  $value->shop->name;
		         $value['navigation_name'] =  $value->navigation->name;
		         $value['product_name'] =  $value->title->name;
		    }
		}, ['products.*']);
		return $this->export($data);
	}

	public function edit($id)
	{
		$shop_product = ShopProduct::with(['shop','navigation','product'])->find($id);
		if (empty($shop_product))
			return $this->failure_noexists();

		$keys = 'porder';
		$this->_validates = $this->getScriptValidate('shop-product.store', $keys);
		$this->_data = $shop_product;
		return $this->view('admin.shop_product.edit');
	}

	public function update(Request $request, $id)
	{
		$shop_product = ShopProduct::find($id);
		if (empty($shop_product))
			return $this->failure_noexists();

		$keys = 'porder';
		$data = $this->autoValidate($request, 'shop-product.store', $keys, $shop_product);
	
		$shop_product->update($data);
		return $this->success();
	}

	public function destroy(Request $request,$id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v){
		    ShopProduct::destroy($id);
		}
		return $this->success('', count($id) > 5, compact('id'));
	}
}
