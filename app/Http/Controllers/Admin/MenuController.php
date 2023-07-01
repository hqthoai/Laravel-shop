<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;
use App\Models\Menu;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this -> menuService = $menuService;

    }

    public function index(){
        return view('admin.menu.list',[
            'title' => 'List of category',
            'menus' => $this->menuService->get(),
        ]);
    }

    public function create(){
        return view('admin.menu.add',[
            'title'=>'Create a new category',
            'menus' => $this -> menuService->getParent(),
        ]);
    }

    public function store(CreateFormRequest $request){
        $result = $this->menuService -> create($request);
        return redirect()-> back();
    }

    public function destroy(Request $request){
        $result = $this -> menuService->destroy($request);

        if ($result){
            return response () ->json([
                'error' => false,
                'message' => 'Delete category successfully !'
            ]);
        }
        return response () -> json ([
            'error' => true,
        ]);
    }

    public function show (Menu $menu){
        return view('admin.menu.edit',[
            'title'=>'Edit the category: '.$menu -> name,
            'menu' =>$menu,
            'menus' => $this -> menuService->getParent(),
        ]);
    }

    public function update(Menu $menu, CreateFormRequest $request){
        $this -> menuService -> update($request, $menu);

        return redirect('/admin/menus/list');
    }

}
