<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Classes\UploadFile;
use Log;
use Validator;
use DB;
use PDF;
use App\Exports\CategoryExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','show']]);
         $this->middleware('permission:category-create', ['only' => ['create','store']]);
         $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }
    
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
                 
       try{
            $data = Category::orderBy('id','DESC')->paginate(5);
            return view('categories.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
           
       }catch(Exception $e){

         abort(500, $e->message());

       }
   }

   

   public function create(Request $request){
       
       return view('categories.create');
   }
    
   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function add(Request $request)
   {
      // echo 1; die;
     $response = ['success'=>0,"message"=>"","data"=>[]];
     try{
       Log::info('create new user profile for user:');
       if($request->isMethod('post')){

        $validator = Validator::make($request->all(), [
          //'name' => 'required|string',
          //'punchline' => 'required|string|max:255',
          //'description' => 'required|string|'            
        ]);
        
        //$validator->errors()
        if($validator->fails()){
          $request->session()->flash('message.level', 'error');
          $request->session()->flash('message.content', $validator->errors());
          return redirect('category');
          
        }


        //print_r($_FILES); die;
        
        $obj = new Category();       
        $obj->category_name = $request->input('name');
        //$obj->fun_fact = $request->input('fun_fact');
        //$obj->punchline = $request->input('punchline');
        //$obj->type = $request->input('type');
        //$obj->description = $request->input('description');       
        //$obj->tower_id = 1;       
        /*if(isset($_FILES['file']['name'])){
          $upload_handler = new UploadFile();
          $path = public_path('uploads/amenities'); 
          $data = $upload_handler->upload($path,'amenities');
          $res = json_decode($data);
          if($res->status=='ok'){
            $obj->image = $res->path;
            $obj->file_path = $res->img_path;
          }else{
            $request->session()->flash('message.level', 'error');
            $request->session()->flash('message.content', $res->message);
            return redirect('amenities/add');
          }
        }*/
        
        if($obj->save()){
          $request->session()->flash('message.level', 'success');
          $request->session()->flash('message.content', '"'.$request->input('name').'" Added Successfully');
          return redirect('category');
        }else{
          $request->session()->flash('message.level', 'error');
          $request->session()->flash('message.content', '"'.$request->input('name').'" not added');
          return redirect('category');
        }
       }else{
        return view('categories.add', []); 
       }
              
     }catch(Exception $e){
       Log::info('floor add exception:='.$e->message());
       $response['message'] = 'Opps! Somthing went wrong';
       echo json_encode($response);
       abort(500, $e->message());
     }
   }    

    
    /**
    * STore the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        try{
             $this->validate($request, [
                'name' => 'required'
            ]);

            $obj = new Category();       
            $obj->category_name = ucfirst($request->input('name'));  
            $obj->save();
            
            return redirect()->route('category.index')
                            ->withStatus(__('Category Created Successfully'));
        }
        catch(Exception $e){
            
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
          
        $obj = new Category();
        $category = $obj->findOrFail($id);
        return view('categories.edit', compact('category'));

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
          
            $obj = new Category();
            $obj = $obj->findOrFail($id);
            $obj->category_name = $request->input('category_name');
            $obj->save();
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', '"'.$request->input('category_name').'" Category Updated Successfully');
            return redirect('category');
          
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
           $obj = new Category();
           $obj = $obj->findOrFail($id);
           //print_r($userData); die;
           if($obj->count()>0){
                 $obj->delete();
                 //AmenityGallery::where('amenity_id',$id)->delete();
                 $request->session()->flash('message.level', 'success');
                 $request->session()->flash('message.content', 'Category Deleted Successfully');
                 return redirect()->route('category.index');

           }else{
           
                 $request->session()->flash('message.level', 'error');
                 $request->session()->flash('message.content', 'Category not found');
                 return redirect()->route('category.index');
       }
       
     }catch(Exception $e){
       abort(500, $e->message());
     }

     //return view('users.index', ['users' => $users->getAllUser()]);
   }

    //generate pdf
     public function pdfview(Request $request)
      {
        //echo 1;die;
        $items = DB::table("categories")->get();
        view()->share('items',$items);
//echo $items;die;

        if($request->has('download')){
            $pdf = PDF::loadView('pdfviewcategory');
            return $pdf->download('pdfviewcategory.pdf');
        }
        return view('pdfviewcategory');
    }

    //csv export
    public function export() 
    {
        //echo 1;die;
        return Excel::download(new CategoryExport, 'category.xlsx');
    }
}
