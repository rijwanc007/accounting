@extends('master')
@section('account','active') @section('account-show','show') @section('chart_of_account','active') @section('chart_of_account-show','show') @section('index','active') @section('index-show','show') @section('chart_of_account-'. $id,'active')
@section('content')
    @php
        $sister_concerns = \App\SisterConcern::find($id);
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-12 text-center">
                            <h4>Chart Of Accounts for {{$sister_concerns->name}}<hr/></h4>
                        </div>
                        @for($i =0 ; $i<count($categories) ; $i++)
                            @php
                                $heads = \App\Chartofaccount::where('sister_concern_id', $id)->where('category', $categories[$i])->where('sub_head_id', 0)->where('child_head_id', 0)->orderBy('id', 'ASC')->get();
                            @endphp
                            <div class="col-md-2"></div>
                            <div class="col-md-8 scroll_custom" {{--style="overflow-x: scroll"--}}>
                                <div id="tree">
                                    <div class="branch">
                                        <div class="entry"><span class="text-info" style="font-weight: bold"><a data-toggle="tooltip" title="{{$categories[$i]}}">{{substr($categories[$i], 0, 20)}}</a></span>
                                            <div class="branch">
                                                @forelse($heads as $head)
                                                    @php
                                                        $sub_heads = \App\Chartofaccount::where('sister_concern_id', $id)->where('head_id', $head->head_id)->where('sub_head_id','!=',0)->where('child_head_id', 0)->orderBy('id', 'DESC')->get();
                                                    @endphp
                                                    <div class="entry"><span onclick="window.location='{{route('chart_of_account.edit',$head->head_id)}}'"><b data-toggle="tooltip" title="{{$head->head_name}}">{{substr($head->head_name, 0, 12)}}</b></span>
                                                        <div class="branch">
                                                            @forelse($sub_heads as $sub_head)
                                                                @php
                                                                    $child_heads = \App\Chartofaccount::where('sister_concern_id', $id)->where('head_id', $head->head_id)->where('sub_head_id',$sub_head->sub_head_id)->where('child_head_id','!=', 0)->orderBy('id', 'DESC')->get();
                                                                @endphp
                                                                <div class="entry"><span onclick="window.location='{{route('chart_of_account.edit',$sub_head->sub_head_id)}}'"><b data-toggle="tooltip" title="{{$sub_head->sub_head_name}}">{{substr($sub_head->sub_head_name, 0, 12)}}</b></span>
                                                                <div class="branch">
                                                                    @forelse($child_heads as $child_head)
                                                                        <div class="entry"><span onclick="window.location='{{route('chart_of_account.edit',$child_head->child_head_id)}}'"><b data-toggle="tooltip" title="{{$child_head->child_head_name}}">{{substr($child_head->child_head_name, 0, 12)}}</b></span></div>
                                                                    @empty
                                                                        <div class="entry"><span><b class="text-danger">No Data Found !!!</b></span></div>
                                                                    @endforelse
                                                                </div>
                                                                </div>
                                                            @empty
                                                                <div class="entry"><span><b class="text-danger">No Data Found !!!</b></span></div>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="entry"><span><b class="text-danger">No Data Found !!!</b></span></div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
