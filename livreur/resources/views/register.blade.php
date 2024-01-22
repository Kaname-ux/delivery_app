@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Créer un compte <strong>ou</strong> <a  href="{{ route('login') }}">Se connecter</a></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nom et Prenom</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">Contact</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                          <?php 
                          $communes = array("Adjamé", "Cocody", "Attécoubé", "Bingerville", "Anyama", "Koumassi", "Plateau", "Treichville", "Marcory", "Port-Bouet", "Bassam", "Songon", "Abobo", "Yopougon" );


                          $pieces = array("CNI", "Permis de conduire", "Attestation d'identité", "Carte consulaire", "Carte professionelle", "Passeport");

                          sort($communes);
                          sort($pieces);
                           ?>


                            <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">Ville/Commune</label>

                            <div class="col-md-6">
                            	<select name="city" required="required">
                            		<option value="">
                            			Choisir une ville/commune
                            		</option>
                            		<?php 
                            		foreach($communes as $commune) 
                                   echo "<option value='$commune'>$commune</option>";
                            		?>
                            		
                            	</select>
 
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                         <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">Quartier</label>

                            <div class="col-md-6">
                                <input id="adrssse" type="text" class="form-control @error('adrssse') is-invalid @enderror" name="adresse" value="{{ old('adresse') }}" required autocomplete="adresse" autofocus>

                                @error('adresse')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <label for="piece_nature" class="col-md-4 col-form-label text-md-right">Nature de la pièce d'identité</label>

                            <div class="col-md-6">
                                <select name="piece_nature" required="required">
                                    <option selected disabled>
                                        Choisir le type de pièce d'identité
                                    </option>
                                    <?php 
                                    foreach($pieces as $piece) 
                                   echo "<option value='$piece'>$piece</option>";
                                    ?>
                                    
                                </select>
 
                                @error('piece_nature')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Numero de la piece</label>

                            <div class="col-md-6">
                                <input id="piece" type="text" class="form-control @error('piece') is-invalid @enderror" name="piece" value="{{ old('piece') }}" required >

                                @error('goods_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Mot de passe</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmer mot de passe</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    S'enregister
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
