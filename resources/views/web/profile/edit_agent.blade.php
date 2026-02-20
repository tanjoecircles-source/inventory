<x-layouts.app background="bg-white">
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('profile-category')}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <form id="brand-form" name="brand-form" action="{{url('profile-update-agent/'.$info->id)}}" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="card no-border shadow-none custom-square mt-4 mb-3">
                    <div class="card-body px-2 py-4">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$info->name}}" placeholder="Masukan nama lengkap">
                            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Telp</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{$user->phone}}" placeholder="Masukan alamat email">
                            @error('phone')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="row">
                                <div class="col">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="gender" value="Laki-laki" checked="">
                                        <span class="custom-control-label">Laki-laki</span>
                                    </label>
                                </div>
                                <div class="col">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="gender" value="Perempuan">
                                        <span class="custom-control-label">Perempuan</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tempat / Tanggal Lahir</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control" name="place_of_birth" value="{{$info->place_of_birth}}" placeholder="Nama Kota">
                                    @error('place_of_birth')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                                        </div>
                                        <input class="form-control fc-datepicker" name="date_of_birth" value="{{$info->date_of_birth}}" type="text" placeholder="dd-mm-yyyy">
                                    </div>
                                    @error('date_of_birth')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="address" placeholder="Tulis Nama Jalan, Nomor, RT/RW/Komplek, Kelurahan" rows="3">{{ $info->address }}</textarea>
                            @error('address')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Provinsi</label>
                            <select class="form-control" name="region" id="region" placeholder="Pilih Provinsi">
                                @foreach($region as $value)
                                    @if($info->region == $value->id)
                                        <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('region') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kabupaten/Kota</label>
                            <select class="form-control" name="district" id="district" placeholder="Pilih Kabupaten/Kota">
                                @foreach($district as $value)
                                    @if($info->district == $value->id)
                                        <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('district') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" class="form-control" name="post_code" value="{{$info->post_code}}" placeholder="Masukan Kode Pos">
                            @error('post_code')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="card text-center no-border shadow-none custom-square mb-7">
                    <div class="card-body p-2">
                        <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-update" name="btn-update">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function () {
           $('#region').select2({
               "ajax" : {
                   "url" : "{{url('region-combo')}}",
                   "type" : "POST",
                   "dataType" : "json",
                   "data": function (params) {
                       var query = {
                           _token: "{{ csrf_token() }}",
                           search: params.term,
                           type: "public"
                       }
                       return query;
                   }
               },
               placeholder: 'Cari Provinsi',
           });
       
           var region = "{{$info->region}}";
           $('#region').change(function() {
                region = $('#region').val();
           });
       
           $('#district').select2({
               "ajax" : {
                   "url" : "{{url('district-combo')}}",
                   "type" : "POST",
                   "dataType" : "json",
                   "data": function (params) {
                       var query = {
                           _token: "{{ csrf_token() }}",
                           search: params.term,
                           parent: region,
                           type: 'public'
                       }
                       return query;
                       
                   }
               },
               placeholder: 'Cari Kabupaten/Kota',
           });
       });
       
       </script>
    </x-layouts.app>