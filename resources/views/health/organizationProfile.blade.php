@extends('health.masterOrganization')
@section('content')
<div class="content-sticky-footer">
    <div class="content-sticky-footer pt-0">
        <div class="row mx-0 position-relative py-5 mb-4">
            <div class="background h-100 theme-header"><img src="{{URL::to('public/assets/img/background.png')}}" alt=""></div>
            <div class="col">
                <a href="#" class="media">
                    <div class="w-auto h-100">
                        <figure class="avatar avatar-120"><img src="{{URL::to('images/avatar.png')}}" alt="" style="display:<?php if(empty($value->image)){echo "";}else{echo "none";} ?>"><img src="{{URL::to('')}}/<?php echo $value->image; ?>" alt="" style="<?php if(!empty($value->image)){echo "";}else{echo "none";} ?>"> </figure>
                    </div>
                    <div class="media-body align-self-center ">
                        <h5 class="text-white"><?php echo $value->name ; ?> <span class="status-online bg-success"></span></h5>
                        <p class="text-white">
                            online <span class="status-online bg-color-success"></span>
                            <br> <?php echo $value->organization_name; ?>
                            <br> <?php echo $value->designation ; ?>
                            <br> <?php echo $value->email ; ?>
                            <br> <?php echo $value->mobile ; ?>
                        </p>
                    </div>
                </a>
            </div>
        </div>

        <div class="row mx-0 mt-3">
            <div class="col mb-2">
                <a href="{{URL::to('organizationProfileInfo')}}" class="btn btn-block btn-primary rounded border-0">UPDATE PROFILE</a>
            </div>
            <div class="col">
                <a href="{{URL::to('organizationChangePassword')}}" class="btn btn-block btn-outline-secondary rounded">CHANGE PASSWORD</a>
            </div>
        </div>

    </div>
    <br>
</div>
@endsection
