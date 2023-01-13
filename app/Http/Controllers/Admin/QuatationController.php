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
use App\Contracts\LeadContract;


class QuatationController extends BaseController
{
    /**
     * @var LeadContract
     */
    protected $itemRepository;
    protected $categoryRepository;
    protected $leadRepository;


    /**
     * PageController constructor.
     * @param ItemContract $itemRepository
     */
    public function __construct(ItemContract $itemRepository,CategoryContract $categoryRepository,LeadContract $leadRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->categoryRepository = $categoryRepository;
        $this->leadRepository = $leadRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $items = $this->itemRepository->getItems();

       // dd($items);

        $this->setPageTitle('Quatation', 'List of all Quatations');
        return view('admin.quatation.index', compact('items'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Quatation', 'Create Quatation');
        $leads = $this->leadRepository->listLeads();
        $items = $this->itemRepository->getItems();

        return view('admin.quatation.create',compact('leads','items'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id'      =>  'required|max:191',
            'name'     =>  'required',
            'unit'     =>  'required',
            'price'     =>  'required',
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

        //dd($targetlead);

        $categories = $this->categoryRepository->listCategories();
        
        $this->setPageTitle('lead', 'Edit Lead : '.$targetitem->id);
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
}
