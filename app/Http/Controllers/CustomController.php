<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

use Auth;
use DB;
use Hash;
use Mail;
use Session;
use Storage;

use Carbon\Carbon;
use App\Expense;
use App\User;
use App\Custom;

class CustomController extends Controller
{

	public function addGroup(Request $request)
    {        
        // dd($request->all());
        $custom = new Custom;
        $custom->subject = $request->subject;
        $custom->background_color = $request->backgroundColor;
        $custom->hover_background_color = $request->hoverBackgroundColor;
        $custom->comment = $request->comment;
        $custom->created_by = Auth::User()->id;        
        $custom->save();
        
        return redirect()->back()->with('message','Success');
    }

    public function editGroup(Request $request)
    {                
        $custom = Custom::find($request->id);
        $custom->subject = $request->edit_subject;
        $custom->background_color = $request->edit_background_color;
        $custom->hover_background_color = $request->edit_hover_background_color;
        $custom->comment = $request->edit_comment;
        $custom->created_by = Auth::User()->id;        
        $custom->save();
        
        return redirect()->back()->with('message','Success');
    }

    public function viewGroup(Request $request)
    {
        $custom = Custom::select('id','subject','comment','background_color','created_at','hover_background_color');

        // if (request()->has('amount')) {
        //     if (!empty($request->amount)) {
        //         $custom = $custom->where('customs.amount','like','%'.$request->amount.'%');
        //     }
        // }       

        // dd($custom);
        return Datatables::of($custom)
        ->addIndexColumn()
        ->addColumn('subject', function ($model) {
        return '<input type="hidden" name="subject_'.$model->id.'" id="subject_'.$model->id.'" class="subject_'.$model->id.'" value="'.$model->subject.'">'.$model->subject;
        })
        ->addColumn('background_color', function ($model) {
                return '<input type="hidden" name="background_color_'.$model->id.'" id="background_color_'.$model->id.'" class="background_color_'.$model->id.'" value="'.$model->background_color.'">'.$model->background_color;
        })
        ->addColumn('hover_background_color', function ($model) {
                return '<input type="hidden" name="hover_background_color_'.$model->id.'" id="hover_background_color_'.$model->id.'" class="hover_background_color_'.$model->id.'" value="'.$model->hover_background_color.'">'.$model->hover_background_color;
        })
        ->addColumn('comment', function ($model) {
                return '<input type="hidden" name="comment_'.$model->id.'" id="comment_'.$model->id.'" class="comment_'.$model->id.'" value="'.$model->comment.'">'.$model->comment;
        })
        ->editColumn('created_at', function ($model) {
                return date("d-m-Y, D, h:i:sa", strtotime($model->created_at));
        })
        ->editColumn('action',function($model){
            $edit = '<a><button class="btn btn-success btn-xs btnEdit" name="btnEdit" id="btnEdit" data-target="#editNewExpense" data-toggle="modal" value="'.$model->id.'">Edit</button></a>';
            $delete = '<a class="btn btn-xs btn-danger btnDelete" href="'.url('custom/delete/'.$model->id).'" id="btnDelete" data-toggle="tooltip" data-original-title="Delete" data-style="zoom-out">Delete</a>';
            // return '<div class="btn-group" aria-label="Basic example" role="group">'.$detail.' '.$delete.'</div>' ;
            return  $edit.' '.$delete;
        })        
        ->escapeColumns([])
        ->make(true);
    }

    public function deleteGroup(Request $request, $id)
    {        
        DB::BeginTransaction();

        try{

            $custom = Custom::destroy($id);

            DB::commit();

        }catch(\Exception $e){

            DB::rollback();
        }
        
        return redirect()->back()->with('message','Success');
    }
}
