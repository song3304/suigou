<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Addons\Core\Controllers\ApiTrait;
use DB;
use App\ShopProduct;

class ProductController extends Controller
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
		$product = new Product;
		$size = $request->input('size') ?: config('size.models.'.$product->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('admin.product.list');
	}

	public function data(Request $request)
	{
		$product = new Product;
		$builder = $product->newQuery()->with(['shop','navigations']);
		
		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder, function(&$datalist){
		    foreach ($datalist as &$value){
		        $value['navigation_tags'] =  join(',', $value->navigations->pluck('name')->all());
		    }
		}, ['products.*']);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$product = new Product;
		$builder = $product->newQuery()->with(['shop','navigations']);
		$size = $request->input('size') ?: config('size.export', 1000);
		
		$data = $this->_getExport($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		         $value['navigation_tags'] =  join(',', $value->navigations->pluck('name')->all());
		    }
		}, ['products.*']);
		return $this->export($data);
	}

	public function create()
	{
		$keys = 'title,content,sid,cover_aids,express_price,market_price,price,count,keywords,description,nids';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('product.store', $keys);
		return $this->view('admin.product.create');
	}

	public function store(Request $request)
	{
		$keys = 'title,content,sid,cover_aids,express_price,market_price,price,count,keywords,description,nids';
		$data = $this->autoValidate($request, 'product.store', $keys);
		$cover_aids = $data['cover_aids'];unset($data['cover_aids']);
		$nids = $data['nids'];unset($data['nids']);//导航id

		$product = Product::create($data);
		foreach ($cover_aids as $value){
			$product->covers()->create(['cover_aid' => $value]);
		}
		
		$attach_data = [];
		array_walk($nids, function($value,$key) use(&$attach_data,$data){
		    $attach_data[$value]=['created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"),'sid'=>intval($data['sid']),'porder'=>0];
		});
		$product->navigations()->attach($attach_data);
		return $this->success('', url('admin/product'));
	}

	public function edit($id)
	{
		$product = Product::with(['shop','navigations','covers'])->find($id);
		if (empty($product))
			return $this->failure_noexists();

		$keys = 'title,content,sid,cover_aids,express_price,market_price,price,count,keywords,description,nids';
		$this->_validates = $this->getScriptValidate('product.store', $keys);
		$this->_data = $product;
		return $this->view('admin.product.edit');
	}

	public function update(Request $request, $id)
	{
		$product = Product::with(['shop','navigations'])->find($id);
		if (empty($product))
			return $this->failure_noexists();

		$keys = 'title,content,sid,cover_aids,express_price,market_price,price,count,keywords,description,nids';
		$data = $this->autoValidate($request, 'product.store', $keys, $product);
		$cover_aids = $data['cover_aids'];unset($data['cover_aids']);
		
		$nids = $data['nids'];unset($data['nids']);//导航id
		
		$product->update($data);
		$product->covers()->delete();
		foreach ($cover_aids as $value){
			$product->covers()->create(['cover_aid' => $value]);
		}
		
		$attach_data = [];
		array_walk($nids, function($value,$key) use(&$attach_data,$data){
		    $attach_data[$value]=['created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"),'sid'=>intval($data['sid'])];
		});
		$product->navigations()->sync($attach_data);
		return $this->success();
	}

	public function destroy(Request $request,$id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v){
		    $product = Product::find($id);
		    $product->covers()->delete();
		    $product->navigations()->detach();
		    Product::destroy($id);
		}
		return $this->success('', count($id) > 5, compact('id'));
	}
	
	public function toggle($id){
	    $product = Product::find($id);
	    if (empty($product))
	        return $this->failure_noexists();
	
	    $product->update(['status'=>$product->status?0:1]);
	    return $this->success('', url('admin/product'));
	}
}
