<?php

namespace App\Http\Services\Menu;

use App\Models\Menu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class MenuService
{

    public function getParent()
    {
        return Menu::where('parent_id', 0)->get();
    }

    public function show () {
        return Menu::select('id','name')
        -> where('parent_id',0)
        -> orderByDesc('id')->paginate(10);
    }

    public function get()
    {
        return Menu::orderByDesc('id')->paginate(10);
    }

    public function create($request)
    {
        try {
            Menu::create([
                'name' => (string) $request->input('name'),
                'parent_id' => (int) $request->input('parent_id'),
                'description' => (string) $request->input('description'),
                'content' => (string) $request->input('content'),
                'active' => (int) $request->input('active'),
                'slug' => Str::slug($request->input('name')),
            ]);
            Session::flash('success', 'Add new category successfully !');
        } catch (\Exception $ex) {
            Session::flash('error', $ex->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request)
    {
        $id =  $request->input('id');
        $menu = Menu::where('id', $id)->first();
        if ($menu) {
            return Menu::where('id', $id)->orWhere('parent_id', $id)->delete();
        }
        return false;
    }

    public function update($request, $menu)
    {
        // $menu->fill($request->input());
        // $menu->save();
        try {
            if ($request->input('parent_id') != $menu->id) {
                $menu->parent_id = (int) $request->input('parent_id');
            }
            else {}
            $menu->name = (string) $request->input('name');
            $menu->description = (string) $request->input('description');
            $menu->content = (string) $request->input('content');
            $menu->active = (int) $request->input('active');
            $menu->save();

            Session::flash('success', 'Update successfully !');
        } catch (\Exception $ex) {
            Session::flash('error', $ex->getMessage());
            return false;
        }
        return true;
    }

    public function getId($id)
    {
        return Menu::where('id',$id) -> where ('active', 1)-> firstOrFail();
    }
    public function getProduct($menu, $request)
    {


        $query = $menu->products()
        ->select('id','name','price','price_sale','thumb')
        ->where('active', 1);


        if ($request->input('price')){
            $query->orderBy('price', $request->input('price'));
        }

        return $query->orderByDesc('id')->paginate(12)->withQueryString();

    }
}
