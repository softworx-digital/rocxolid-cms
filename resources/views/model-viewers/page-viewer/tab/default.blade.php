<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                {!! $component->render('include.general-data') !!}
            </div>
            <div class="col-md-6 col-xs-12">
                {!! $component->render('include.meta-data') !!}
                {!! $component->render('include.extended-data') !!}
            </div>
        @if (false)
            <div class="col-md-4 col-xs-12">
                {!! $component->render('include.opengraph-data') !!}
            </div>
        @endif
        </div>
    </div>
</div>