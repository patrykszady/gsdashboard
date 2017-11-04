<?php

namespace App\Http\Controllers;

use App\User;
use App\Vendor;
use App\Client;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;

use Illuminate\Support\Facades\Auth;

use Session;
use URL;
use DB;
use Route;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function createvendor(Vendor $vendor)
    {
        $users = User::all();
        return view('users.create', compact('vendor', 'users'));
    }

    public function create()
    {
        if(URL::previous() == URL::current()) {

        } else {
            Session::put('takemeback', URL::previous()); 
        }

        return view('users.create');    
    }

    public function createassociate($id)
    {
        //Doesn't put a new 'takemeback' into the Session If url is this ('users.edit')
        if(URL::previous() == URL::current()) {

        //save last URL so when form is submitted i can be taken back ("intended")...eventually ends up in a Middleware        
        } else {
            Session::put('takemeback', URL::previous()); 
        }

        
        if(Session::get('takemeback') == route('clients.show', $id) or Session::get('takemeback') == route('projects.show', $id)) {
            
            $client = Client::findOrFail($id);
            $users = User::where('client_id', '!=', $id)->orWhereNull('client_id')->get();

            return view('users.create', compact('client', 'users'));

        } elseif(Session::get('takemeback') == route('vendors.show', $id)) {

            $vendor = Vendor::findOrFail($id);
            
            $users = User::excludeEmployees($vendor)->get();
            
            return view('users.create', compact('vendor', 'users'));

        } else {
            return view('users.create');
        }
    }

    public function store(StoreUser $request)
    {
        //create User if Exisitng isnt selected
        if(!isset($request->user_id)) {
            $user = User::create($request->all());
            $user->password = bcrypt('Designspilka123#');
            $user->created_by_user_id = Auth::id();
            $user->save(); 
        }

        //set $user_if, if in request, from there, if user was just created, grab it there.
        if(isset($request->user_id)){
            $user_id = $request->user_id;
        } else {
            $user_id = $user->id;
        }
        //Update User with correct vendor or client _id
        $user = User::findOrFail($user_id);
            if(isset($request->client_id)) {
                $user->client_id = $request->client_id;
                $user->save();
            } elseif(isset($request->vendor_id)) {
                
                if($user->vendors()->first() == null) {
                $user->primary_vendor = $request->vendor_id;
                }

                $user->vendors()->attach($request->vendor_id);

                $user->save();

            } else {
                return redirect(Session::pull('takemeback'))->with('success', 'New contact was created.');
            }

        return redirect(Session::pull('takemeback'))->with('success', 'Contact was added.');
    }

    public function show(User $user)
    {
        $clients = $user->client()->get();

        return view('users.show', compact('user', 'clients'));
    }

    public function edit(User $user)
    {
        //Doesn't put a new 'takemeback' into the Session If url is this ('users.edit')
        if(URL::previous() == url("users/$user->id/edit")){

        } else {
            Session::put('takemeback', URL::previous()); //save last URL so when form is submitted i can be taken back ("intended")...eventually ends up in a Middleware
        }
        
        return view('users.edit', compact('user'));
    }

    public function update(StoreUser $request, $user)
    {    
        $user = User::findOrFail($user);

        $user->update($request->all());
        $user->save();

        return redirect(Session::pull('takemeback'))->with('success', 'Contact ' . $user->getFullname() . ' was edited.');
    }

    public function remove_from_client(User $user)
    {

        if(URL::Previous() == Session::pull('takemeback')) {

            $user->client_id = null;
            $user->save();
            return back()->with('success', 'Contact ' . $user->getFullname() . ' was removed.');
        }

        return redirect(route('users.index'));
        
    }

    public function remove_from_vendor(User $user)
    {
        //make sure this is coming from vendors.show
        $url = URL::Previous();
        if($url == Session::pull('takemeback')) {
            
            $vendor_id = substr($url, strrpos($url, '/') + 1);

            $user->vendors()->detach($vendor_id);

            $user->primary_vendor = null;
            $user->save();
           
            return back()->with('success', 'Contact ' . $user->getFullname() . ' was removed.');
        }

        return redirect(route('users.index'));
  
    }

    public function destroy($id)
    {
        //
    }
}
