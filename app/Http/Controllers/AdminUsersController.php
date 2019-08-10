<?php
namespace App\Http\Controllers;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Photo;
class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show all Users by Edi800
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
                                        // Creaete Users by Edi800
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.create', compact('roles'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        // User::create($request->all());

        if(trim($request->password) == ''){
          $input = $request->except('password');
        } else{
          $input = $request->all();
          $input['password'] = bcrypt($request->password);
        }



        if($file = $request->file('photo_id')){
          $name = time() . $file->getClientOriginalName();

          $file->move('images', $name);
          $photo = Photo::create(['file' => $name]);

          $input['photo_id'] = $photo->id;
        }




        User::create($input);


        return redirect('/admin/users');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
              // Find specific user by Id by Edi800
        return view('admin.users.show');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      // Edit specific user by Id by Edi800
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'id')->all();
          return view('admin.users.edit', compact('user', 'roles'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
      $user = User::findOrFail($id);

      if(trim($request->password) == ''){
        $input = $request->except('password');

          } else{

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
      }

      $input = $request->all();

      if($file = $request->file('photo_id')){
        $name = time() . $file->getClientOriginalName();

        $file->move('images', $name);

        $photo = Photo::create(['file' => $name]);
        $input['photo_id'] = $photo->id;
      }
        $user->update($input);

        return redirect('/admin/users');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect('admin/users');
    }
}
