@extends('layouts.app')

@section('content')

            <div class="card">
                <div class="card-header">{{ __('My Communities') }}</div>

                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-info">{{session('message')}}</div>
                    @endif
                    <a href="{{ route('communities.create')}}" class="btn btn-sm btn-primary">Create a Community</a>
                  <table class="table">
                      <thead>
                      <tr>
                          <th>Name</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach($communities as $community)
                          <tr>
                              <td><a href="{{ route('communities.show',$community) }}">{{$community->name}}</a></td>
                              <td><a href="{{ route('communities.edit',$community) }}" class="btn btn-sm btn-primary">Edit</a>
                                  <form method="POST" style="display: inline-block" action="{{route('communities.destroy',$community)}}">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are  you sure')">Delete</button>
                                  </form>
                              </td>
                          </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
            </div>

@endsection
