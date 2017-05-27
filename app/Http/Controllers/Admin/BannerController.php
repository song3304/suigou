<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Banner;
use Addons\Core\Controllers\ApiTrait;
use DB;

class BannerController extends Controller
{
    use ApiTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {       
        $banner = new Banner();
        $size = $request->input('size') ?: config('size.models.'.$banner->getTable(), config('size.common'));
        //view's variant
        $this->_size = $size;
        $this->_filters = $this->_getFilters($request);
        $this->_queries = $this->_getQueries($request);
        return $this->view('admin.banner.list');
    }

    public function data(Request $request)
    {
        $banner = new Banner();
        $builder = $banner->newQuery()->with(['shop','navigation','product']);
        
        $total = $this->_getCount($request, $builder, FALSE);
        $data = $this->_getData($request, $builder, null, ['banners.*']);
        $data['recordsTotal'] = $total; //不带 f q 条件的总数
        $data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
        return $this->api($data);       
    }
    
    public function export(Request $request)
    {
        $banner = new Banner();
        $builder = $banner->newQuery()->with(['shop','navigation','product']);
        $size = $request->input('size') ?: config('size.export', 1000);
    
        $data = $this->_getExport($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		      $value['product_name'] =  $value->product->title;
		      $value['navigation_name'] =  $value->navigation->name;
		      $value['shop_name'] =  $value->shop->name;
		    }
		}, ['banners.*']);
        return $this->export($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $keys = 'title,url,cover,nid,sid,porder,status,pid';
        $this->_data = [];
        $this->_validates = $this->getScriptValidate('banner.store', $keys);
        return $this->view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $keys = 'title,url,cover,nid,sid,porder,status,pid';
        $data = $this->autoValidate($request, 'banner.store', $keys);
        if(Banner::where('sid',$data['sid'])->where('nid',$data['nid'])->count()>config('size.banner_max_cnt')){
            return $this->failure('banner.max_banner_cnt',url('admin/banner'));
        }else{
           Banner::create($data);
           return $this->success('', url('admin/banner'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::find($id);
        if (empty($banner))
            return $this->failure_noexists();

        $keys = 'title,url,cover,nid,sid,porder,status,pid';
        $this->_validates = $this->getScriptValidate('banner.store', $keys);
        $this->_data = $banner;
        return $this->view('admin.banner.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);
        if (empty($banner))
            return $this->failure_noexists();

        $keys = 'title,url,cover,nid,sid,porder,status,pid';
        $data = $this->autoValidate($request, 'banner.store', $keys, $banner);
        $data['pid'] = !empty($data['url'])?0:$data['pid'];
        $data['url'] = !empty($data['pid'])?0:$data['url'];
        $banner->update($data);
        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        empty($id) && !empty($request->input('id')) && $id = $request->input('id');
        $id = (array) $id;

        foreach ($id as $v)
            $banner = Banner::destroy($v);
        return $this->success('');
    }
    
    public function toggle($id){
        $banner = Banner::find($id);
        if (empty($banner))
            return $this->failure_noexists();
    
        $banner->update(['status'=>$banner->status?0:1]);
        return $this->success('', url('admin/banner'));
    }
}
