@extends('layouts.admin')  
@section('content')  
<div class="container text-center my-4">
    <div class="alert alert-warning">
        <i class="fas fa-sad-tear fa-3x mb-3"></i>
        <h4 class="alert-heading">No Results Found</h4>
        <p>Sorry, we couldn't find any matches for your search about "<b><?=$str?></b>".</p>
        <hr>
        <p class="mb-0">
        It seems the feature you're looking for isn't available in our system at this time. If you have any questions or need assistance with other features, please feel free to reach out to our support team.
        </p>
    </div>
</div>


@endsection