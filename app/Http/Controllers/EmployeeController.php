<?php

namespace App\Http\Controllers;

use App\Mail\UserLogin;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{

    protected $employee;

    public function __construct(Employee $employee){
        $this->employee = $employee;
    }
    /**
     * Display a listing of the resource.
     * @OA\Get(
     *   path="/api/employee",
     *   tags={"Employees"}, 
     *   security={ {"bearer": {} }}, 
     *    @OA\Response(
     *    response=401,
     *    description="UnAuthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="UnAuthanticated"),
     *    )
     * ),
     *  @OA\Response(
     *    response=500,
     *    description="Returns when there is server problem",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Server Error"),
     *    )  
     * ),   
     *   @OA\Response(
     *     response="200",
     *     description="Success|Returns Employees list",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(
     *           @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Elvin"
     *                      ),
     *                      @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="elhirwa3@gmail.com"
     *                      ),
     *                      @OA\Property(
     *                         property="code",
     *                         type="string",
     *                         example="006"
     *                      ),
     * )
     *     )
     *   )
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Employee::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @OA\Post (
     *     path="/api/employee",
     *     tags={"Employees"},
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="array",
     *                       @OA\Items(
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="code",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="phone",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="post",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="identity_number",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="age",
     *                          type="string"
     *                      ),),
     *                 ),
     *                 example={
     *                     "name":"Bebe",
     *                     "email":"example@content.com",
     *                     "code":"101",
     *                     "phone":"0784562344",
     *                     "post":"Engineer",
     *                     "identity_number":"1198580045563328",
     *                     "age":"36",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="name"),
     *              @OA\Property(property="email", type="string", example="email@ab.com"),
     *              @OA\Property(property="code", type="string", example="404"),
     *              @OA\Property(property="phone", type="string", example="0798888888"),
     *              @OA\Property(property="post", type="string", example="manager"),
     *              @OA\Property(property="identity_number", type="string", example="11798844888778800"),
    *               @OA\Property(property="age", type="string", example="98"),
    *               @OA\Property(property="updated_at", type="string", example="2022-02-23T07:07:54.000000Z"),
    *               @OA\Property(property="created_at", type="string", example="2022-02-23T07:07:54.000000Z"),
     *              @OA\Property(property="id", type="number", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      ),
   
     *      @OA\Response(
     *    response=401,
     *    description="UnAuthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="UnAuthanticated"),
     *    )
     * ),
     *  @OA\Response(
     *    response=500,
     *    description="Returns when there is server problem",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Server Error"),
     *    )  
     * ), 
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $getemail = $request->user()->email;
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'code' => 'required',
            'phone' => 'required',
            'post' => 'required',
            'identity_number' => 'required',
            'age' => 'required',
        ]);
        
        Mail::to($getemail)->send(new UserLogin());

        return Employee::Create($request->all());
        // return $getemail;
    }

    /**
     * Display the specified resource.
     * 
     * * @OA\Get (
     *     path="/api/employee/{id}",
     *     tags={"Employees"},
     *     security={ {"bearer": {} }},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="title"),
     *              @OA\Property(property="email", type="string", example="content@gmil.com"),
     *              @OA\Property(property="code", type="string", example="808"),
     *              @OA\Property(property="phone", type="string", example="089564584"),
     *              @OA\Property(property="post", type="string", example="post"),
     *              @OA\Property(property="identity_number", type="string", example="120859495989598"),
     *              @OA\Property(property="age", type="string", example="40"),
     *         )
     *     ),
     *  @OA\Response(
     *    response=404,
     *    description="NotFound",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Employee Not Found"),
     *    )
     * ),
     *      @OA\Response(
     *    response=401,
     *    description="UnAuthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="UnAuthanticated"),
     *    )
     * ),
     *  @OA\Response(
     *    response=500,
     *    description="Returns when there is server problem",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Server Error"),
     *    )  
     * )   
     * )
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $employee = $this->employee->getEmployee($id);
        if($employee){
            return response()->json($employee);
        }
        return response()->json(["msg"=>"this Employee not found"],404);
    }


    // public function get($id){
    //     $todo = $this->todo->getTodo($id);
    //     if($todo){
    //         return response()->json($todo);
    //     }
    //     return response()->json(["msg"=>"Todo item not found"],404);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     * * @OA\Put (
     *     path="/api/employee/{id}",
     *     tags={"Employees"},
     *     security={ {"bearer": {} }},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="code",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="phone",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="post",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="identity_number",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="age",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "name":"Bebe",
     *                     "email":"example@content.com",
     *                     "code":"101",
     *                     "phone":"0784562344",
     *                     "post":"Engineer",
     *                     "identity_number":"1198580045563328",
     *                     "age":"36",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="name"),
     *              @OA\Property(property="email", type="string", example="email@ab.com"),
     *              @OA\Property(property="code", type="string", example="404"),
     *              @OA\Property(property="phone", type="string", example="0798888888"),
     *          )
     *      ),
     *   @OA\Response(
     *    response=404,
     *    description="NotFound",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Employee Not Found"),
     *    )
     * ),
     *      @OA\Response(
     *    response=401,
     *    description="UnAuthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="UnAuthanticated"),
     *    )
     * ),
     *  @OA\Response(
     *    response=500,
     *    description="Returns when there is server problem",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Server Error"),
     *    )  
     * ),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update($id, Request $request){
        try {
            $employee = $this->employee->updateEmployee($id,$request->all());
            return response()->json($employee);
        }catch (ModelNotFoundException $exception){
            return response()->json(["msg"=>$exception->getMessage()],404);
        }
    }
    /**
     * Remove the specified resource from storage.
     * 
     *  * @OA\Delete (
     *     path="/api/employee/{id}",
     *     tags={"Employees"},
     *     security={ {"bearer": {} }},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Employee deletion success")
     *         )
     *     ),
     *  @OA\Response(
     *    response=404,
     *    description="NotFound",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Employee Not Found"),
     *    )
     * ),
     *      @OA\Response(
     *    response=401,
     *    description="UnAuthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="UnAuthanticated"),
     *    )
     * ),
     *  @OA\Response(
     *    response=500,
     *    description="Returns when there is server problem",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Server Error"),
     *    )  
     * ),   
     * )
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        try {
            $employee = $this->employee->deleteEmployee($id);
            return response()->json(["msg"=>"Employee Deleted successfully"]);
        }catch (ModelNotFoundException $exception){
            return response()->json(["msg"=>$exception->getMessage()],404);
        }
    }

     /**
      * Search for Related name in DataBase
    * @OA\Get (
     *     path="/api/employee/search/{name}",
     *     tags={"Employees"},
     *     security={ {"bearer": {} }},
     *     @OA\Parameter(
     *         in="path",
     *         name="name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="title"),
     *              @OA\Property(property="email", type="string", example="content@gmil.com"),
     *              @OA\Property(property="code", type="string", example="808"),
     *              @OA\Property(property="phone", type="string", example="089564584"),
     *              @OA\Property(property="post", type="string", example="post"),
     *              @OA\Property(property="identity_number", type="string", example="120859495989598"),
     *              @OA\Property(property="age", type="string", example="40"),
     *         )
     *     ),
     *      @OA\Response(
     *    response=401,
     *    description="UnAuthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="UnAuthanticated"),
     *    )
     * ),
     *  @OA\Response(
     *    response=500,
     *    description="Returns when there is server problem",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Server Error"),
     *    )  
     * ),   
     * )

     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Employee::where('name', 'like', '%' . $name . '%')->get();
    }
}
