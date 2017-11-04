<?php

namespace App\Http\Controllers;

use App\Client;
use App\Project;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests\StoreClient;
use App\Http\Requests\StoreUser;
use URL;

use Illuminate\Support\Facades\Auth;

use Session;

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

        return redirect(route('clients.show', $client->id))->with('success', 'Client was created.');
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
        //Doesn't put a new 'takemeback' into the Session If url is this ('users.edit')
        if(URL::previous() == url("clients/$client->id/edit")){

        } else {
            Session::put('takemeback', URL::previous()); //save last URL so when form is submitted i can be taken back ("intended")...eventually ends up in a Middleware
        }
        
        return view('clients.edit', compact('client'));
        
    }

    public function update(StoreClient $request, Client $client)
    {
        $client = Client::findOrFail($client);
        $client->update($request->all());
        $client->save();
  
        return redirect(Session::pull('takemeback'))->with('success', 'Client ' . $client->getName() . ' was edited.');
    }

    public function destroy(Client $client)
    {
    
    }
}
