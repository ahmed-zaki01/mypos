<?php

namespace App\Http\Controllers\Dashboard;

use App\Cat;
use App\CatTranslation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CatController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:read_cats'])->only('index');
        $this->middleware(['permission:create_cats'])->only('create');
        $this->middleware(['permission:update_cats'])->only('edit');
        $this->middleware(['permission:delete_cats'])->only('destroy');
    }

    public function index(Request $request)
    {

        $locale = LaravelLocalization::getCurrentLocale();

        $cats = Cat::when($request->search, function ($q) use ($request) {
            return $q->whereTranslationLike('name', '%' . $request->search . '%');
        })->latest()->paginate(5);

        return view('dashboard.cats.index', compact('cats'));
    }


    public function create()
    {
        return view('dashboard.cats.create');
    }


    public function store(Request $request)
    {


        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => 'required|string|min:3|max:60|unique:cat_translations,name'];
        }
        //dd($request->all());
        $data = $request->validate($rules);

        Cat::create($data);
        session()->flash('status', 'Category added successfully!');
        return redirect(route('dashboard.cats.index'));
    }


    public function edit(Cat $cat)
    {
        return view('dashboard.cats.edit', compact('cat'));
    }


    public function update(Request $request, Cat $cat)
    {

        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', 'string', 'min:3', 'max:60', Rule::unique('cat_translations', 'name')->ignore($cat->id, 'cat_id')]];
        }
        //dd($request->all());
        $data = $request->validate($rules);


        $cat->update($data);
        session()->flash('status', 'Category updated successfully!');
        return redirect(route('dashboard.cats.index'));
    }

    public function destroy(Cat $cat)
    {
        $cat->delete();
        session()->flash('status', 'Category deleted successsfully!');
        return redirect(route('dashboard.cats.index'));
    }
}
