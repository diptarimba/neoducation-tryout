<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    const CLASS_BUTTON_PRIMARY = 'btn m-1 text-white bg-violet-500 border-violet-500 hover:bg-violet-600 hover:border-violet-600 focus:bg-violet-600 focus:border-violet-600 focus:ring focus:ring-violet-500/30 active:bg-violet-600 active:border-violet-600';
    const CLASS_BUTTON_SUCCESS = 'btn m-1 text-white bg-green-500 border-green-500 hover:bg-green-600 hover:border-green-600 focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-500/30 active:bg-green-600 active:border-green-600';
    const CLASS_BUTTON_INFO = 'btn m-1 text-white bg-sky-500 border-sky-500 hover:bg-sky-600 hover:border-sky-600 focus:bg-sky-600 focus:border-sky-600 focus:ring focus:ring-sky-500/30 active:bg-sky-600 active:border-sky-600';
    const CLASS_BUTTON_WARNING = 'btn m-1 text-white bg-yellow-500 border-yellow-500 hover:bg-yellow-600 hover:border-yellow-600 focus:bg-yellow-600 focus:border-yellow-600 focus:ring focus:ring-yellow-500/30 active:bg-yellow-600 active:border-yellow-600';
    const CLASS_BUTTON_DANGER = 'btn m-1 text-white bg-red-500 border-red-500 hover:bg-red-600 hover:border-red-600 focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-500/30 active:bg-red-600 active:border-red-600';

    const STATUS_TEST_PLANNED = 'PLANNED';
    const STATUS_TEST_ON_GOING = 'ON_GOING';
    const STATUS_TEST_ENDED = 'ENDED';
    const STATUS_TEST_ERROR = 'ERROR';

    public function getActionColumn($data, $path = '', $prefix = 'admin')
    {
        $ident = Str::random(10);
        $editBtn = route("$prefix.$path.edit", $data->id);
        $deleteBtn = route("$prefix.$path.destroy", $data->id);
        $buttonAction = '<a href="' . $editBtn . '" class="' . self::CLASS_BUTTON_PRIMARY . '">Edit</a>';
        $buttonAction .= '<button type="button" onclick="delete_data(\'form' . $ident . '\')"class="' . self::CLASS_BUTTON_DANGER . '">Delete</button>' . '<form id="form' . $ident . '" action="' . $deleteBtn . '" method="post"> <input type="hidden" name="_token" value="' . csrf_token() . '" /> <input type="hidden" name="_method" value="DELETE"> </form>';
        return $buttonAction;
    }

    public function createMetaPageData($id = null, $name = '', $path = '', $prefix = 'admin')
    {
        $data = [
            'title' => "Create $name Data",
            'url' => route("$prefix.$path.store"),
            'home' => route("$prefix.$path.index")
        ];
        if (!is_null($id)) {
            $data = [
                'title' => "Update $name Data",
                'url' => route("$prefix.$path.update", $id),
                'home' => route("$prefix.$path.index")
            ];
        }

        return $data;
    }
}
