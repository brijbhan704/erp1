<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\User;
use Hash;
use Validator;
use Auth;
use App\Inventory;
use App\InventoryCategory;
use App\Tblproduct;
use DB;
use PDF;
class AddproductController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:inventory-list|expense-create|inventory-edit|inventory-delete', ['only' => ['index','show']]);
         $this->middleware('permission:inventory-create', ['only' => ['create','store']]);
         $this->middleware('permission:inventory-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:inventory-delete', ['only' => ['destroy']]);
    }
    
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {          
       try{ 
        $datas = DB::table('tbl_products')->orderBy('id', 'DESC')->paginate(5);
         //print_r($datas);die;
        return view('addproduct.index',compact('datas'))
                  ->with('i', ($request->input('page', 1) - 1) * 5);;
		    
        }catch(Exception $e){           
          abort(500, $e->message());         
        }
   }

//create new product
    public function create()
    {
        //echo 1;die;
            $boxID = DB::table('tbl_products')->select('boxID')
            ->orderBy('boxID', 'desc')
            ->get();
            if(sizeof($boxID) == 0){
            $invoice_boxID=55005;        
        }else{          
            $invoice_boxID= $boxID[0]->boxID+1;
            }
            //echo $invoice_boxID;die;
            $product_categories = InventoryCategory::select('id','name')->where('parent_id',0)->get();
          return view('addproduct.create', compact('product_categories','invoice_boxID'));
    }
    

//store products
    public function store(Request $request)
    {    
         try{
              $boxID = DB::table('tbl_products')->select('boxID')
              ->orderBy('boxID', 'desc')
              ->get();
              //echo $boxID;die;
              if(sizeof($boxID) == 0)
              $invoice_boxID=55005;        
          else          
              $invoice_boxID= $boxID[0]->boxID+1;
            $user_id = Auth::id();
            //echo $user_id;die;
              $addproduct = DB::table('tbl_products')->insert([
                        'user_id'               =>$user_id,
                        'boxID'           		  => $invoice_boxID, 
                        'price'             	  => $request->price, 
                        'product_name'          => $request->product_name,
                        'category_id'       	  => $request->message_list,
                        'subcategory_id'    	  => $request->subcategory,
                        'date'          		    => $request->date,
                        'quantity'           	  => $request->quantity,
                        'total_price'     	    => $request->total_price,
                        'product_invoice'       => $request->product_invoice                        
              ]);
              //echo $addproduct;die;
              return redirect()->route('addproduct.index')
                            ->withStatus($request->product_name. ' Product Add Successfully');
            }
            catch(Exception $e){            
            abort(500, $e->message());
          }
      }

   //show product
    public function show($id)
    {
      //echo 1;die;
        $product = Tblproduct::find($id);
        return view('addproduct.show',compact('product'));
    }

    //Edit Product\
     public function edit($id)
    {
        //echo $id;die;
        $Products = Tblproduct::find($id);
        $categories    =   InventoryCategory::select('id','name')->where('parent_id', '=', '0')->get(); 
        $subcategories    =   InventoryCategory::select('id','name')->where('parent_id', '=', $Products->category_id)->get(); 
            //echo '<pre>';print_r($subcategories);die;
        return view('addproduct.edit',compact('Products','categories','subcategories'));
    }

    //delete Product
      public function destroy($id)
      {
        Tblproduct::find($id)->delete();
        return redirect()->route('addproduct.index')
                            ->withStatus("Product Deleted successfully.");
      
      }

        //generate pdf
     public function pdfview(Request $request)
        {
        //echo 1;die;
        $items=DB::table('tbl_products')->orderBy('id', 'DESC')->get();
        view()->share('items',$items);
        if($request->has('download')){
            $pdf = PDF::loadView('pdfviewPO');
            return $pdf->download('pdfviewPO.pdf');
        }
        return view('pdfviewPO');
    }

    //update products
    public function update(Request $request, $id){
            $updateProduct = DB::table('tbl_products')
                  ->where('id', $id)
                  ->update([                           
                          'price'             => $request->price, 
                          'product_name'      => $request->product_name,
                          'category_id'       => $request->category,
                          'subcategory_id'    => $request->subcategory,
                          'date'              => $request->date,
                          'quantity'          => $request->quantity,
                          'serial_number'     => $request->serial_number               
                        ]); 
                return redirect()->route('addproduct.index')
                    ->withStatus($request->product_name. ' PO Order Updated Successfully');
            }

        }
