@extends('backpack::layout')

@section('title', 'Manage Clubshop List')


@section('content')

@if (Session::has('message'))
   <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="container">
 
        <form method="post" action="{{ action('ClubshopCrudController@edit') }}">

      
                  <div class="form-group" >
                        <label for="id">Clubshop ID</label> <input class="form-control" value="{{ $data[0]->clubshop_id }}" type="text" name="clubshop_id" placeholder="{{ $data[0]->clubshop_id }}"></input>
                        <label for="clubshop">Clubshop</label> <input class="form-control" value="{{ $data[0]->clubshop }}" type="text" name="clubshop" placeholder="{{ $data[0]->clubshop }}"></input>
                        <label for="status">Status</label> <input class="form-control" value="{{ $data[0]->status }}" type="text" name="status" placeholder="{{ $data[0]->status }}"></input>
                        <label for="opened">Date Opened</label> <input class="form-control" type="text" value="{{ $data[0]->opened }}" name="opened" placeholder="{{ $data[0]->opened }}"></input>

                 <!-- Check if sage or tax is enabled and then check the checkbox if required -->        
                        @if($data[0]->sage  == "yes")
                              {{ $sagechecked = "checked" }}
                        @else
                              {{ $sagechecked = "" }}
                        @endif
                        
                  <!-- Check if sage or tax is enabled and then check the checkbox if required -->

                        @if($data[0]->tax  == "yes")
                              {{ $taxchecked = "checked" }}
                        @else
                              {{ $taxchecked = "" }}
                        @endif
                  <!-- Check if sage or tax is enabled and then check the checkbox if required -->
                              <div class="checkbox">
                                    <label><input type="checkbox" name="sage" value="yes" {{ $sagechecked }}>Sage Linked</label>
                                    <label><input type="checkbox" name="tax" value="yes" {{ $taxchecked }}>Tax enabled</label>
                              </div>
                        </br>
                        <label for="opened">URL</label> <input class="form-control" value="{{ $data[0]->url }}" type="text" name="url"></input>

                        <input type="hidden" value="{{ $data[0]->id }}" name="id">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        </br>
                        <button type="submit" class="btn btn-success btn-lg">Edit</button>
                   </div> 
           
      </form>  
   
</div>
@endsection
