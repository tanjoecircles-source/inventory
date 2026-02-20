<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('home')}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <img src="{{ asset('storage/'.$news->photo) }}" width="100%">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto px-0">
                <div class="card no-border shadow-none custom-square my-2">
                    <div class="card-body px-4 py-4">
                        <h6 class="text-dark mb-1" style="line-height:22px">{{Str::limit($news->name, 100)}}</h6>
                        <small class="text-muted text-justify">@php echo $news->description @endphp </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </x-layouts.app>