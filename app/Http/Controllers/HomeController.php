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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::User();
        $expense = Expense::LeftJoin('customs','expenses.subject','=','customs.id')
                    ->select(DB::raw('sum(amount) as amount, customs.subject, customs.background_color, customs.hover_background_color'))
                    ->where('expenses.created_by',$user->id)
                    ->groupBy('expenses.subject')
                    ->get();                    
        // dd($expense);
        $subject = array();
        $amount = array();
        $bgColor = array();
        $hovBgColor = array();
        foreach ($expense as $key => $value) {
            array_push($amount, $value->amount);
            array_push($subject, $value->subject);
            array_push($bgColor, $value->background_color);
            array_push($hovBgColor, $value->hover_background_color);
        }

        // dd($subject);
        return view('dashboard',compact('expense','amount','subject','bgColor','hovBgColor'));
    }
}
