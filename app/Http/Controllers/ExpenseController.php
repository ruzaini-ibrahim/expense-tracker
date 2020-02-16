<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;

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

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addExpense(Request $request)
    {                
        $expense = new Expense;
        $expense->subject = $request->subject;
        $expense->comment = $request->comment;
        $expense->amount = $request->amount;
        $expense->spend_at = $request->dateSpend;
        $expense->created_by = Auth::User()->id;
        $expense->updated_by = Auth::User()->id;
        // dd($expense);
        $expense->save();
        
        return redirect()->back()->with('message','Success');
    }
    
    public function editExpense(Request $request)
    {            
        $expense = Expense::find($request->id);
        $expense->subject = $request->edit_subject;
        $expense->amount = $request->edit_amount;
        $expense->comment = $request->edit_comment;
        $expense->spend_at = $request->edit_dateSpend;
        $expense->created_by = Auth::User()->id;
        $expense->updated_by = Auth::User()->id;
        // dd($expense);
        $expense->save();
        
        return redirect()->back()->with('message','Success');
    }

     public function viewExpense(Request $request)
    {
        $expense = Expense::LeftJoin('customs','expenses.subject','=','customs.id')
                    ->select('expenses.id','customs.subject','expenses.comment','amount','expenses.created_at','spend_at as dateSpend')
                    ->orderby('expenses.created_at','desc');
                    

        if (request()->has('amount')) {
            if (!empty($request->amount)) {
                $expense = $expense->where('expenses.amount','like','%'.$request->amount.'%');
            }
        }

        if (request()->has('subject')) {
            if (!empty($request->subject)) {
                $expense = $expense->where('expenses.subject','like','%'.$request->subject.'%');
            }
        }

        if (request()->has('comment')) {
            if (!empty($request->comment)) {
                $expense = $expense->where('expenses.comment','like','%'.$request->comment.'%');
            }
        }

        if (request()->has('dateSpend')) {
            if (!empty($request->dateSpend)) {
                $expense = $expense->where('expenses.spend_at','like','%'.$request->dateSpend.'%');
            }
        }

        if (request()->has('spendFrom')) {
            if (!empty($request->spendFrom)) {
                $expense = $expense->where('expenses.spend_at','>=',$request->spendFrom);
            }
        }

        if (request()->has('spendTo')) {
            if (!empty($request->spendTo)) {
                $expense = $expense->where('expenses.spend_at','<=',$request->spendTo);
            }
        }

        if (request()->has('dateFrom')) {
            if (!empty($request->dateFrom)) {
                $expense = $expense->where(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"),'>=',$request->dateFrom);
            }
        }

        if (request()->has('dateTo')) {
            if (!empty($request->dateTo)) {
                $expense = $expense->where(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"),'<=',$request->dateTo);
            }
        }

        // dd($expense);
        return Datatables::of($expense)
        ->addIndexColumn()
        ->addColumn('subject', function ($model) {
        return '<input type="hidden" name="subject_'.$model->id.'" id="subject_'.$model->id.'" class="subject_'.$model->id.'" value="'.$model->subject.'">'.$model->subject;
        })
        ->addColumn('amount', function ($model) {
                return '<input type="hidden" name="amount_'.$model->id.'" id="amount_'.$model->id.'" class="amount_'.$model->id.'" value="'.$model->amount.'">'.$model->amount;
        })
        ->addColumn('comment', function ($model) {
                return '<input type="hidden" name="comment_'.$model->id.'" id="comment_'.$model->id.'" class="comment_'.$model->id.'" value="'.$model->comment.'">'.$model->comment;
        })
        ->addColumn('dateSpend', function ($model) {
                return '<input type="hidden" name="dateSpend_'.$model->id.'" id="dateSpend_'.$model->id.'" class="dateSpend_'.$model->id.'" value="'.$model->dateSpend.'">'.date(" d-m-Y, D", strtotime($model->dateSpend));
        })
        ->editColumn('created_at', function ($model) {
                return date("d-m-Y, D, h:i:sa", strtotime($model->created_at));
        })
        ->editColumn('action',function($model){
            $edit = '<a><button class="btn btn-success btn-xs btnEdit" name="btnEdit" id="btnEdit" data-target="#editNewExpense" data-toggle="modal" value="'.$model->id.'">Edit</button></a>';
            $delete = '<a class="btn btn-xs btn-danger btnDelete" href="'.url('expense/delete/'.$model->id).'" id="btnDelete" data-toggle="tooltip" data-original-title="Delete" data-style="zoom-out">Delete</a>';
            // return '<div class="btn-group" aria-label="Basic example" role="group">'.$detail.' '.$delete.'</div>' ;
            return  $edit.' '.$delete;
        })        
        ->escapeColumns([])
        ->make(true);
    }
    
    public function deleteExpense(Request $request, $id)
    {        
        DB::BeginTransaction();

        try{

            $expense = Expense::destroy($id);

            DB::commit();

        }catch(\Exception $e){

            DB::rollback();
        }
        
        return redirect()->back()->with('message','Success');
    }

}
