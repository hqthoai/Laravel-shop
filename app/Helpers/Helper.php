<?php
namespace App\Helpers;
use Illuminate\Support\Str;

class Helper {

    public static function menu($menus, $parent_id = 0, $char=''){
        $html='';
        foreach ($menus as $key=>$value){
            if ($value->parent_id == $parent_id){
                $html .= '
                <tr>
                    <td>'.$value->id.'</td>
                    <td>'.$char.$value->name.'</td>
                    <td>'.self::active($value->active).'</td>
                    <td>'.$value->updated_at.'</td>
                    <td>
                        <a href="/admin/menus/edit/'.$value->id.'" class ="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-danger btn-sm"
                        onclick="removeRow('.$value->id.',\'/admin/menus/destroy\')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                ';

                unset($menus[$key]);

                $html .= self::menu($menus,$value->id,'--');


            }
        }
        return $html;
    }

    public static function active($active = 0):string {
        return $active == 0 ? '<span class="btn btn-danger btn-xs">NO</span>':'<span class="btn btn-success btn-xs">YES</span>';
    }


    public static function menus($menus, $parent_id = 0){
        $html='';
        foreach($menus as $key => $menu){
            if ($menu->parent_id == $parent_id){
                $html.='
                <li>
                    <a href="/category/'.$menu->id.'-'.Str::slug($menu->name, '-').'.html">
                        '.$menu->name.'
                    </a> ';
                if (self::isChild($menus , $menu->id)){
                    $html .=' <ul class="sub-menu">';
                    $html .= self::menus($menus, $menu->id);
                    $html .='</ul> ';
                }
            }

            $html.='</li>';
        }
        return $html;
    }

    public static function getMenu($menus){
        $html='';
        foreach($menus as $key => $menu){
            if ($menu->parent_id == 0){
                $html.='
                <li class="p-b-10">
							<a href="/category/'.$menu->id.'-'.Str::slug($menu->name,'-').'.html" class="stext-107 cl7 hov-cl1 trans-04">
                        '.$menu->name.'</a></li> ';
                }
            }
        return $html;
    }

    public static function isChild($menus, $id){
        foreach ($menus as $menu){
            if ($menu->parent_id == $id){
                return true;
            }
        }
        return false;
    }

    public static function price($price = 0 , $priceSale = 0){
        if ($priceSale != 0 ) return number_format($priceSale, 0,',' ,'.') . ' VND';
        if ($price != 0) return number_format($price, 0, ',','.') . ' VND';
        return '<a href="/contact.html">Contact Us</a>';
    }

}
