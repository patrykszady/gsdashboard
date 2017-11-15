<?php

namespace App\Http\Controllers;

use App\Client;
use App\Project;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreClient;
use App\Http\Requests\StoreUser;

use Session;
use URL;


class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $clients = Client::all();

        return view('clients.index', compact('clients'));
    }

    public function create(User $user)
    {
        $users = User::all();
        return view('clients.create', compact('users'));
    }

    public function store(StoreClient $request)
    {
        //Create App/Client
        $client = Client::create([
            'business_name' => $request['business_name'], 
            'address' => $request['address'], 
            'address_2' => $request['address_2'], 
            'state' => $request['state'], 
            'zip_code' => $request['zip_code'], 
            'city' => $request['city'], 
            'note' => $request['note'], 
            'home_phone' => $request['home_phone']
            ]);
        $client->created_by_user_id = Auth::id(); //created by
        $client->save();

        //Create App/User with the new client_id
        if(isset($request->user_id)) //if User not selected from dropdown create new User/ else ignore User inputs
        {
            $user = User::findOrFail($request->user_id); 
        //Update current App/User('user_id') with the new client_id
        } else {
            $user = User::create([
            'first_name' => $request['first_name'], 
            'last_name' => $request['last_name'], 
            'email' => $request['email'], 
            'phone_number' => $request['phone_number']
            ]);
            $user->password = bcrypt('Designspilka123#');  
        }
        
        $user->created_by_user_id = Auth::id();
        $user->client_id = $client->id;
        $user->save();

        if(Session::has('takemeback')) {
            return redirect(Session::pull('takemeback'))->with('success', 'Client was created.');
        } else {
            return redirect(route('clients.show', $client->id))->with('success', 'Client was created.');
        }
        
    }

    public function show(Client $client)
    {
        Session::put('takemeback', URL::current());  
        
        $projects = $client->projects()->get();

        $users = $client->users()->get();
        return view('clients.show', compact('client', 'users', 'projects'));
    }

    public function edit(Client $client)
    {
        if(URL::previous() == URL::current()) {
        } else {
            Session::put('takemeback', URL::previous());
        }

        return view('clients.edit', compact('client'));
    }

    public function update(StoreClient $request, Client $client)
    {
        $client->update($request->all());
  
        return redirect(Session::pull('takemeback'))->with('success', 'Client ' . $client->getName() . ' was edited.');
    }

    public function destroy(Client $client)
    {
    
    }
}
