@extends("layouts.master")

@section("title")
Roles des utilisateurs
@endsection

@section("content")
<div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Utilisateurs <a href="/user-form" class="btn">Ajouter</a></h4>
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Nom
                      </th>
                      <th>
                        Contact
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        Type
                      </th>
                      <th >
                        Modifier
                      </th>

                       <th >
                        Supprimer
                      </th>

                    </thead>
                    <tbody>
                      @foreach($users as $user)
                     <tr>
                       <td>
                         {{$user->name}}
                       </td>
                       <td>
                         {{$user->phone}}
                       </td>
                       <td>
                        {{$user->email}}
                       </td>

                        <td>
                        {{$user->usertype}}
                       </td>
                       <td>
                         <a href="/role-edit/{{$user->id}}" class="btn btn-success">Modifier</a>
                       </td>
                       <form method="POST" action="/role-delete/{{$user->id}}">
                         {{csrf_field()}}
                        {{method_field('DELETE')}}
                       
                       <td>
                         <button type="submit" class="btn btn-danger">Supprimer</button>
                       </td>
                     </tr>
                     </form>
                     @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          
        </div>
@endsection

@section("script")
@endsection