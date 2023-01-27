<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\ItemContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\DeliveryBoy;
use App\Contracts\CategoryContract;
use App\Models\LeadFeedback;
use Illuminate\Support\Facades\Session;
use App\Models\Item;
use App\Models\Category;
use App\Models\ItemVariation;
use Illuminate\Support\Facades\Validator;


class ItemController extends BaseController
{
    /**
     * @var LeadContract
     */
    protected $itemRepository;
    protected $categoryRepository;


    /**
     * PageController constructor.
     * @param ItemContract $itemRepository
     */
    public function __construct(ItemContract $itemRepository,CategoryContract $categoryRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->categoryRepository = $categoryRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $items = $this->itemRepository->getItems();

       // dd($items);

        $this->setPageTitle('Item', 'List of all Items');
        return view('admin.item.index', compact('items'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Item', 'Create Item');
        $categories = Category::where('parent_id', '=', 0)->get();
        $allCategories = Category::pluck('title','id')->all();
        //dd($allCategories);
       // $categories = $this->categoryRepository->listCategories();
        //dd($cats);
        return view('admin.item.create',compact('categories','allCategories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
       $res =  $this->validate($request, [
            'category_id'      =>  'required',
            'name'     =>  'required',
        ]);
       
        $params = $request->except('_token');

        $item = $this->itemRepository->createItem($params);

        if (!$item) {
            return $this->responseRedirectBack('Error occurred while creating lead.', 'error', true, true);
        }
        return $this->responseRedirect('admin.item.index', 'Lead has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetitem = $this->itemRepository->findItemById($id);

        //dd($targetitem);

        $categories = Category::where('parent_id', '=', 0)->get();
        
        $this->setPageTitle('Item', 'Edit Item : '.$targetitem->name);
        return view('admin.item.edit', compact('targetitem','categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'category_id'      =>  'required|max:191',
            'name'     =>  'required',
            'unit'     =>  'required',
            'price'     =>  'required',
        ]);

        $params = $request->except('_token');

        $item = $this->itemRepository->updateItem($params);

        if (!$item) {
            return $this->responseRedirectBack('Error occurred while updating lead.', 'error', true, true);
        }
        return $this->responseRedirectBack('Lead  has been updated successfully' ,'success',false, false);
    }

    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $boy = $this->itemRepository->updateItemStatus($params);

        if ($boy) {
            return response()->json(array('message'=>'Delivery boy status successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $item = $this->itemRepository->deleteItem($id);

        if (!$item) {
            return $this->responseRedirectBack('Error occurred while deleting Item.', 'error', true, true);
        }
        return $this->responseRedirect('admin.item.index', 'Item has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $item = $this->itemRepository->detailsItem($id);
     
        $this->setPageTitle('item', 'Lead Details : '.$item->id);
        return view('admin.item.details', compact('item'));
    }
    public function fetchPrice(Request $request){

        $params = $request->except('_token');

        $item = ItemVariation::where('id',$params['itemID'])->first();

        //dd($params['itemID']);

        if ($item) {
            return response()->json(array('message'=>$item['price'] ));
        }
    }

    public function fetchVariations(Request $request){

        $params = $request->except('_token');

        $item = ItemVariation::where('item_id',$params['itemID'])->get();

        //dd($params['itemID']);

        if ($item) {
            return response()->json(array('message'=>$item ));
        }
    }
}
