<?php

namespace App\Http\Controllers;

use App\StorePoRecord;
use App\Inventory;
use App\InventoryCategory;
use App\User;
use Illuminate\Http\Request;
use App\Classes\UploadFile;
use Log;
use Validator;
use App\Category;
use App\Currency;
use App\Attachment;
use Auth;
use Image;
use URL;
use Illuminate\Support\Collection;
use DB;
use PDF;
use App\Exports\InventoryExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\TblProduct;
use App\Notifications\ERPNotification;

class InventoryController extends Controller
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
		      $inven = [];
              $datas = Inventory::orderBy('id', 'DESC')->paginate(5);
                
           //echo '<pre>'; print_r($datas); die;
        $product_categories = InventoryCategory::select('id','name')->where('parent_id',0)->get();
              return view('inventories.index',compact('datas','product_categories'))
                  ->with('i', ($request->input('page', 1) - 1) * 5);
           
        }catch(Exception $e){
            
          abort(500, $e->message());
            
        }
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    
    //Create New Expense
     public function create()
    {   
         try{
            
          $product_categories = InventoryCategory::select('id','name')->where('parent_id',0)->get();
           
            $currencies   = InventoryCategory::select('id','name')->where('parent_id', '=', '1')->get(); 
            //echo '<pre>'; print_r($currencies);die;
            return view('inventories.create',compact('product_categories', 'currencies'));
        
         }
         catch(Exception $e){
            
             abort(500, $e->message());
        }
        
    }
    
    //Getting all subcategory name according to related parent id
    
    public function subcategorylist($parent_id)
    {   //echo $parent_id; die;
        $states = DB::table("inventory_category")
                    ->where("parent_id",$parent_id)
                    ->pluck("name","id")->all();
        //echo '<pre>'; print_r($states);die;
        return response()->json($states);
    }
    
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {    
       
       try{
           ;
            $image  = $request->file('image');
            foreach($image as $files) {
		   
            $image = str_replace('data:image/png;base64,', '', $files);
            $image = str_replace(' ', '+', $image);
            $name = uniqid().'.'.'png';
            Image::make($files)->save(public_path('/images/inventory/').$name);
            $imagePath = URL('/images/inventory/'.$name);
            $user_id = Auth::user()->id;
           // echo $imagePath; die;
        }
           
            $inventory = Inventory::insert([
                                        
                        'user_id'           => $user_id, 
                        'price'             => $request->price, 
                        'item_name'         => $request->item_name,
                        'category_id'       => $request->category,
                        'subcategory_id'    => $request->subcategory,
                        'start_time'        => $request->start_time,
                        'end_time'          => $request->end_time,
                        'quantity'          => $request->quantity,
                        'current_stock'     =>$request->current_stock,
                        'serial_number'     => $request->serial_number,
                        'description'       => $request->description,
                        'item_image'        => $imagePath
            ]);

             return redirect()->route('inventory.index')
                            ->withStatus($request->item_name. ' Inventory Generated Successfully');
        }
        catch(Exception $e){
            
             abort(500, $e->message());
        }
   }
    
   
   /**
     * Show the form for the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try{
        $inventory = Inventory::find($id);
         // echo'<pre>'; print_r($inventory);die;
        return view('inventories.show', compact('inventory'));

      }catch(Exception $e){   
        abort(500, $e->message());
          
      }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      try{
            
            $inventory     =   Inventory::find($id);
            $categories    =   InventoryCategory::select('id','name')->where('parent_id', '=', '0')->get(); 
            $subcategories    =   InventoryCategory::select('id','name')->where('parent_id', '=', $inventory->category_id)->get(); 
            //echo '<pre>';print_r($subcategories);die;
            return view('inventories.edit', compact('inventory', 'categories', 'subcategories'));

        }catch(Exception $e){
          
            abort(500, $e->message());
          
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    { 
        
      try{  
               
              $this->validate($request, [
                    'item_name'         => 'required|max:255',
                    'price'             => 'required',
                    'category'          => 'required',
                    'subcategory'       => 'required',
                    'start_time'        => 'required',
                    'end_time'          => 'required',
                    'quantity'          => 'required',
                    'serial_number'     => 'required',
                    'image'             => 'mimes:jpeg,bmp,png',

                ]);
                $files  = $request->file('image');
              if(!$files){

                    $imagePath = Inventory::where('id', $id)->pluck('item_image')->all();
                  $imagePath  = $imagePath[0];
                    //print_r($imagePath); die;
               }else{
                 
                    $files  = $request->file('image');
		            $image = str_replace('data:image/png;base64,', '', $files);
                    $image = str_replace(' ', '+', $image);
                    $name = uniqid().'.'.'png';
                    $path = public_path('/images/inventory/'. $name);
                    Image::make($files)->resize(468, 249)->save($path);
                    $imagePath = URL::to('/images/inventory/'.$name);
                  
              }

            $user_id = Auth::user()->id;
            $inventory = DB::table('inventories')
                            ->where('id', $id)
                            ->update([
                                    'user_id'           => $user_id, 
                                    'price'             => $request->price, 
                                    'item_name'         => $request->item_name,
                                    'category_id'       => $request->category,
                                    'subcategory_id'    => $request->subcategory,
                                    'start_time'        => $request->start_time,
                                    'end_time'          => $request->end_time,
                                    'quantity'          => $request->quantity,
                                    'serial_number'     => $request->serial_number,
                                    'description'       => $request->description,
                                    'item_image'        => $imagePath
                            ]);
            
                return redirect()->route('inventory.index')
                    ->withStatus($request->item_name. ' Inventory Updated Successfully');
          
              }catch(Exception $e){
                abort(500, $e->message());
              }

            }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\User  $user
    * @return \Illuminate\Http\Response
    */
   public function destroy(Request $request, $id)
   {
     try{
       $obj = new Inventory();
       $obj = $obj->findOrFail($id);
       //print_r($userData); die;
       if($obj->count()>0){
         $obj->delete();
         $request->session()->flash('message.level', 'success');
         $request->session()->flash('message.content', 'Inventory Deleted Successfully');
         return redirect()->action('InventoryController@index');
       }else{
         $request->session()->flash('message.level', 'error');
         $request->session()->flash('message.content', 'Inventory not found');
         return redirect()->action('InventoryController@index');
       }
       
     }catch(Exception $e){
       abort(500, $e->message());
     }
   }

    //generate pdf
     public function pdfview(Request $request)
        {
        //echo 1;die;
        $items=Inventory::orderBy('id', 'DESC')->get();
        view()->share('items',$items);

        if($request->has('download')){
            $pdf = PDF::loadView('pdfviewinventory');
            return $pdf->download('pdfviewinventory.pdf');
        }
        return view('pdfviewinventory');
    }

     //csv export
    public function export() 
    {
        return Excel::download(new InventoryExport, 'inventory.xlsx');
    }

    //update product 
    public function updateproduct(Request $request){ 
        $invoice = $request->invoice; 
        $id = $request->ID;
        $qty = $request->qty;
        $symbol = $request->symbol;
        $chk = DB::table('tbl_products')->where('boxID',$invoice)->pluck('user_id')->first();
      // echo $chk;die;
        if($chk==true){
             $updateproduct = DB::table('store_po_records')->insert([
                'invoice_id'        =>$request->invoice,
                'user_id'           =>$chk,
                'product_name'      =>$request->product_name,
                'comment'           =>$request->comment, 
                'qty'               =>$request->qty,
                'category_id'       =>$request->message_list,
                'subcategory_id'    =>$request->subcategory,
                'symbol'            =>$request->symbol
            ]);

        if ($symbol=='+') {
        $update = DB::update("UPDATE inventories SET current_stock = current_stock + $qty  WHERE id = $id");
        return redirect()->route('inventory.index')->withStatus('Current Stock Updated Successfully');
                
        }else {
        $update = DB::update("UPDATE inventories SET current_stock = current_stock - $qty  WHERE id = $id");
        return redirect()->route('inventory.index')->withStatus('Current Stock Updated Successfully');
        }

        }else{
        return redirect()->route('inventory.index')->withStatus('InvoiceID does not match Our Records.');
        }
    }
    //view products

     public function view_supplyer($ID) {
        //echo $ID;die;
        $supplyer = Inventory::find($ID);
        return $supplyer;
    }

    public function showdetails(Request $request){
         try{ 
                $datas = StorePoRecord::orderBy('id', 'DESC')->paginate(5);           
               // echo '<pre>'; print_r($datas); die;      
                return view('showdetails.index',compact('datas'))
                  ->with('i', ($request->input('page', 1) - 1) * 5);     
        }catch(Exception $e){
            
          abort(500, $e->message());
            
        }
    }

//show PO Details
    public function showpodetails(Request $request,$id){
             try{
            $tblProduct = StorePoRecord::find($id);
             //echo'<pre>'; print_r($tblProduct);die;
            return view('showdetails.show', compact('tblProduct'));
            }catch(Exception $e){     
            abort(500, $e->message());       
                    }

                }


    
}
