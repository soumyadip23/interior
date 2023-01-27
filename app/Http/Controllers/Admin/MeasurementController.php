<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\ItemContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\DeliveryBoy;
use App\Models\Quatation;
use App\Models\Lead;
use App\Contracts\CategoryContract;
use App\Models\LeadFeedback;
use Illuminate\Support\Facades\Session;
use App\Contracts\LeadContract;
use App\Contracts\QuatationContract;
use DB;
use PDF;
use Illuminate\Support\Facades\Storage;
use Mail;
class MeasurementController extends BaseController
{
    /**
     * @var LeadContract
     */
    protected $itemRepository;
    protected $categoryRepository;
    protected $leadRepository;
    protected $quatationRepository;


    /**
     * PageController constructor.
     * @param ItemContract $itemRepository
     */
    public function __construct(ItemContract $itemRepository,CategoryContract $categoryRepository,LeadContract $leadRepository,QuatationContract $quatationRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->categoryRepository = $categoryRepository;
        $this->leadRepository = $leadRepository;
        $this->quatationRepository = $quatationRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        //$items = $this->quatationRepository->listItems();

         $items = array();
        $this->setPageTitle('Measurement', 'List of all Measurements');
        return view('admin.measurement.index', compact('items'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Measurement', 'Create Measurement');
        $leads = $this->leadRepository->listLeads();
        $items = $this->itemRepository->getItems();

        return view('admin.measurement.create',compact('leads','items'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //dd($request);
        $this->validate($request, [
            'lead_id'      =>  'required',
            'expiry_date'     =>  'required',
            'quote_final_total'     =>  'required',
        ]);

        $params = $request->except('_token');
        
        $item = $this->quatationRepository->createQuatation($params);

        if (!$item) {
            return $this->responseRedirectBack('Error occurred while creating lead.', 'error', true, true);
        }
        return $this->responseRedirect('admin.quatation.index', 'Quatattion has been added successfully' ,'success',false, false);
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
        $item = $this->quatationRepository->detailsItem($id);


        //dd($item['quatationDetails']);

        foreach($item['quatationDetails'] as $qutVari){


            $item_id = $qutVari['item_variation_id'];

            $item_variation  = DB::select("select name,item_id from item_variations where id='$item_id'");

            if($item_variation){

               $qutVari->variation_name = $item_variation[0]->name; 
               $main_item_id =  $item_variation[0]->item_id; 
               $main_item = DB::select("select name from items where id='$main_item_id'");
               if($main_item){
                $qutVari->item_name = $main_item[0]->name; 
               }
            }

            //array_push($users,$user);
        }
       // dd($item);
        $this->setPageTitle('quatation', 'Quatation Details : '.$item['id']);
       return view('admin.quatation.details', compact('item'));
    }
    public function sendToCustomer($id)
    {
        $item = $this->quatationRepository->detailsItem($id);


       // dd($item['quatationDetails']);

        foreach($item['quatationDetails'] as $qutVari){

            $item_id = $qutVari['item_variation_id'];
            $item_variation  = DB::select("select name,item_id from item_variations where id='$item_id'");
            if($item_variation){
               $qutVari->variation_name = $item_variation[0]->name; 
               $main_item_id =  $item_variation[0]->item_id; 
               $main_item = DB::select("select name from items where id='$main_item_id'");
               if($main_item){
                $qutVari->item_name = $main_item[0]->name; 
               }
            }
        }

        
        $this->setPageTitle('quatation', 'Quatation Details : '.$item['id']);

        $item = json_decode(json_encode($item), true);
        $file_name = str_random(25) . '.pdf';

        //dd($item);

        $pdf = app('dompdf.wrapper');

        $contxt = stream_context_create([
            'ssl'=> [
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                        'allow_self_aigned' => TRUE,
                     ]
            ]);

        $pdf =  \PDF :: setOptions(['isHtml5ParserEnabled'=> true,'isRemoteEnabled'=>true]);
        $pdf->getDomPDF()->setHttpContext($contxt);


        $qut = Quatation::findOrFail($id); 

        $lead_id = $qut->lead_id; 
        $item['result'] = Lead::where('uid','=',$lead_id)->first();


        //dd($item);

        $customer_email = $item['result']['customer_email'];

        $pdf->loadView('admin.quatation.pdf', $item);

        $pdf->setPaper('A4','landscape');
        
        //->save(public_path('quatations/'.$file_name));

        return $pdf->download($file_name);

        die;


       


        //  An Email will be sent to this customer mail id along with the quatation pdf document as attachment


    //     $data = array('name'=>"Virat Gandhi",'customer_email'=>$customer_email,'file_name'=>$file_name);
    //   Mail::send('mail', $data, function($message) {
    //      $message->to('soumya.dev23@gmail.com' , 'Interior Design')->subject
    //         ('Quatattion Mail with Attachment');
    //      //$message->attach(public_path('quatations/'.$file_name));
    //      $message->from('xyz@gmail.com','Virat Gandhi');
    //   });

        $qut->status = 'sent';
        $qut->pdf_document = $file_name;


        $qut->save();

    
  
      // return view('admin.quatation.details', compact('item'));
    }
}
