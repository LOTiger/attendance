<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 18-1-22
 * Time: 下午7:12
 */

namespace app\Http\Controllers\Api;


use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

}