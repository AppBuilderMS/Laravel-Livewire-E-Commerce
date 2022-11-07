<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    @isset($breadcrumbs)
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item {{ !isset($breadcrumb['link']) ? 'active' :''}}">
                                @if(isset($breadcrumb['link']))
                                    <a href="{{asset($breadcrumb['link'])}}">
                                        @if($breadcrumb['name'] == 'Home')
                                            <i class="feather icon-home"></i>
                                        @else
                                            {{$breadcrumb['name']}}
                                        @endif
                                    </a>
                                @else
                                    {{$breadcrumb['name']}}
                                @endif
                            </li>
                        @endforeach
                    @endisset
                </ol>
            </div>
        </div>
    </div>
</div>
