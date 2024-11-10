<div>
   
    <div class="row align-items-center justify-content-between mb-4">
        <div class="col">
            <h5 class="fw-500 text-white">{{$lang->data['file_manager']??'File Manager'}}</h5>
        </div>
    </div>
    <div class="row" >
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-4">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-3" >
                            <input type="file" class="form-control mt-2 image-file" >
                            
                        </div>
                        <div class="col-md-3">
                            <button href="#" wire:click="upload" class="btn btn-primary text-white mb-0" @if($allowupload == false) disabled @endif>
                                <div class="spinner-border spinner-border-sm mx-1" role="status" wire:loading wire:target="photo">
                                    <span class="visually-hidden"></span>
                                  </div>
                                  {{$lang->data['upload_image']??'Upload Image'}}
                            </button>
                        </div>
                        <div class="col-md-9 pt-2 ">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-8">
                                    @error('photo')
                                    <span class="text-danger text-xs liveerror" id="live_error">{{$message}}</span>
                                    @enderror
                                    <div wire:ignore> 
                                        <span class="text-danger text-xs 2" id="myerror2"></span>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-8 pt-2 ">
                            <p class="text-xs mb-0 mt-3">
                                <span class="text-danger fw-600">{{$lang->data['important']??'Imporatant!'}}</span>
                                <span class="">{!!$lang->data['upload_description']??'Upload 1:1 <b>".png"</b> images or icons only & the image name should not contain any spaces.'!!}</span>
                            </p>
                        </div>
                    </div>
                    <hr class="mt-4 mb-0">
                </div>
                <div class="card-body px-4 py-2">
                    <div class="row g-3 align-items-center mb-4">
                        @foreach ($icons as $key => $value)
                        <div class="col-md-1">
                            <a type="button">
                                <img src="{{ asset('assets/img/service-icons/' . $value['path']) }}" class="avatar avatar-xl border-radius-md bg-light p-2">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
    <script>
         document.addEventListener('livewire:load', function () {
                @this.on('removelocalError',() => {
                $('#myerror2').text("");
            })
        })
        
        $('.image-file').on('change', function(e) {
         $('#myerror2').text("");
    
        var numb = $(this)[0].files[0].size / 1024 / 1024;
        var file = $(this)[0].files[0];
        numb = numb.toFixed(1);
        var fileName = file.name;
        idxDot = fileName.lastIndexOf(".") + 1;
        extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="png")
        {
            if (numb > 1) {
                @this.allowupload = false;
                
                $('.liveerror').text("");
                $('#myerror2').text('File Size Is Above 1 MB!')
            } else {
                @this.upload('photo', file, (uploadedFilename) => {
                    // Success callback.
    
                }, () => {
    
                }, (event) => {
                   console.log(event)
                })
            }
        }else{
    
            $('#live_error').text("");
            $('#myerror2').text("Only png files are allowed!");
            file.value = "";  // Reset the input so no files are uploaded
        }
        
        });
    </script>
    @endpush
    
    </div>
    