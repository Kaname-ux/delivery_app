@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirmez votre adresse mail') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Un lien de vérification a été envoyé à votre adresse mail.') }}
                        </div>
                    @endif

                    {{ __('Avant de continuer, Veuillez verifier votre Boite mail pour voir le lien.') }}
                    {{ __('Si vous ne voyez pas le mail, verifiez das les SPAM, si vous ne voyez toujours pas, ') }}, <a href="{{ route('verification.resend') }}">{{ __('cliquez ici pour renvoyer le mail.') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
