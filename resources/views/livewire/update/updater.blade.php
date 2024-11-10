<div x-data="init()">
    <main class="main-content main-content-bg mt-0">
        <div class="page-header min-vh-100" style="background-image: url('assets/img/login-bg.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-7">
                        <div class="card border-0 mb-0"  x-data="{progress : @entangle('progress'), showitems: false}">
                            <div class="card-header bg-transparent text-center">
                                <div class="d-flex align-items-center justify-content-center mt-2 mb-2">
                                    <img src="{{asset(getSiteLogo())}}" class="login-logo">
                                    <h4 class="text-dark ms-3 mb-0 text-uppercase">{{ getApplicationName() }}</h4>
                                </div>
                            </div>
                            <div class="card-body px-lg-5 pt-0" >
                               <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                 <strong class="text-white">Please complete the update</strong> 
                               </div>
                               <div class="status-container border mb-3" >
                                    <p class="text-muted text-sm">Progress Will Be Shown Here....</p>
                                   <template x-for="item in test">
                                    <p class="text-muted text-sm" x-text="item"></p>
                                   </template>
                               </div>
                               <div class="progress mb-3" x-show="showitems == true" x-cloak >
                                    <div class="progress-bar bg-success" role="progressbar" :style="`width: ${progress}%`" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" ></div>
                                </div>
                                @if($success != true)
                                    <div class="d-grid gap-2">
                                            <button type="button" name="" id="" class="btn btn-primary py-4" wire:click="update" @click="startProgress">Update Now</button>
                                    </div>
                                @else 
                                <template x-if="success != true">
                                    <div class="d-grid gap-2">
                                        <button type="button" name="" id="" class="btn btn-primary py-4">Update Now</button>
                                    </div>
                                </template>
                                <template x-if="success == true">
                                    <div class="d-grid gap-2">
                                     <a href="{{route('login')}}" class="d-grid gap-2">   <button type="button" name="" id="" class="btn btn-success py-4">Dashboard</button></a>
                                    </div>
                                </template>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>

        function init() {
          return {
            test: [],
            status : @entangle('status'),
            success : false,
            startProgress: function () {
                this.progress = 0;
                this.showitems = true;
                this.test.push('Starting updation..');
                setTimeout(() => 
                {
                    this.test.push('Seeding..');
                    this.progress = 20;
                    setTimeout(() => 
                    {
                        this.progress = 50;
                        this.test.push('Migrating...');
                    }, 1000);
                    setTimeout(() => 
                    {
                        this.test = this.test.concat(this.status);
                        this.progress = 100;
                        this.success = true;
                    }, 2000);
                }, 1000);
            },
      
          };
      
        }
      
      </script>
</div>

