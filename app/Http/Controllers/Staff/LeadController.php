<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Contracts\LeadContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\DeliveryBoy;
use App\Contracts\DeliveryBoyContract;
use App\Models\LeadFeedback;
use Illuminate\Support\Facades\Session;
use Auth;


class LeadController extends BaseController
{
    /**
     * @var LeadContract
     */
    protected $leadRepository;
    protected $deliveryBoyRepository;


    /**
     * PageController constructor.
     * @param LeadContract $leadRepository
     */
    public function __construct(LeadContract $leadRepository,DeliveryBoyContract $deliveryBoyRepository)
    {
        $this->leadRepository = $leadRepository;
        $this->deliveryBoyRepository = $deliveryBoyRepository;
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
       //echo auth()->user()->id;  die; 
        $leads = $this->leadRepository->listStaffLeads(auth()->user()->id);

       // dd($leads);

        $this->setPageTitle('Lead', 'List of all Leads');
        return view('staff.lead.index', compact('leads'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Lead', 'Create Lead');
        return view('staff.lead.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_name'      =>  'required|max:191',
            'customer_address'     =>  'required',
            'requirement'     =>  'required',
            'budget'     =>  'required',
        ]);

        $params = $request->except('_token');
        
        $lead = $this->leadRepository->createLead($params);

        if (!$lead) {
            return $this->responseRedirectBack('Error occurred while creating lead.', 'error', true, true);
        }
        return $this->responseRedirect('staff.lead.index', 'Lead has been added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetlead = $this->leadRepository->findLeadById($id);

        //dd($targetlead);

        $boys = $this->deliveryBoyRepository->getAllBoys();
        
        $this->setPageTitle('lead', 'Edit Lead : '.$targetlead->id);
        return view('staff.lead.edit', compact('targetlead','boys'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'customer_name'      =>  'required|max:191',
            'customer_address'     =>  'required',
            'requirement'     =>  'required',
            'budget'     =>  'required',
        ]);

        $params = $request->except('_token');

        $lead = $this->leadRepository->updateLead($params);

        if (!$lead) {
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
        $lead = $this->leadRepository->deleteLead($id);

        if (!$lead) {
            return $this->responseRedirectBack('Error occurred while deleting blog.', 'error', true, true);
        }
        return $this->responseRedirect('staff.lead.index', 'Lead has been deleted successfully' ,'success',false, false);
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
        $leads = $this->leadRepository->detailsLead($id);
        $lead = $leads[0];

        if($lead->assigned_to){
           $assigned_staff =  DeliveryBoy::where('id',$lead->assigned_to)->first();  
          // dd($assigned_staff);
        }

        $this->setPageTitle('lead', 'Lead Details : '.$lead->id);
        return view('staff.lead.details', compact('lead','assigned_staff'));
    }
    public function feedbacks($id)
    {
        $lead['lead_id'] = $id;
        $feedbacks  =  LeadFeedback::where('lead_id',$id)->get();  
        $this->setPageTitle('lead', 'Lead feedback Details : '.$id);
        //dd($lead);
        return view('staff.lead.feedbacks', compact('feedbacks','lead'));
    }
    public function feedbacksCreate($id)
    {
        $lead['lead_id'] = $id;
        $this->setPageTitle('lead feedback create', 'Create  Lead feedback(s) LeadID : '.$id);
        return view('staff.lead.feedback_create',compact('lead'));
    }
    public function feedbackStore(Request $request)
    {

        //dd($request);
        $this->validate($request, [
            'client_comment'      =>  'required'
        ]);

        $params = $request->except('_token');
        
        $feedback = $this->leadRepository->createFeedback($params);

        if (!$feedback) {
            return $this->responseRedirectBack('Error occurred while creating feedback.', 'error', true, true);
        }
        //$redirect_url = route('admin.leads.feedback', $params['lead_id']); 
       // Session::flash('success','Blog has been added successfully');
        //return $this->responseRedirect($redirect_url, 'Feedback has been added successfully' ,'success',false, false);
        return redirect()->route('staff.leads.feedback', $params['lead_id']);
    }
}
