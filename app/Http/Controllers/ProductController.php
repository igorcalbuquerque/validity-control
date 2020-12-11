<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ExpirationDate;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private $rules = [
        'barcode' => 'required|min:8|max:13',
        'description' => 'required|min:5|max:256',
        'company_id' => 'required|numeric|min:1',
    ];

    private $rulesToUpdate = [
        'barcode' => 'required|min:8|max:13',
        'description' => 'required|min:5|max:256',
        'company_id' => 'required|numeric|min:1',
    ];

    public function index(Request $request)
    {
        if(isset($request->company_id)){
            return response(Product::where('company_id', $request->company_id)->get()->toJson());            
        } else {
            return response()->json(['message' => 'Informe a empresa nos query params!'], 400);            
        }
    }
    
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), $this->rules);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
        } else {
            $product = Product::where('company_id', $request->company_id)
                              ->where('barcode', $request->barcode)
                              ->get()->first();
                              
            if(isset($product)){
                return response()->json(['message' => 'bacorde already exists.'], 400);
            } else {
                Product::create($request->all());
                return response()->json(['message' => 'Product created!']);                
            }
        }
    }

    public function generalSearch(Request $request)
    {
        $search = $request->search;
        $user = Auth::user();

        $products = Product::orWhere('barcode', 'like', "%$search%")
                           ->orWhere('description', 'like', "%$search%")
                           ->orWhereJsonContains('expiration_dates', [$search])
                           ->where('company_id', $user->company->id);
        
        $params = [
            'user' => $user,
            'products' => $products->paginate(10),
            'searchData' => $request->except('_token'),
        ];

        return view('home/index', $params);
    }

    public function addDate(Request $request, $id)
    {
        $product = Product::find($id);
        $date = Carbon::parse($request->date)->format('d-m-Y');

        $array = $product->expiration_dates;
        $array[] = ['date' => $date, 'amount' => $request->amount];
        $product->expiration_dates = $array;
        
        $product->save();

        return redirect()->route('home.index')->with('success', 'Data adicionada!');
    }

    public function removeDate(Request $request, $id)
    {
        $date = ExpirationDate::find($id);
        $date->delete();

        return redirect()->route('home.index')->with('success', 'Data removida com sucesso!');
    }

    public function show($id){
        $product = Product::find($id);

        if(isset($product)) {
            return response($product->first()->toJson());
        } else {
            return response()->json(['message' => 'Product not found!'], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if(isset($product)) {
            $validation = Validator::make($request->all(), $this->rulesToUpdate);

            if($validation->fails()){
                return back()->with('errors', $validation->errors())->withInput();
            } else {
                $product->update($request->all());
                return back()->with('success', 'Produto atualizado!')->withInput();
            }
        } else {
            return back()->with('error', 'Product not found!')->withInput();
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if(isset($product)) {
            $product->delete();
            return back()->with('success', 'Produto deletado!');
        } else {
            return back()->with('error', 'Produto não encontrado!');
        }
    }
}